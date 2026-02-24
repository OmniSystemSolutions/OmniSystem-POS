@extends('layouts.app')
@section('content')

{{-- ── Match the orders index dropdown positioning fix ── --}}
<style>
.dropdown-menu {
    position: relative !important;
    transform: translate(0px, 0px) !important;
}
</style>

<div class="main-content">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Orders and Reservations</h1>
            <ul>
                <li><a href="">Sales</a></li>
            </ul>
            <div class="breadcrumb-action"></div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>

    <div class="wrapper">
        <div class="card mt-4">

            {{-- NAV TABS --}}
            <nav class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a href="{{ route('order-reservations.index', ['status' => 'reservations']) }}"
                           class="nav-link {{ $status === 'reservations' ? 'active' : '' }}">
                            Reservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('order-reservations.index', ['status' => 'prepared_service']) }}"
                           class="nav-link {{ $status === 'prepared_service' ? 'active' : '' }}">
                            Prepared Service
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('order-reservations.index', ['status' => 'ready_for_service']) }}"
                           class="nav-link {{ $status === 'ready_for_service' ? 'active' : '' }}">
                            Ready for Service
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="card-body">
                <div class="vgt-wrap">
                    <div class="vgt-inner-wrap">

                        {{-- SEARCH + ADD --}}
                        <div class="vgt-global-search vgt-clearfix">
                            <div class="vgt-global-search__input vgt-pull-left">
                                <form role="search">
                                    <label for="tableSearch">
                                        <span aria-hidden="true" class="input__icon">
                                            <div class="magnifying-glass"></div>
                                        </span>
                                        <span class="sr-only">Search</span>
                                    </label>
                                    <input
                                        id="tableSearch"
                                        type="text"
                                        placeholder="Search this table"
                                        class="vgt-input vgt-pull-left"
                                        onkeyup="filterTable(this.value)"
                                    >
                                </form>
                            </div>
                            <div class="vgt-global-search__actions vgt-pull-right">
                                <a href="{{ route('order-reservations.create') }}"
                                   class="btn mx-1 btn-primary btn-icon">
                                    <i class="i-Add"></i> Add
                                </a>
                            </div>
                        </div>

                        {{-- TABLE --}}
                        <div class="vgt-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table id="reservationsTable" class="table-hover tableOne vgt-table custom-vgt-table">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">
                                            <input type="checkbox" id="selectAll" onchange="toggleAll(this)">
                                        </th>
                                        <th class="vgt-left-align sortable"><span>Date and Time Created</span></th>
                                        <th class="vgt-left-align sortable"><span>Created By</span></th>
                                        <th class="vgt-left-align sortable"><span>Reference #</span></th>
                                        <th class="vgt-left-align sortable"><span>Customer Name</span></th>
                                        <th class="vgt-left-align"><span>Date of Reservation</span></th>
                                        <th class="vgt-left-align"><span>Time of Reservation</span></th>
                                        <th class="vgt-left-align"><span>Status</span></th>
                                        <th class="vgt-left-align"><span>Special Request</span></th>
                                        <th class="vgt-left-align text-right"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reservations as $reservation)
                                    <tr>
                                        <td><input type="checkbox" class="row-checkbox" value="{{ $reservation->id }}"></td>
                                        <td>{{ $reservation->created_at->timezone('Asia/Manila')->format('Y-m-d h:i A') }}</td>
                                        <td>{{ $reservation->createdBy?->name ?? '—' }}</td>
                                        <td>{{ $reservation->reference_number }}</td>
                                        <td>{{ $reservation->customer?->customer_name ?? '—' }}</td>
                                        <td>
                                            {{ $reservation->reservation_date
                                                ? \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y')
                                                : '—' }}
                                        </td>
                                        <td>
                                            {{ $reservation->reservation_time
                                                ? \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A')
                                                : '—' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-{{
                                                $reservation->status === 'ready_for_service' ? 'danger' :
                                                ($reservation->status === 'prepared_service' ? 'info' : 'success')
                                            }}">
                                                {{
                                                    $reservation->status === 'reservations'      ? 'Reservations' :
                                                    ($reservation->status === 'prepared_service' ? 'Prepared Service' : 'Ready for Service')
                                                }}
                                            </span>
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn mx-1 btn-primary btn-icon"
                                                data-bs-toggle="modal"
                                                data-bs-target="#specialRequestModal{{ $reservation->id }}">
                                                View
                                            </button>
                                        </td>

                                        {{-- ── ACTION COLUMN — matches orders/index style ── --}}
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <button
                                                    type="button"
                                                    class="btn btn-link p-0"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    style="font-size:22px; line-height:1; color:#555;">
                                                    &#8942;
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width:220px; font-size:14px;">

                                                    {{-- View / Invoice --}}
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#specialRequestModal{{ $reservation->id }}">
                                                            <i class="i-File-Search" style="font-size:15px; width:18px;"></i>
                                                            View
                                                        </a>
                                                    </li>

                                                    {{-- Edit — only on Reservations tab --}}
                                                    @if($reservation->status === 'reservations')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           href="{{ route('order-reservations.edit', $reservation) }}">
                                                            <i class="i-Pen-2" style="font-size:15px; width:18px;"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    @endif

                                                    {{-- Move to Prepared Service --}}
                                                    @if($reservation->status === 'reservations')
                                                    <li>
                                                        <form action="{{ route('order-reservations.archive', $reservation) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                                                <i class="i-Box-Full" style="font-size:15px; width:18px;"></i>
                                                                Move to Prepared Service
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif

                                                    {{-- Move to Ready for Service --}}
                                                    @if($reservation->status === 'prepared_service')
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           href="#"
                                                           onclick="openReadyForServiceModal({{ $reservation->id }}, {{ $reservation->number_of_guest ?? 1 }})">
                                                            <i class="i-Arrow-Right" style="font-size:15px; width:18px;"></i>
                                                            Move to Ready for Service
                                                        </a>
                                                    </li>
                                                    @endif

                                                    {{-- Restore to Reservations --}}
                                                    @if($reservation->status === 'ready_for_service')
                                                    <li>
                                                        <form action="{{ route('order-reservations.restore', $reservation) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                                                <i class="i-Repeat-2" style="font-size:15px; width:18px;"></i>
                                                                Restore to Reservations
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif

                                                    <li><hr class="dropdown-divider"></li>

                                                    {{-- Remarks --}}
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#remarksModal{{ $reservation->id }}">
                                                            <i class="i-Speach-Bubble" style="font-size:15px; width:18px;"></i>
                                                            Remarks
                                                        </a>
                                                    </li>

                                                    {{-- Attachments --}}
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#attachmentModal{{ $reservation->id }}">
                                                            <i class="i-Attach" style="font-size:15px; width:18px;"></i>
                                                            Add Attachments
                                                        </a>
                                                    </li>

                                                    {{-- Logs --}}
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#logsModal{{ $reservation->id }}">
                                                            <i class="i-Clock" style="font-size:15px; width:18px;"></i>
                                                            Logs
                                                        </a>
                                                    </li>

                                                    {{-- Delete — only on Ready for Service tab, styled red like orders index --}}
                                                    @if($reservation->status === 'ready_for_service')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('order-reservations.destroy', $reservation) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Delete permanently?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center gap-2"
                                                                    style="color: #e74c3c;">
                                                                <i class="i-Trash" style="font-size:15px; width:18px; color:#e74c3c;"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </td>
                                        {{-- ── END ACTION COLUMN ── --}}

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="vgt-center-align vgt-text-disabled">
                                            No reservations found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- END TABLE --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     MODALS (per reservation)
     ============================================================ --}}
