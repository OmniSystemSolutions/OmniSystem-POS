<?php

namespace App\Http\Controllers;

use App\Models\OrderAndReservation;
use App\Models\OrderReservationDetail;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\CashEquivalent;
use App\Models\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderAndReservationController extends Controller
{
    // ─── Shared data for the form ─────────────────────────────────
    private function formData(): array
    {
        // ── Products (all, same logic as OrderController@create) ──
        $productsTransformed = \App\Models\Product::with(['category', 'subcategory'])->get()
            ->map(fn($p) => [
                'id'             => $p->id,
                'type'           => 'product',
                'sku'            => $p->code,
                'name'           => $p->name,
                'description'    => $p->description ?? '',
                'price'          => $p->price,
                'image'          => $p->image                              // ← fixed: storage path
                    ? asset('storage/' . $p->image)
                    : 'https://via.placeholder.com/300x200?text=No+Image',
                'subcategory_id' => $p->subcategory_id,
                'category_id'    => $p->category_id,
            ]);

        // ── Components (for_sale only, same logic as OrderController@create) ──
        $componentsTransformed = Component::with(['category', 'subcategory'])
            ->where('for_sale', '!=', 0)
            ->get()
            ->map(fn($c) => [
                'id'             => $c->id,
                'type'           => 'component',
                'sku'            => $c->code,
                'name'           => $c->name,
                'description'    => $c->description ?? '',
                'price'          => $c->price,
                'image'          => $c->image                              // ← fixed: storage path
                    ? asset('storage/' . $c->image)
                    : 'https://via.placeholder.com/300x200?text=No+Image',
                'subcategory_id' => $c->subcategory_id,
                'category_id'    => $c->category_id,
            ]);

        // ── Categories (filter empty subcategories, same as OrderController@create) ──
        $categories = \App\Models\Category::with([
            'subcategories' => function ($query) {
                $query->with([
                    'products',
                    'components' => fn($c) => $c->where('for_sale', '!=', 0),
                ]);
            },
        ])->get()->filter(function ($category) {
            $category->subcategories = $category->subcategories->filter(function ($sub) {
                return ($sub->products && $sub->products->count() > 0)
                    || ($sub->components && $sub->components->count() > 0);
            })->values();
            return $category->subcategories->count() > 0;
        })->values();

        return [
            'customers'          => Customer::orderBy('customer_name')->get(),
            'paymentMethods'     => Payment::orderBy('name')->get(['id', 'name']),
            'paymentDestinations'=> CashEquivalent::orderBy('name')->get(['id', 'name']),
            'categories'         => $categories,
            // ← merged products + components, same as OrderController
            'products'           => $productsTransformed->merge($componentsTransformed)->values(),
            'nextReferenceNo'    => $this->generateReferenceNo(),
        ];
    }

    private function generateReferenceNo(): string
    {
        $last = OrderAndReservation::latest('id')->value('reference_number');

        if ($last && preg_match('/(\d+)$/', $last, $matches)) {
            $next = (int) $matches[1] + 1;
        } else {
            $next = 1;
        }

        return 'RSV-' . str_pad($next, 7, '0', STR_PAD_LEFT);
    }

    // ─── Index ────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $status          = $request->get('status', 'reservations');
        $currentBranchId = current_branch_id();   // ← same global helper used in OrderController

        $reservations = OrderAndReservation::with([
                'customer',
                'payment',
                'cashEquivalent',
                'createdBy',
                'details.product',
                'details.component',
            ])
            ->where('branch_id', $currentBranchId)   // ← SCOPE TO BRANCH
            ->where('status', $status)
            ->latest()
            ->get();

        $customers = Customer::orderBy('customer_name')->get();

        return view('order-reservations.index', compact('reservations', 'status', 'customers'));
    }

    // ─── Create ───────────────────────────────────────────────────
    public function create()
    {
        return view('order-reservations.create', $this->formData());
    }

    // ─── Store ────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'reservation_date'   => 'required|date',
            'reservation_time'   => 'required',
            'type_of_reservation'=> 'required|string',
            'payment_method_id'  => 'nullable|exists:payments,id',
            'cash_equivalent_id' => 'nullable|exists:cash_equivalents,id',
        ]);

        DB::transaction(function () use ($request) {
            $reservation = OrderAndReservation::create([
                'branch_id'           => current_branch_id(),   // ← SAVE BRANCH
                'reference_number'    => $this->generateReferenceNo(),
                'customer_id'         => $request->customer_id,
                'type_of_reservation' => $request->type_of_reservation,
                'reservation_date'    => $request->reservation_date,
                'reservation_time'    => $request->reservation_time,
                'number_of_guest'     => $request->number_of_guest,
                'downpayment_amount'  => $request->downpayment_amount ?? 0,
                'payment_method_id'   => $request->payment_method_id,
                'cash_equivalent_id'  => $request->cash_equivalent_id,
                'special_request'     => $request->special_request,
                'gross_amount'        => $request->gross_amount ?? 0,
                'status'              => 'reservations',
                'created_by'          => Auth::id(),
            ]);

            if ($request->has('order_details')) {
                foreach ($request->order_details as $detail) {
                    $reservation->details()->create([
                        'product_id'   => $detail['product_id']   ?? null,
                        'component_id' => $detail['component_id'] ?? null,
                        'quantity'     => $detail['quantity'],
                        'price'        => $detail['price'],
                        'discount'     => $detail['discount']      ?? 0,
                        'notes'        => $detail['notes']         ?? null,
                        'status'       => $detail['status']        ?? 'serving',
                    ]);
                }
            }
        });

        return response()->json([
            'message'  => 'Reservation created successfully.',
            'redirect' => route('order-reservations.index'),
        ]);
    }

    // ─── Edit ─────────────────────────────────────────────────────
    public function edit(OrderAndReservation $orderReservation)
    {
        // Ensure the reservation belongs to the current branch
        abort_if($orderReservation->branch_id != current_branch_id(), 403);

        $orderReservation->load(['customer', 'details.product', 'details.component', 'payment', 'cashEquivalent']);

        return view('order-reservations.edit', array_merge(
            $this->formData(),
            ['reservation' => $orderReservation]
        ));
    }

    // ─── Update ───────────────────────────────────────────────────
    public function update(Request $request, OrderAndReservation $orderReservation)
    {
        abort_if($orderReservation->branch_id != current_branch_id(), 403);

        $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'reservation_date'   => 'required|date',
            'reservation_time'   => 'required',
            'type_of_reservation'=> 'required|string',
            'payment_method_id'  => 'nullable|exists:payments,id',
            'cash_equivalent_id' => 'nullable|exists:cash_equivalents,id',
        ]);

        DB::transaction(function () use ($request, $orderReservation) {
            $orderReservation->update([
                'customer_id'         => $request->customer_id,
                'type_of_reservation' => $request->type_of_reservation,
                'reservation_date'    => $request->reservation_date,
                'reservation_time'    => $request->reservation_time,
                'number_of_guest'     => $request->number_of_guest,
                'downpayment_amount'  => $request->downpayment_amount ?? 0,
                'payment_method_id'   => $request->payment_method_id,
                'cash_equivalent_id'  => $request->cash_equivalent_id,
                'special_request'     => $request->special_request,
                'gross_amount'        => $request->gross_amount ?? 0,
            ]);

            $orderReservation->details()->delete();

            if ($request->has('order_details')) {
                foreach ($request->order_details as $detail) {
                    $orderReservation->details()->create([
                        'product_id'   => $detail['product_id']   ?? null,
                        'component_id' => $detail['component_id'] ?? null,
                        'quantity'     => $detail['quantity'],
                        'price'        => $detail['price'],
                        'discount'     => $detail['discount']      ?? 0,
                        'notes'        => $detail['notes']         ?? null,
                        'status'       => $detail['status']        ?? 'serving',
                    ]);
                }
            }
        });

        return response()->json([
            'message'  => 'Reservation updated successfully.',
            'redirect' => route('order-reservations.index'),
        ]);
    }

    // ─── Ready for Service ────────────────────────────────────────
    public function readyForService(Request $request, OrderAndReservation $orderReservation)
    {
        abort_if($orderReservation->branch_id != current_branch_id(), 403);

        $request->validate([
            'table_no' => 'required|integer|min:1',
            'pax'      => 'nullable|integer|min:1',
        ]);

        $userId   = Auth::id();
        $branchId = current_branch_id();

        DB::transaction(function () use ($request, $orderReservation, $userId, $branchId) {

            $order = \App\Models\Order::create([
                'user_id'        => $userId,
                'branch_id'      => $branchId,
                'table_no'       => $request->table_no,
                'number_pax'     => $request->pax ?? $orderReservation->number_of_guest ?? 1,
                'status'         => 'serving',
                'order_type'     => 'Dine-In',
                'gross_amount'   => $orderReservation->gross_amount ?? 0,
                'cashier_id'     => $userId,
                'time_submitted' => now(),
                'reservation_id' => $orderReservation->id,
            ]);

            foreach ($orderReservation->details as $detail) {
                $itemName = $detail->product?->name
                    ?? $detail->component?->name
                    ?? $detail->notes
                    ?? 'Item';

                $order->details()->create([
                    'product_id'   => $detail->product_id,
                    'component_id' => $detail->component_id,
                    'item_name'    => $itemName,
                    'quantity'     => $detail->quantity,
                    'price'        => $detail->price,
                    'discount'     => $detail->discount ?? 0,
                    'notes'        => $detail->notes,
                    'status'       => 'serving',
                ]);
            }

            $orderReservation->update([
                'status'   => 'ready_for_service',
                'order_id' => $order->id,
            ]);
        });

        return response()->json([
            'success'  => true,
            'message'  => 'Reservation moved to Ready for Service.',
            'order_id' => \App\Models\Order::where('reservation_id', $orderReservation->id)->latest()->value('id'),
        ]);
    }

    // ─── Archive / Restore / Delete ───────────────────────────────
    public function archive(OrderAndReservation $orderReservation)
    {
        abort_if($orderReservation->branch_id != current_branch_id(), 403);
        $orderReservation->update(['status' => 'prepared_service']);
        return back()->with('success', 'Moved to Prepared Service.');
    }

    public function restore(OrderAndReservation $orderReservation)
    {
        abort_if($orderReservation->branch_id != current_branch_id(), 403);
        $orderReservation->update(['status' => 'reservations']);
        return back()->with('success', 'Restored to Reservations.');
    }

    public function destroy(OrderAndReservation $orderReservation)
    {
        abort_if($orderReservation->branch_id != current_branch_id(), 403);
        $orderReservation->delete();
        return back()->with('success', 'Deleted permanently.');
    }

    // ─── Invoice (optional) ───────────────────────────────────────
    public function invoice(OrderAndReservation $orderReservation)
    {
        abort_if($orderReservation->branch_id != current_branch_id(), 403);
        $orderReservation->load(['customer', 'details.product', 'details.component']);
        return view('order-reservations.invoice', compact('orderReservation'));
    }
}