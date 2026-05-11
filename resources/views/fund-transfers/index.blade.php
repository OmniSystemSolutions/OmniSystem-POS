@extends('layouts.app')
@section('content')

<div class="main-content">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Fund Transfers</h1>
            <ul>
                <li><a href=""> Finance </a></li>
            </ul>
            <div class="breadcrumb-action"></div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>

    <div class="card wrapper">
        <div class="card-body">

            {{-- Status Tabs --}}
            <nav class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a href="{{ route('fund-transfers.index', ['status' => 'pending']) }}"
                            class="nav-link {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('fund-transfers.index', ['status' => 'approved']) }}"
                            class="nav-link {{ $status === 'approved' ? 'active' : '' }}">Approved</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('fund-transfers.index', ['status' => 'archived']) }}"
                            class="nav-link {{ $status === 'archived' ? 'active' : '' }}">Archived</a>
                    </li>
                </ul>
            </nav>

            {{-- Search + Actions --}}
            <div class="vgt-wrap">
                <div class="vgt-inner-wrap">

                    <div class="vgt-global-search vgt-clearfix">
                        <div class="vgt-global-search__input vgt-pull-left">
                            <form>
                                <label for="vgt-search-transfer">
                                    <span aria-hidden="true" class="input__icon">
                                        <div class="magnifying-glass"></div>
                                    </span>
                                </label>
                                <input id="vgt-search-transfer" type="text" placeholder="Search this table"
                                    class="vgt-input vgt-pull-left">
                            </form>
                        </div>

                        <div class="vgt-global-search__actions vgt-pull-right">
                            <div class="mt-2 mb-3">
                                <button type="button" class="btn btn-outline-info ripple m-1 btn-sm">
                                    <i class="i-Filter-2"></i> Filter
                                </button>
                                <button type="button" class="btn btn-outline-success ripple m-1 btn-sm">
                                    <i class="i-File-Copy"></i> PDF
                                </button>
                                <button class="btn btn-sm btn-outline-danger ripple m-1">
                                    <i class="i-File-Excel"></i> EXCEL
                                </button>

                                {{-- CREATE NEW MODAL --}}
                                <button type="button" class="btn btn-rounded btn-primary btn-icon m-1"
                                    data-bs-toggle="modal" data-bs-target="#New_FundTransfer">
                                    <i class="i-Add"></i> Add
                                </button>

                                <!-- Add Fund Transfer Modal -->
                                <div class="modal fade" id="New_FundTransfer" tabindex="-1" role="dialog" aria-labelledby="New_FundTransferLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="New_FundTransferLabel">Add Fund Transfer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('fund-transfers.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label for="created_at">Date and Time Created</label>
                                                            <div class="d-flex">
                                                                <input type="datetime-local"
                                                                    id="created_at"
                                                                    name="created_at"
                                                                    class="form-control @error('created_at') is-invalid @enderror"
                                                                    value="{{ old('created_at', now()->timezone('Asia/Manila')->format('Y-m-d\TH:i')) }}">

                                                                <button type="button"
                                                                    class="btn btn-secondary ml-2"
                                                                    onclick="document.getElementById('created_at').value = ''">
                                                                    Clear
                                                                </button>
                                                            </div>
                                                            @error('created_at')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                            <small class="form-text text-muted">
                                                                Defaults to current date and time. Clear if you want the system to use the exact submission time.
                                                            </small>
                                                        </div>

                                                        <!-- Reference Number -->
                                                        {{-- <div class="col-md-12 mb-3">
                                                            <label>Reference Number *</label>
                                                            <input type="text" name="reference_number"
                                                                    class="form-control @error('reference_number') is-invalid @enderror"
                                                                    value="{{ old('reference_number') }}" required>
                                                        @error('reference_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div> --}}

                                                    <div class="col-md-12 mb-3">
                                                        <label>Reference Number *</label>
                                                        @php
                                                        $selectedBranchId = old('branch_id', $currentBranchId ?? '');
                                                        $selectedBranch = $branches->firstWhere('id', $selectedBranchId);

                                                        $prefix = 'FT-' . $selectedBranchId . '-';

                                                        $latestFT = \App\Models\FundTransfer::where('reference_number', 'LIKE', $prefix . '%')
                                                        ->latest('id')
                                                        ->first();

                                                        $nextNumber = $latestFT
                                                        ? intval(substr($latestFT->reference_number, -6)) + 1
                                                        : 1;

                                                        $formattedRef = $selectedBranch
                                                        ? $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT)
                                                        : '';
                                                        @endphp
                                                        <input type="text" name="reference_number" class="form-control" value="{{ old('reference_number', $formattedRef) }}" required>
                                                    </div>

                                                    <!-- <pre>
                                                    {{ print_r($cashEquivalents->toArray(), true) }}
                                                    </pre> -->
                                                    <!-- From Cash Equivalent -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>From *</label>
                                                        <select id="from_cash" name="from_cash_equivalent_id"
                                                            class="form-control @error('from_cash_equivalent_id') is-invalid @enderror"
                                                            required>
                                                            <option value="">Select Cash Equivalent</option>
                                                            @foreach($cashEquivalents as $ce)
                                                            <option value="{{ $ce->id }}">
                                                                {{ $ce->name }}

                                                                @if($ce->account_number)
                                                                - {{ $ce->account_number }}
                                                                @endif

                                                                - {{ $ce->accountable->name ?? 'N/A' }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('from_cash_equivalent_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- To Cash Equivalent -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>To *</label>
                                                        <select id="to_cash" name="to_cash_equivalent_id"
                                                            class="form-control @error('to_cash_equivalent_id') is-invalid @enderror"
                                                            required>
                                                            <option value="">Select Cash Equivalent</option>
                                                            @foreach($cashEquivalents as $ce)
                                                            <option value="{{ $ce->id }}">
                                                                {{ $ce->name }}

                                                                @if($ce->account_number)
                                                                - {{ $ce->account_number }}
                                                                @endif

                                                                - {{ $ce->accountable->name ?? 'N/A' }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('to_cash_equivalent_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Method of Transfer -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>Method of Transfer</label>
                                                        <select name="method_of_transfer_id"
                                                            class="form-control @error('method_of_transfer_id') is-invalid @enderror">
                                                            <option value="">Select Method</option>
                                                            @foreach($payments as $payment)
                                                            <option value="{{ $payment->id }}" {{ old('method_of_transfer_id') == $payment->id ? 'selected' : '' }}>
                                                                {{ $payment->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('method_of_transfer_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Amount -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>Amount *</label>
                                                        <input type="number" step="0.01" name="amount"
                                                            class="form-control @error('amount') is-invalid @enderror"
                                                            value="{{ old('amount') }}" required>
                                                        @error('amount')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="col-md-12 mb-3">
                                                        <label>Description</label>
                                                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                                    </div>

                                                    <!-- Submit -->
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="i-Yes me-2 font-weight-bold"></i> Submit
                                                        </button>
                                                    </div>
                                                </div>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- END Add Modal --}}

                            @foreach ($fundTransfers as $ft)
                            <tr>
                                <!-- table cells -->
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editFundTransferModal{{ $ft->id }}" tabindex="-1" role="dialog" aria-labelledby="editFundTransferLabel{{ $ft->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editFundTransferLabel{{ $ft->id }}">Edit Fund Transfer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('fund-transfers.update', $ft->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="row">

                                                    <div class="col-md-12 mb-3">
                                                        <label for="created_at">Date and Time Created</label>
                                                        <div class="d-flex">
                                                            <input type="datetime-local"
                                                                id="created_at"
                                                                name="created_at"
                                                                class="form-control @error('created_at') is-invalid @enderror"
                                                                value="{{ old('created_at', now()->timezone('Asia/Manila')->format('Y-m-d\TH:i')) }}">

                                                            <button type="button"
                                                                class="btn btn-secondary ml-2"
                                                                onclick="document.getElementById('created_at').value = ''">
                                                                Clear
                                                            </button>
                                                        </div>
                                                        @error('created_at')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                        <small class="form-text text-muted">
                                                            Defaults to current date and time. Clear if you want the system to use the exact submission time.
                                                        </small>
                                                    </div>

                                                    <!-- Reference Number -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>Reference Number *</label>
                                                        <input type="text" name="reference_number" class="form-control"
                                                            value="{{ old('reference_number', $ft->reference_number) }}" required>
                                                    </div>

                                                    <!-- From Cash Equivalent -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>From *</label>
                                                        <select id="from_cash_{{ $ft->id }}" name="from_cash_equivalent_id" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($cashEquivalents->sortBy('name') as $ce)
                                                            <option value="{{ $ce->id }}" {{ $ft->from_cash_equivalent_id == $ce->id ? 'selected' : '' }}>
                                                                {{ $ce->name }} - {{ $ce->account_number }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- To Cash Equivalent -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>To *</label>
                                                        <select id="to_cash_{{ $ft->id }}" name="to_cash_equivalent_id" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($cashEquivalents->sortBy('name') as $ce)
                                                            <option value="{{ $ce->id }}" {{ $ft->to_cash_equivalent_id == $ce->id ? 'selected' : '' }}>
                                                                {{ $ce->name }} - {{ $ce->account_number }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Amount -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>Amount *</label>
                                                        <input type="number" step="0.01" name="amount" class="form-control"
                                                            value="{{ old('amount', $ft->amount) }}" required>
                                                    </div>

                                                    <!-- Method of Transfer -->
                                                    <div class="col-md-6 mb-3">
                                                        <label>Method of Transfer</label>
                                                        <select name="method_of_transfer_id" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach ($payments as $payment)
                                                            <option value="{{ $payment->id }}" {{ $ft->method_of_transfer_id == $payment->id ? 'selected' : '' }}>
                                                                {{ $payment->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="col-md-12 mb-3">
                                                        <label>Description</label>
                                                        <textarea name="description" class="form-control">{{ old('description', $ft->description) }}</textarea>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>

                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>
                    </div>
                </div>

                <!-- Add Attachment Modal -->
                <div class="modal fade" id="attachmentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">

                            <form id="attachmentForm" method="POST"
                                action="" {{-- will be filled dynamically --}}
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="fund_transfer_id" id="attachment_ft_id">

                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Attachments</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p class="text-muted">You may upload multiple files.</p>
                                    <input type="file" name="attachments[]" class="form-control" multiple required>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">Upload</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <!-- View Attachments Modal -->
                <div class="modal fade" id="viewAttachmentsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Attached Files</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div id="attachmentsList">
                                    <p class="text-muted">Loading...</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                {{-- Table --}}
                <div class="vgt-responsive">
                    <table class="table-hover tableOne vgt-table">
                        <thead>
                            <tr>
                                <th class="vgt-checkbox-col"><input type="checkbox"></th>
                                <th class="vgt-left-align text-left">Date Created</th>
                                <th class="vgt-left-align text-left">Reference #</th>
                                <th class="vgt-left-align text-left">From</th>
                                <th class="vgt-left-align text-left">To</th>
                                <th class="vgt-left-align text-left">Method of Transfer</th>
                                <th class="vgt-left-align text-left">Created By</th>
                                <th class="vgt-left-align text-left">Amount</th>
                                <th class="vgt-left-align text-left">Status</th>
                                <th class="vgt-left-align text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($fundTransfers as $ft)
                            <tr>
                                <td class="vgt-checkbox-col"><input type="checkbox"></td>

                                <td class="text-left">
                                    {{ $ft->created_at->timezone('Asia/Manila')->format('Y-m-d H:i') }}
                                </td>

                                <td class="text-left">{{ $ft->reference_number }}</td>

                                <td class="text-left">
                                    {{ $ft->fromCashEquivalent ? $ft->fromCashEquivalent->name . ' - ' . $ft->fromCashEquivalent->account_number : 'N/A' }}
                                </td>

                                <td class="text-left">
                                    {{ $ft->toCashEquivalent ? $ft->toCashEquivalent->name . ' - ' . $ft->toCashEquivalent->account_number : 'N/A' }}
                                </td>

                                <td class="text-left">
                                    {{ $ft->methodOfTransfer->name ?? 'N/A' }}
                                </td>

                                <td class="vgt-left-align text-left">
                                    {{ $ft->createdBy?->username ?? 'N/A' }}
                                </td>

                                <td class="text-left">
                                    ₱{{ number_format($ft->amount, 2) }}
                                </td>

                                <td class="text-left">
                                    @if($ft->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                    @elseif($ft->status === 'approved')
                                    <span class="badge badge-success">Approved</span>
                                    @elseif($ft->status === 'archived')
                                    <span class="badge badge-secondary">Archived</span>
                                    @endif
                                </td>

                                <td class="text-right">
                                    <div class="dropdown b-dropdown btn-group">
                                        <button class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
                                            data-bs-toggle="dropdown">
                                            <span class="_dot _r_block-dot bg-dark"></span>
                                            <span class="_dot _r_block-dot bg-dark"></span>
                                            <span class="_dot _r_block-dot bg-dark"></span>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $ft->id }}">

                                            {{-- Edit Modal Trigger --}}
                                            @if($ft->status === 'pending')
                                            <li role="presentation">
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editFundTransferModal{{ $ft->id }}">
                                                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i>Edit
                                                </a>
                                            </li>
                                            @endif

                                            {{-- Add Attachment --}}
                                            <li role="presentation">
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="openAttachmentModal({{ $ft->id }})">
                                                    <i class="nav-icon i-Add-File font-weight-bold mr-2"></i>Add Attachment
                                                </a>
                                            </li>

                                            {{-- View Attachments --}}
                                            <li role="presentation">
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="openViewAttachmentsModal({{ $ft->id }})">
                                                    <i class="nav-icon i-Files font-weight-bold mr-2"></i>View Attachments
                                                </a>
                                            </li>

                                            {{-- Approve --}}
                                            @if($ft->status === 'pending')
                                            <li role="presentation">
                                                <form action="{{ route('fund-transfers.approve', $ft->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="nav-icon i-Yes font-weight-bold mr-2"></i>Approve
                                                    </button>
                                                </form>
                                            </li>
                                            @endif

                                            {{-- Archive --}}
                                            @if($ft->status !== 'archived')
                                            <li role="presentation">
                                                <form action="{{ route('fund-transfers.archive', $ft->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>Archive
                                                    </button>
                                                </form>
                                            </li>
                                            @endif

                                            {{-- Restore --}}
                                            @if($ft->status === 'archived')
                                            <li role="presentation">
                                                <form action="{{ route('fund-transfers.restore', $ft->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="dropdown-item" type="submit">
                                                        <i class="nav-icon i-Eye font-weight-bold mr-2"></i>Restore
                                                    </button>
                                                </form>
                                            </li>
                                            @endif

                                            {{-- View --}}
                                            <li role="presentation">
                                                <a class="dropdown-item" href="{{ route('fund-transfers.show', $ft->id) }}">
                                                    <i class="nav-icon i-Eye font-weight-bold mr-2"></i>View
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No fund transfers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="vgt-wrap__footer vgt-clearfix">
                    <div class="footer__row-count vgt-pull-left">
                        <label>Rows per page:</label>
                        <select disabled>
                            <option>25</option>
                        </select>
                    </div>

                    <div class="footer__navigation vgt-pull-right">
                        {{ $fundTransfers->appends(['status' => $status])->links() }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>

@endsection

<script>
    function openAttachmentModal(ftId) {
        document.getElementById('attachment_ft_id').value = ftId;
        // IMPORTANT: Set correct form action!
        document.getElementById('attachmentForm').action =
            `/fund-transfers/${ftId}/attachments/upload`;

        new bootstrap.Modal(document.getElementById('attachmentModal')).show();
    }

    function openViewAttachmentsModal(ftId) {
        const modal = new bootstrap.Modal(document.getElementById('viewAttachmentsModal'));
        const container = document.getElementById('attachmentsList');
        container.innerHTML = `<p class="text-muted">Loading attachments...</p>`;
        modal.show();

        fetch(`/fund-transfers/${ftId}/attachments`)
            .then(response => response.json())
            .then(data => {
                if (!data.attachments || data.attachments.length === 0) {
                    container.innerHTML = `<p class="text-muted">No attachments found.</p>`;
                    return;
                }

                let html = '<div class="list-group">';
                data.attachments.forEach(file => {
                    const filename = file.split('/').pop();
                    html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="i-File-PDF text-danger me-2" style="font-size:1.4rem"></i>
                            <span>${filename}</span>
                        </div>
                        <a href="/storage/${file}" target="_blank" class="text-warning">
                            <i class="i-Download"></i>
                        </a>
                    </div>
                `;
                });
                html += '</div>';

                container.innerHTML = html;
            })
            .catch(() => {
                container.innerHTML = `<p class="text-danger">Failed to load attachments.</p>`;
            });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const fromSelect = document.getElementById("from_cash");
        const toSelect = document.getElementById("to_cash");

        function filterToOptions() {
            const selectedFrom = fromSelect.value;

            // Loop through options of "To"
            for (let option of toSelect.options) {
                if (option.value === selectedFrom && selectedFrom !== "") {
                    option.style.display = "none"; // hide selected from item
                } else {
                    option.style.display = "block"; // show all others
                }
            }

            // If currently selected "To" becomes invalid → reset
            if (toSelect.value === selectedFrom) {
                toSelect.value = "";
            }
        }

        fromSelect.addEventListener("change", filterToOptions);

        // Run on page load (for old() values)
        filterToOptions();
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.querySelectorAll("[id^='from_cash_']").forEach(fromSelect => {

            const id = fromSelect.id.replace("from_cash_", "");
            const toSelect = document.getElementById("to_cash_" + id);

            function filterOptions() {
                const selectedFrom = fromSelect.value;

                for (let option of toSelect.options) {
                    if (option.value === selectedFrom && selectedFrom !== "") {
                        option.style.display = "none";
                    } else {
                        option.style.display = "block";
                    }
                }

                // Reset if conflict
                if (toSelect.value === selectedFrom) {
                    toSelect.value = "";
                }
            }

            fromSelect.addEventListener("change", filterOptions);

            // Run once per modal on load (helps with old values)
            filterOptions();
        });

    });
</script>