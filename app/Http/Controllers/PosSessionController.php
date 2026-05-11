<?php

namespace App\Http\Controllers;

use App\Models\CashAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\PaymentDetail;
use App\Models\Payment;
use App\Models\CashEquivalent;

class PosSessionController extends Controller
{
    /**
     * 🔹 Open a new cash audit session (cashier starts shift)
     */
    public function openSession(Request $request)
    {
        $validated = $request->validate([
            'terminal_no' => 'required|string|max:50',
            'cash_fund'   => 'required|numeric|min:0',
            'force_close_old' => 'sometimes|boolean', // ← This is the key!
        ]);

        $branchId   = current_branch_id();
        $cashierId  = auth()->id();
        $terminalNo = $validated['terminal_no'];

        // 1. Check if THIS terminal already has open session
        $existing = CashAudit::where('branch_id', $branchId)
            ->where('terminal_no', $terminalNo)
            ->where('status', 'open')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'This terminal already has an open session.',
            ], 409);
        }

        // 2. Check if user has open session on DIFFERENT terminal in SAME branch
        $oldSession = CashAudit::where('branch_id', $branchId)
            ->where('cashier_id', $cashierId)
            ->where('terminal_no', '!=', $terminalNo)
            ->where('status', 'open')
            ->first();

        // If user didn't confirm closing old session → BLOCK
        if ($oldSession && empty($validated['force_close_old'])) {
            return response()->json([
                'success' => false,
                'message' => 'You have an open session on another terminal.',
                'warning' => true,
                'old_terminal' => $oldSession->terminal_no,
                'requires_confirmation' => true,
            ], 422);
        }

        // 3. User confirmed → close old session
        if ($oldSession && $validated['force_close_old']) {
            $oldSession->update([
                'status'    => 'closed',
                'closed_at' => now(),
                'remarks'   => 'Closed: Cashier moved to terminal ' . $terminalNo,
            ]);
        }

        // 4. Create new session
        $session = CashAudit::create([
            'branch_id'            => $branchId,
            'cashier_id'           => $cashierId,
            'terminal_no'          => $terminalNo,
            'transaction_datetime' => now(),
            'starting_fund'        => $validated['cash_fund'],
            'status'               => 'open',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'POS session started successfully!',
            'session' => $session,
        ], 201);
    }

    /**
     * 🔍 Check if there’s an active (open) cash audit session for this terminal
     */
    public function checkSession(Request $request)
    {
        $terminalNo = $request->query('terminal_no');
        if (!$terminalNo) {
            return response()->json(['success' => false, 'message' => 'Missing terminal_no'], 400);
        }

        $branchId  = current_branch_id();
        $cashierId = auth()->id();

        // 1. Check if session exists on THIS terminal
        $currentSession = CashAudit::where('branch_id', $branchId)
            ->where('terminal_no', $terminalNo)
            ->where('status', 'open')
            ->first();

        if ($currentSession) {
            return response()->json([
                'has_open_session' => true,
                'on_this_terminal' => true,
                'transaction_datetime' => $currentSession->transaction_datetime, // ← FIRST!
                'session' => [
                    'id'               => $currentSession->id,
                    'terminal_no'      => $currentSession->terminal_no,
                    'starting_fund'    => $currentSession->starting_fund,
                    'status'           => $currentSession->status,
                ],
                'message' => 'Session active on this terminal.',
            ]);
        }

        // 2. Conflict: open session on another terminal
        $conflictSession = CashAudit::where('branch_id', $branchId)
            ->where('cashier_id', $cashierId)
            ->where('terminal_no', '!=', $terminalNo)
            ->where('status', 'open')
            ->first();


        $startingFund = DB::table('fund_transfers as ft')
            ->leftJoin('cash_equivalents as ce', 'ft.to_cash_equivalent_id', '=', 'ce.id')
            ->leftJoin('users as u', 'u.id', '=', 'ce.accountable_id')
            ->where('ft.status', 'approved')
            ->where('u.id', $cashierId) // important
            ->latest('ft.id')
            ->value('ft.amount');


        if ($conflictSession) {
            return response()->json([
                'has_open_session' => false,
                'conflict'         => true,
                'old_terminal'     => $conflictSession->terminal_no,
                'transaction_datetime' => $conflictSession->transaction_datetime, // ← Also send here
                'message'          => 'Open session found on another terminal.',
            ]);
        }

        // 3. No session
        return response()->json([
            'has_open_session' => false,
            'conflict'         => false,
            'transaction_datetime' => null,
            'starting_fund' => $startingFund ?? 0,
            'message'          => 'No active session.',
        ]);
    }
    public function closeSession(Request $request)
    {
        $cashierId  = auth()->id();
        $branchId   = current_branch_id();
        $terminalNo = $request->input('terminal_no');

        $validated = $request->validate([
            'terminal_no'           => 'required|string|max:50',
            'transaction_datetime'  => 'required|date_format:Y-m-d H:i:s',
            'starting_fund'         => 'nullable|numeric|min:0',
            'tip'                   => 'nullable|numeric|min:0',
            'transfer_to'           => 'nullable|string|max:100',
            'transfer_amount'       => 'nullable|numeric|min:0',
            'remarks'               => 'nullable|string|max:1000',
            'manual_breakdown'      => 'nullable|array',
            'manual_breakdown.*'    => 'numeric|min:0',
            'd_1000' => 'nullable|integer|min:0',
            'd_500'  => 'nullable|integer|min:0',
            'd_200'  => 'nullable|integer|min:0',
            'd_100'  => 'nullable|integer|min:0',
            'd_50'   => 'nullable|integer|min:0',
            'd_20'   => 'nullable|integer|min:0',
            'd_10'   => 'nullable|integer|min:0',
            'd_5'    => 'nullable|integer|min:0',
            'd_1'    => 'nullable|integer|min:0',
            'd_050'  => 'nullable|integer|min:0',
            'd_025'  => 'nullable|integer|min:0',
            'd_010'  => 'nullable|integer|min:0',
            'd_005'  => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Find open session for THIS cashier + terminal
            $session = CashAudit::where('cashier_id', $cashierId)
                ->where('branch_id', $branchId)
                ->where('terminal_no', $terminalNo)
                ->where('status', 'open')
                ->firstOrFail();

            $closeTime = Carbon::parse($validated['transaction_datetime']);

            // Get payments in session period
            $paymentDetails = PaymentDetail::with(['payment', 'cashEquivalent'])
                ->whereHas('order', fn($q) => $q->where('cashier_id', $cashierId))
                ->whereBetween('created_at', [$session->created_at, $closeTime])
                ->get();

            // Inside closeSession() — after $paymentDetails query
            $breakdown = [];

            foreach ($paymentDetails as $pd) {
                $amountPaid = $pd->amount_paid ?? 0;
                $change     = $pd->change_amount ?? 0;

                // Parent: Payment or CashEquivalent name
                $parentName = $pd->payment?->name ?? $pd->cashEquivalent?->name ?? 'Unknown';
                $parentSlug = $this->makeSlug($parentName);

                // Sub-type: only if cash_equivalent_id is used
                $subName = $pd->cashEquivalent?->name;
                $subSlug = $subName ? $this->makeSlug($subName) : null;

                $isCash = str_contains(strtolower($parentName), 'cash');
                $finalAmount = $isCash ? ($amountPaid - $change) : $amountPaid;

                // Initialize parent
                if (!isset($breakdown[$parentSlug])) {
                    $breakdown[$parentSlug] = [
                        'name'  => $parentName,
                        'total' => 0,
                        'breakdown' => []
                    ];
                }

                $breakdown[$parentSlug]['total'] += $finalAmount;

                if ($subSlug && $subName) {
                    $breakdown[$parentSlug]['breakdown'][$subSlug] = [
                        'name'   => $subName,
                        'amount' => ($breakdown[$parentSlug]['breakdown'][$subSlug]['amount'] ?? 0) + $finalAmount
                    ];
                }
            }

            // Round everything
            foreach ($breakdown as $slug => $group) {
                $breakdown[$slug]['total'] = round($group['total'], 2);
                foreach ($group['breakdown'] as $subSlug => $item) {
                    $breakdown[$slug]['breakdown'][$subSlug]['amount'] = round($item['amount'], 2);
                }

                // Convert breakdown array → key = name, value = amount
                $cleanBreakdown = [];
                foreach ($group['breakdown'] as $item) {
                    $cleanBreakdown[$item['name']] = $item['amount'];
                }
                $breakdown[$slug]['breakdown'] = $cleanBreakdown;

                // If no sub-items → just store the total (like Cash, GCash)
                if (empty($cleanBreakdown)) {
                    $breakdown[$slug] = $breakdown[$slug]['total'];
                }
            }

            // Calculations — 100% SAFE FROM OPERAND ERRORS
            $startingFund = (float)($validated['starting_fund'] ?? $session->starting_fund ?? 0);
            $tip          = (float)($validated['tip'] ?? 0);
            $transferOut  = (float)($validated['transfer_amount'] ?? 0);

            // SAFELY extract cash sales from breakdown (handles number OR array)
            $cashSales = 0;
            if (isset($breakdown['cash'])) {
                $cashSales = is_array($breakdown['cash']) ? ($breakdown['cash']['total'] ?? 0) : $breakdown['cash'];
            } elseif (isset($breakdown['cash_on_hand'])) {
                $cashSales = is_array($breakdown['cash_on_hand']) ? ($breakdown['cash_on_hand']['total'] ?? 0) : $breakdown['cash_on_hand'];
            }

            // Now 100% safe math
            $expectedCash = $startingFund + $cashSales;
            $countedCash  = $this->calculateTotalCashCounted($validated);

            $diff     = round($countedCash - $expectedCash, 2);
            $shortage = $diff < 0 ? abs($diff) : 0.00;
            $overage  = $diff > 0 ? $diff : 0.00;

            // Optional: Total sales (safe version)
            $totalSales = collect($breakdown)->sum(fn($item) => is_array($item) ? ($item['total'] ?? 0) : $item);

            $reference_no = sprintf('TRN-%02d-%05d', $branchId, $session->id);

            // Save
            $session->update([
                'transaction_datetime' => $closeTime,
                'reference_no'         => $reference_no,
                'starting_fund'        => $startingFund,
                'payment_breakdown'    => $breakdown,
                'receivable'           => 0.00,
                'shortage'             => $shortage,
                'overage'              => $overage,
                'tip'                  => $tip,
                'transfer_to'          => $validated['transfer_to'] ?? null,
                'transfer_amount'      => $transferOut,
                'remarks'              => $validated['remarks'] ?? null,
                'status'               => 'pending',
                'closed_at'            => now(),
                'd_1000' => $validated['d_1000'] ?? null,
                'd_500'  => $validated['d_500']  ?? null,
                'd_200'  => $validated['d_200']  ?? null,
                'd_100'  => $validated['d_100']  ?? null,
                'd_50'   => $validated['d_50']   ?? null,
                'd_20'   => $validated['d_20']   ?? null,
                'd_10'   => $validated['d_10']   ?? null,
                'd_5'    => $validated['d_5']    ?? null,
                'd_1'    => $validated['d_1']    ?? null,
                'd_050'  => $validated['d_050']  ?? null,
                'd_025'  => $validated['d_025']  ?? null,
                'd_010'  => $validated['d_010']  ?? null,
                'd_005'  => $validated['d_005']  ?? null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Session closed successfully!',
                'reference_no' => $session->reference_no
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Close Session Failed: ' . $e->getMessage(), $request->all());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), // Show real error in dev
            ], 500);
        }
    }

    private function calculateTotalCashCounted(array $data): float
    {
        return ($data['d_1000'] ?? 0) * 1000 +
            ($data['d_500']  ?? 0) * 500  +
            ($data['d_200']  ?? 0) * 200  +
            ($data['d_100']  ?? 0) * 100  +
            ($data['d_50']   ?? 0) * 50   +
            ($data['d_20']   ?? 0) * 20   +
            ($data['d_10']   ?? 0) * 10   +
            ($data['d_5']    ?? 0) * 5    +
            ($data['d_1']    ?? 0) * 1    +
            ($data['d_050']  ?? 0) * 0.50 +
            ($data['d_025']  ?? 0) * 0.25 +
            ($data['d_010']  ?? 0) * 0.10 +
            ($data['d_005']  ?? 0) * 0.05;
    }

    // Helper function (put it inside controller or as a trait)
    private function makeSlug(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);
        $text = preg_replace('/\s+/', '_', $text);
        $text = strtolower($text);
        $text = preg_replace('/^_+|_+$/', '', $text);
        return $text ?: 'unknown';
    }
}