@foreach($reservations as $reservation)

    {{-- View / Special Request + Order Details Modal --}}
    <div class="modal fade" id="specialRequestModal{{ $reservation->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="i-File-Search me-2"></i>
                        Reservation Details — {{ $reservation->reference_number }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <small class="text-muted d-block">Customer</small>
                            <strong>{{ $reservation->customer?->customer_name ?? '—' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Reference #</small>
                            <strong>{{ $reservation->reference_number }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Date of Reservation</small>
                            <strong>
                                {{ $reservation->reservation_date
                                    ? \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y')
                                    : '—' }}
                            </strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Time of Reservation</small>
                            <strong>
                                {{ $reservation->reservation_time
                                    ? \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A')
                                    : '—' }}
                            </strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Type</small>
                            <strong>{{ $reservation->type_of_reservation ?? '—' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">No. of Guests</small>
                            <strong>{{ $reservation->number_of_guest ?? '—' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge badge-{{
                                $reservation->status === 'ready_for_service' ? 'danger' :
                                ($reservation->status === 'prepared_service' ? 'info' : 'success')
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block">Grand Total</small>
                            <strong>₱ {{ number_format($reservation->gross_amount ?? 0, 2) }}</strong>
                        </div>
                    </div>
                    <div class="card bg-light mb-3">
                        <div class="card-body py-2 px-3">
                            <small class="text-muted fw-bold d-block mb-1">
                                <i class="i-Speach-Bubble me-1"></i> Special Request / Notes
                            </small>
                            <p class="mb-0" style="white-space: pre-wrap;">
                                {{ $reservation->special_request ?? 'No notes provided.' }}
                            </p>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-2"><i class="i-Bag me-1"></i> Order Details</h6>
                    @if($reservation->details && $reservation->details->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm vgt-table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>SKU</th>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Discount</th>
                                    <th>Note</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation->details as $detail)
                                @php
                                    $item     = $detail->product ?? $detail->component;
                                    $subtotal = ($detail->quantity * $detail->price) - ($detail->discount ?? 0);
                                @endphp
                                <tr>
                                    <td>{{ $item?->code ?? '—' }}</td>
                                    <td>{{ $item?->name ?? '—' }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-right">{{ number_format($detail->price, 2) }}</td>
                                    <td class="text-right">{{ number_format($subtotal, 2) }}</td>
                                    <td class="text-right">{{ $detail->discount > 0 ? number_format($detail->discount, 2) : '—' }}</td>
                                    <td>{{ $detail->notes ?? '—' }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $detail->status === 'done' ? 'success' : ($detail->status === 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($detail->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-right fw-bold">Grand Total:</td>
                                    <td class="text-right fw-bold">
                                        ₱ {{ number_format($reservation->details->sum(fn($d) => ($d->quantity * $d->price) - ($d->discount ?? 0)), 2) }}
                                    </td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="i-Bag" style="font-size:30px; opacity:0.3;"></i>
                            <p class="mt-2 mb-0">No order details available.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Attachment Modal --}}
    <div class="modal fade" id="attachmentModal{{ $reservation->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="i-Attach me-2"></i> Add Attachments</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="fw-bold">File</label>
                            <input type="file" name="attachment" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Optional description">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Logs Modal --}}
    <div class="modal fade" id="logsModal{{ $reservation->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="i-Clock me-2"></i> Activity Logs — {{ $reservation->reference_number }}
                    </h5>
                </div>
                <div class="modal-body">
                    @if(isset($reservation->logs) && $reservation->logs->count())
                        <ul class="list-group list-group-flush">
                            @foreach($reservation->logs as $log)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $log->description }}</span>
                                    <small class="text-muted">{{ $log->created_at->format('Y-m-d h:i A') }}</small>
                                </div>
                                <small class="text-muted">by {{ $log->causer?->name ?? 'System' }}</small>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center py-3">No activity logs found.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Remarks Modal --}}
    <div class="modal fade" id="remarksModal{{ $reservation->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="i-Speach-Bubble me-2"></i> Remarks — {{ $reservation->reference_number }}
                    </h5>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="fw-bold">Remark</label>
                            <textarea name="remark" class="form-control" rows="4" placeholder="Enter your remark..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Remark</button>
                    </form>
                    @if(isset($reservation->remarks) && $reservation->remarks->count())
                    <hr>
                    <h6 class="mt-3">Previous Remarks</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($reservation->remarks as $remark)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span>{{ $remark->remark }}</span>
                                <small class="text-muted">{{ $remark->created_at->format('Y-m-d h:i A') }}</small>
                            </div>
                            <small class="text-muted">by {{ $remark->user?->name ?? '—' }}</small>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endforeach
{{-- END MODALS --}}

{{-- Ready for Service Modal --}}
<div class="modal fade" id="readyForServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="i-Arrow-Right me-2 text-success"></i>
                    Move to Ready for Service
                </h5>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">
                    Enter the <strong>POS Table Number</strong> for this reservation.
                    This will create an order in the POS Serving tab.
                </p>
                <input type="hidden" id="rfs_reservation_id" value="">
                <div class="mb-3">
                    <label class="fw-bold">Table No. <span class="text-danger">*</span></label>
                    <input type="number" id="rfs_table_no" class="form-control" min="1" placeholder="e.g. 5" autofocus />
                    <div class="form-text text-muted">Physical table number in the restaurant.</div>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Number of Pax</label>
                    <input type="number" id="rfs_pax" class="form-control" min="1" value="1" />
                </div>
                <div id="rfs_error" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="rfs_confirm_btn" onclick="confirmReadyForService()">
                    <i class="i-Arrow-Right me-1"></i> Confirm & Move
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('#reservationsTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function toggleAll(source) {
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = source.checked);
}

function openReadyForServiceModal(reservationId, numberOfGuest) {
    document.getElementById('rfs_reservation_id').value = reservationId;
    document.getElementById('rfs_pax').value = numberOfGuest || 1;
    document.getElementById('rfs_table_no').value = '';
    document.getElementById('rfs_error').classList.add('d-none');
    document.getElementById('rfs_confirm_btn').disabled = false;
    document.getElementById('rfs_confirm_btn').innerHTML = '<i class="i-Arrow-Right me-1"></i> Confirm & Move';
    new bootstrap.Modal(document.getElementById('readyForServiceModal')).show();
    document.getElementById('readyForServiceModal').addEventListener('shown.bs.modal', function onShown() {
        document.getElementById('rfs_table_no').focus();
        document.getElementById('readyForServiceModal').removeEventListener('shown.bs.modal', onShown);
    });
}

function confirmReadyForService() {
    const reservationId = document.getElementById('rfs_reservation_id').value;
    const tableNo       = document.getElementById('rfs_table_no').value;
    const pax           = document.getElementById('rfs_pax').value;
    const errorEl       = document.getElementById('rfs_error');
    const confirmBtn    = document.getElementById('rfs_confirm_btn');

    if (!tableNo || parseInt(tableNo) < 1) {
        errorEl.textContent = 'Please enter a valid Table No.';
        errorEl.classList.remove('d-none');
        document.getElementById('rfs_table_no').focus();
        return;
    }

    errorEl.classList.add('d-none');
    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';

    fetch(`/order-reservations/${reservationId}/ready-for-service`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ table_no: parseInt(tableNo), pax: parseInt(pax) }),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('readyForServiceModal')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Moved to Ready for Service!',
                html: `Reservation moved successfully.<br>
                       <small class="text-muted">POS Order #${data.order_id} created → Table ${tableNo}</small>`,
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
            }).then(() => window.location.reload());
        } else {
            errorEl.textContent = data.message || 'An error occurred. Please try again.';
            errorEl.classList.remove('d-none');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="i-Arrow-Right me-1"></i> Confirm & Move';
        }
    })
    .catch(err => {
        console.error('Ready for Service error:', err);
        errorEl.textContent = 'Network error. Please try again.';
        errorEl.classList.remove('d-none');
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = '<i class="i-Arrow-Right me-1"></i> Confirm & Move';
    });
}

document.getElementById('readyForServiceModal').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') confirmReadyForService();
});
</script>

@endsection