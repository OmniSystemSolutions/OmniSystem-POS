<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Discount;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');
        $activeCount = Customer::where('status', 'active')->count();

        $customers = Customer::with('discount')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customers.index', compact('customers', 'status', 'activeCount'));
    }

    /**
     * Show create form.
     * Accepts ?from=reservation&redirect_back=<url> to show source radio + banner.
     */
    public function create(Request $request)
    {
        $discounts = Discount::where('status', 'active')->get();

        $latestCustomer = Customer::latest()->first();
        $nextId = $latestCustomer ? $latestCustomer->id + 1 : 1;
        $generatedCustomerNo = 'CUS-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        return view('customers.create', compact('discounts', 'generatedCustomerNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'      => 'required|string|max:255',
            'company_name'       => 'nullable|string|max:255',
            'mobile_no'          => 'nullable|string|max:50',
            'landline_no'        => 'nullable|string|max:50',
            'email'              => 'nullable|email|max:255',
            'address'            => 'nullable|string|max:255',
            'assigned_personnel' => 'nullable|string|max:255',
            'province'           => 'nullable|string|max:255',
            'city_municipality'  => 'nullable|string|max:255',
            'credit_limit'       => 'nullable|numeric|min:0',
            'payment_terms_days' => 'nullable|string|max:100',
            'customer_type'      => 'nullable|string|max:255',
            'discount_id'        => 'nullable|exists:discounts,id',
            'customer_since'     => 'nullable|date',
            'from_source'        => 'nullable|string|max:50',
            'redirect_back'      => 'nullable|url',
            'customer_source'    => 'nullable|string|max:50',
        ]);

        // Auto-generate customer number
        $latestCustomer = Customer::latest()->first();
        $nextId = $latestCustomer ? $latestCustomer->id + 1 : 1;
        $validated['customer_no'] = 'CUS-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        Customer::create($validated);

        $fromSource   = $request->input('from_source', 'direct');
        $redirectBack = $request->input('redirect_back');

        // ── If from reservation: stay on create page so SweetAlert fires
        //    and user can close the tab manually ──
        if ($fromSource === 'reservation') {
            return redirect()
                ->route('customers.create', [
                    'from'          => 'reservation',
                    'redirect_back' => $redirectBack,
                ])
                ->with('success', 'Customer created successfully.');
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        $discounts = Discount::where('status', 'active')->get();
        return view('customers.edit', compact('customer', 'discounts'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'customer_name'      => 'required|string|max:255',
            'company_name'       => 'nullable|string|max:255',
            'mobile_no'          => 'nullable|string|max:50',
            'landline_no'        => 'nullable|string|max:50',
            'email'              => 'nullable|email|max:255',
            'address'            => 'nullable|string|max:255',
            'assigned_personnel' => 'nullable|string|max:255',
            'province'           => 'nullable|string|max:255',
            'city_municipality'  => 'nullable|string|max:255',
            'credit_limit'       => 'nullable|numeric|min:0',
            'payment_terms_days' => 'nullable|string|max:100',
            'customer_type'      => 'nullable|string|max:255',
            'discount_id'        => 'nullable|exists:discounts,id',
            'customer_since'     => 'nullable|date',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function archive(Customer $customer)
    {
        $customer->update(['status' => 'archived']);
        return redirect()->route('customers.index')->with('success', 'Customer archived successfully.');
    }

    public function restore(Customer $customer)
    {
        $customer->update(['status' => 'active']);
        return redirect()->route('customers.index')->with('success', 'Customer restored successfully.');
    }
}