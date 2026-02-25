<div class="dropdown b-dropdown btn-group">
    <button id="dropdownMenu{{ $id ?? uniqid() }}"
        type="button"
        class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
        data-bs-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>

        {{-- 🔴 Badge indicator for remarks --}}
        @isset($remarksRoute)
        <span id="remarksBadge-{{ $id }}"
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white fw-bold d-none"
            style="font-size: 0.55rem; transform: translate(40%, -40%) !important;">
            1
        </span>
        @endisset
    </button>

    @php $currentRoute = Route::currentRouteName(); @endphp

    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $id ?? uniqid() }}">

        {{-- ── Edit ──────────────────────────────────────────────── --}}
        @isset($editRoute)
        @if(request()->query('status') !== 'payments')
        <li role="presentation">
            <a class="dropdown-item" href="{{ $editRoute }}">
                <i class="nav-icon i-Edit font-weight-bold mr-2"></i> {{ $editLabel ?? 'Edit' }}
            </a>
        </li>
        @endif
        @endisset

        @isset($userEditRoute)
        <li role="presentation">
            <a class="dropdown-item" href="{{ $userEditRoute }}">
                <i class="nav-icon i-Pen-2 font-weight-bold mr-2"></i> Edit
            </a>
        </li>
        @endisset

        {{-- ── View / Bill Out / Payment / Receipt ───────────────── --}}
        @isset($viewRoute)
        <li role="presentation">
            @if($viewRoute === '#')
                @php $modalId = $viewModalId ?? "billOutModal{$id}"; @endphp
                <a class="dropdown-item" href="javascript:void(0);"
                   data-bs-toggle="modal"
                   data-bs-target="#{{ $modalId }}">
                    <i class="nav-icon i-Receipt font-weight-bold mr-2"></i> {{ $viewLabel ?? 'View' }}
                </a>
            @else
                <a class="dropdown-item" href="{{ $viewRoute }}">
                    <i class="nav-icon i-Receipt font-weight-bold mr-2"></i> {{ $viewLabel ?? 'View' }}
                </a>
            @endif
        </li>
        @endisset

        {{-- ── Move to Prepared Service / Archive ────────────────── --}}
        @isset($archiveRoute)
        @if(isset($status) && in_array($status, ['active', 'approved', 'reservations']))
        <li role="presentation">
            <form action="{{ $archiveRoute }}" method="POST"
                class="swal-confirm"
                data-title="Move to Prepared Service?"
                data-text="This will move the reservation to Prepared Service."
                data-confirm-button="{{ $archiveLabel ?? 'Move to Prepared Service' }}"
                style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Box-Full font-weight-bold mr-2"></i>
                    {{ $archiveLabel ?? 'Move to Archive' }}
                </button>
            </form>
        </li>
        @endif
        @endisset

        {{-- ── Cancel / Move to Ready for Service (JS trigger) ───── --}}
        @isset($cancelRoute)
        @if($cancelRoute === '#' && isset($cancelOnClick))
        {{-- JS-triggered action (e.g. openReadyForServiceModal) --}}
        <li role="presentation">
            <a class="dropdown-item" href="javascript:void(0);"
               onclick="{{ $cancelOnClick }}">
                <i class="nav-icon i-Arrow-Right font-weight-bold mr-2"></i>
                {{ $cancelLabel ?? 'Move to Ready for Service' }}
            </a>
        </li>
        @elseif(isset($billOutPreviewModalId))
        {{-- Print Bill Out slip --}}
        <li role="presentation">
            <a class="dropdown-item" href="javascript:void(0);"
               data-bs-toggle="modal"
               data-bs-target="#{{ $billOutPreviewModalId }}">
                <i class="nav-icon i-Receipt font-weight-bold mr-2"></i>
                {{ $cancelLabel ?? 'Print Bill Out' }}
            </a>
        </li>
        @endif
        @endisset

        {{-- ── Restore ──────────────────────────────────────────── --}}
        {{-- For archived items --}}
        @if(isset($status) && $status === 'archived' && isset($restoreRoute))
        <li role="presentation">
            <form action="{{ $restoreRoute }}" method="POST"
                  class="swal-confirm"
                  data-title="Restore item?"
                  data-text="Restore this item to active status?"
                  data-confirm-button="Restore"
                  style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Eye font-weight-bold mr-2"></i>
                    {{ $restoreLabel ?? 'Restore as Active' }}
                </button>
            </form>
        </li>
        @endif

        {{-- For ready_for_service reservations --}}
        @if(isset($status) && $status === 'ready_for_service' && isset($restoreRoute))
        <li role="presentation">
            <form action="{{ $restoreRoute }}" method="POST"
                  class="swal-confirm"
                  data-title="Restore to Reservations?"
                  data-text="This will move the reservation back to Reservations status."
                  data-confirm-button="Restore to Reservations"
                  style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Repeat-2 font-weight-bold mr-2"></i>
                    {{ $restoreLabel ?? 'Restore to Reservations' }}
                </button>
            </form>
        </li>
        @endif

        {{-- For resigned users --}}
        @isset($restoreRoute)
        @if(isset($status) && $status === 'resigned')
        <li>
            <form action="{{ $restoreRoute }}" method="POST"
                class="swal-confirm"
                data-title="Restore as Active?"
                data-text="This will change the user status back to Active."
                data-confirm-button="Restore as Active"
                style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Eye font-weight-bold mr-2"></i>
                    Restore as Active
                </button>
            </form>
        </li>
        @endif
        @endisset

        {{-- ── Divider before secondary actions ───────────────────── --}}
        @if(isset($remarksRoute) || isset($logsRoute) || isset($adjustmentRoute) || isset($stockCardRoute))
        <li><hr class="dropdown-divider"></li>
        @endif

        {{-- ── Remarks ──────────────────────────────────────────── --}}
        @isset($remarksRoute)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="openRemarksModal({{ $id }})">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
            </a>
        </li>
        @endisset

        @isset($remarksSample)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
            </a>
        </li>
        @endisset

        {{-- ── Remarks Modal (order-reservations: opens BS modal instead of JS fn) --}}
        @isset($remarksModalId)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item"
               data-bs-toggle="modal"
               data-bs-target="#{{ $remarksModalId }}">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
            </a>
        </li>
        @endisset

        {{-- ── Add Attachments Modal (order-reservations) ──────────── --}}
        @isset($attachmentModalId)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item"
               data-bs-toggle="modal"
               data-bs-target="#{{ $attachmentModalId }}">
                <i class="nav-icon i-Attach font-weight-bold mr-2"></i>
                {{ $attachmentLabel ?? 'Add Attachments' }}
            </a>
        </li>
        @endisset

        {{-- ── Logs Modal (order-reservations: opens BS modal instead of route) ── --}}
        @isset($logsModalId)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item"
               data-bs-toggle="modal"
               data-bs-target="#{{ $logsModalId }}">
                <i class="nav-icon i-Clock font-weight-bold mr-2"></i>
                {{ $logsLabel ?? 'Logs' }}
            </a>
        </li>
        @endisset

        {{-- ── Logs ────────────────────────────────────────────── --}}
        @isset($logsRoute)
        <li role="presentation">
            <a class="dropdown-item" href="{{ $logsRoute }}">
                <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i>
                {{ $logsLabel ?? 'Logs' }}
            </a>
        </li>
        @endisset

        {{-- ── Stock Card ───────────────────────────────────────── --}}
        @isset($stockCardRoute)
        <li role="presentation">
            <a class="dropdown-item" href="{{ $stockCardRoute }}">
                <i class="nav-icon i-Receipt font-weight-bold mr-2"></i>
                {{ $stockCardLabel ?? 'View Stock Card' }}
            </a>
        </li>
        @endisset

        {{-- ── Adjustment ───────────────────────────────────────── --}}
        @isset($adjustmentRoute)
        <li role="presentation">
            <a class="dropdown-item" href="{{ $adjustmentRoute }}">
                <i class="nav-icon i-Folder-Download font-weight-bold mr-2"></i>
                {{ $adjustmentLabel ?? 'Apply Adjustment to Stock Card' }}
            </a>
        </li>
        @endisset

        {{-- ── View Audit ───────────────────────────────────────── --}}
        @isset($viewAuditRoute)
        <li role="presentation">
            <a class="dropdown-item" href="{{ $viewAuditRoute }}">
                <i class="nav-icon i-Eye font-weight-bold mr-2"></i>
                {{ $viewAuditLabel ?? 'View Audit Report' }}
            </a>
        </li>
        @endisset

        {{-- ── View User Profile ────────────────────────────────── --}}
        @if(isset($profileRoute) && $status !== 'archived')
        <li role="presentation">
            <a href="{{ $profileRoute }}" target="_blank" class="dropdown-item">
                <i class="nav-icon i-Eye font-weight-bold mr-2"></i> View User Profile
            </a>
        </li>
        @endif

        {{-- ── Branch Edit ──────────────────────────────────────── --}}
        @isset($branchEditRoute)
        <li role="presentation">
            <a class="dropdown-item" href="#"
               @click.prevent="$root.openEditModal({{ $data->toJson() }})">
                <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                {{ $editLabel ?? 'Edit' }}
            </a>
        </li>
        @endisset

        {{-- ── Update Status ────────────────────────────────────── --}}
        @isset($updateRoute)
        <li role="presentation">
            <a class="dropdown-item" href="#"
               @click.prevent="$emit('open-update-modal', item)">
                <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                {{ $updateLabel ?? 'Update Status' }}
            </a>
        </li>
        @endisset

        {{-- ── HR / HR Actions (Resign / Terminate) ────────────── --}}
        @if(isset($resignRoute) && $status !== 'resigned')
        <li>
            <form action="{{ $resignRoute }}" method="POST"
                  class="swal-confirm"
                  data-title="Mark as Resigned?"
                  data-text="This will change user status to Resigned."
                  data-confirm-button="Yes"
                  style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="i-Check me-1"></i> Resign
                </button>
            </form>
        </li>
        @endif

        @if(isset($terminateRoute) && $status !== 'terminated')
        <li>
            <form action="{{ $terminateRoute }}" method="POST"
                  class="swal-confirm"
                  data-title="Mark as Terminated?"
                  data-text="This will change user status to Terminated."
                  data-confirm-button="Yes"
                  style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="i-Close me-1"></i> Terminate
                </button>
            </form>
        </li>
        @endif

        {{-- ── Purchase Order specific ──────────────────────────── --}}
        @if($currentRoute === 'inventory_purchase_orders.index')
        <li><hr class="dropdown-divider"></li>
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="viewPOInvoice({{ $po->id }})">
                <i class="nav-icon i-Receipt-3 font-weight-bold mr-2"></i> View PO Invoice
            </a>
        </li>
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="openAttachmentModal({{ $id }})">
                <i class="nav-icon i-Add-File font-weight-bold mr-2"></i> Add Attachment
            </a>
        </li>
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="openViewAttachmentsModal({{ $id }})">
                <i class="nav-icon i-Files font-weight-bold mr-2"></i> View Attached File
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        @if(isset($status))
            @if($status === 'pending')
            <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item text-success" onclick="approvePO({{ $id }})">
                    <i class="nav-icon i-Like font-weight-bold mr-2"></i> Approve
                </a>
            </li>
            @endif
            @if($status === 'approved')
            <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item" onclick="openLogStocksModal({{ $id }})">
                    <i class="nav-icon i-Folder-Download font-weight-bold mr-2"></i> Log Stocks in Inventory
                </a>
            </li>
            @endif
            @if($status === 'pending')
            <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="disapprovePO({{ $id }})">
                    <i class="nav-icon i-Unlike-2 font-weight-bold mr-2"></i> Disapprove
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            @endif
        @endif
        @endif

        {{-- ── Accounts Payable specific ────────────────────────── --}}
        @if($currentRoute === 'accounts-payables.index')
        @if(isset($status))
        <li><hr class="dropdown-divider"></li>
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="viewAmountDetailsModal({{ $id }})">
                <i class="nav-icon i-Receipt-3 font-weight-bold mr-2"></i> View Invoice
            </a>
        </li>
        @if($status === 'pending')
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item text-success" onclick="approveAP({{ $id }})">
                <i class="nav-icon i-Like font-weight-bold mr-2"></i> Approve
            </a>
        </li>
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="disapproveAP({{ $id }})">
                <i class="nav-icon i-Unlike-2 font-weight-bold mr-2"></i> Disapprove
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        @endif
        @endif
        @if(isset($ap) && $ap->status === 'approved')
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="openMakePaymentModal({{ $ap->id }})">
                <i class="nav-icon i-Money font-weight-bold mr-2"></i> Make Payment
            </a>
        </li>
        @endif
        @endif

        {{-- ── Divider before Delete (only for true deletes, not Cancel labels) --}}
        @if(isset($deleteRoute) && ($deleteLabel ?? 'Delete') !== 'Cancel')
        <li><hr class="dropdown-divider"></li>
        @endif

        {{-- ── Delete / Cancel ──────────────────────────────────── --}}
        @isset($deleteRoute)
        <li role="presentation">
            <form action="{{ $deleteRoute }}" method="POST"
                  class="swal-confirm"
                  data-title="Are you sure?"
                  data-text="This action cannot be undone."
                  data-confirm-button="{{ $deleteLabel ?? 'Delete' }}"
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger">
                    <i class="nav-icon i-Trash font-weight-bold mr-2"></i>
                    {{ $deleteLabel ?? 'Delete' }}
                </button>
            </form>
        </li>
        @endisset

    </ul>
</div>