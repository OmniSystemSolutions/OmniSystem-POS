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

    @php
        $currentRoute = Route::currentRouteName();
    @endphp

    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $id ?? uniqid() }}">
        <!-- Edit -->
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

        <!-- Show Restore as Active only for resigned -->
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
                        <button type="submit" class="dropdown-item">  <!-- removed text-success -->
                            <i class="nav-icon i-Eye font-weight-bold mr-2"></i>
                            Restore as Active
                        </button>
                    </form>
                </li>
            @endif
        @endisset

        {{-- @if($status === 'resigned')
            @isset($deleteRoute)
                <li role="presentation">
                    <form action="{{ $deleteRoute }}" method="POST" class="swal-confirm"
                        data-title="Permanently Delete User?"
                        data-text="This action will permanently remove this user and cannot be undone."
                        data-confirm-button="Yes, Delete Permanently"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                            Permanently Delete
                        </button>
                    </form>
                </li>
            @endisset

            <li><hr class="dropdown-divider"></li>
        @endif --}}

        @isset($deleteRoute)
            <li role="presentation">
                <form action="{{ $deleteRoute }}" method="POST" class="swal-confirm"
                    data-title="Permanently Delete Permission?"
                    data-text="This action will permanently remove this permission and cannot be undone."
                    data-confirm-button="Yes, Delete Permanently"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                         Delete
                    </button>
                </form>
            </li>
        @endisset

        @isset($branchEditRoute)
        <li role="presentation">
            <a class="dropdown-item"
            href="#"
            @click.prevent="$root.openEditModal({{ $data->toJson() }})">
                <i class="nav-icon i-Edit font-weight-bold mr-2"></i> {{ $editLabel ?? 'Edit' }}
            </a>
        </li>
        @endisset
        

         <!-- Adjustment -->
        @isset($adjustmentRoute)
        <li role="presentation">
             <a class="dropdown-item" href="{{ $adjustmentRoute }}">
                <i class="nav-icon i-Folder-Download font-weight-bold mr-2"></i> {{ $adjustmentLabel ?? 'Apply Adjustment to Stock Card' }}
            </a>
        </li>
         @endisset

         <!-- View Audit -->
        @isset($viewAuditRoute)
        <li role="presentation">
             <a class="dropdown-item" href="{{ $viewAuditRoute }}">
                <i class="nav-icon i-Eye font-weight-bold mr-2"></i> {{ $viewAuditLabel ?? 'View Audit Report' }}
            </a>
        </li>
        @endisset

        @if ($currentRoute === 'inventory_purchase_orders.index')
        <li><hr class="dropdown-divider"></li>

        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="viewPOInvoice({{ $po->id }})">
                <i class="nav-icon i-Receipt-3 font-weight-bold mr-2"></i> View PO Invoice
            </a>
        </li>

        <!-- 📎 Add Attachment -->
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
        <!-- ✅ Approve -->
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

        <!-- ❌ Disapprove -->
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

        @if ($currentRoute === 'accounts-payables.index')

        @if(isset($status))
            <li><hr class="dropdown-divider"></li>

            <!-- 📄 View Invoice -->
            <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item" onclick="viewAmountDetailsModal({{ $id }})">
                    <i class="nav-icon i-Receipt-3 font-weight-bold mr-2"></i> View Invoice
                </a>
            </li>

            <!-- 👍 Approve -->
            @if($status === 'pending')
            <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item text-success" onclick="approveAP({{ $id }})">
                    <i class="nav-icon i-Like font-weight-bold mr-2"></i> Approve
                </a>
            </li>
            @endif

            <!-- 👎 Disapprove -->
            @if($status === 'pending')
            <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="disapproveAP({{ $id }})">
                    <i class="nav-icon i-Unlike-2 font-weight-bold mr-2"></i> Disapprove
                </a>
            </li>

            <li><hr class="dropdown-divider"></li>
            @endif
        @endif
        @endif


        <!-- Update -->
        @isset($updateRoute)
        <li role="presentation">
        <a
            class="dropdown-item"
            href="#"
            @click.prevent="$emit('open-update-modal', item)"
        >
            <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
            {{ $updateLabel ?? 'Update Status' }}
        </a>
        </li>
        @endisset

        <!-- Edit for Users-->
        {{-- @isset($userEditRoute)
        <li role="presentation">
            <a class="dropdown-item" onclick="openEditUserModal({{ $user }})">
                <i class="i-Pen-2 me-1"></i> Edit
            </a>
        </li>
        @endisset --}}

        <!-- View Stock Card -->
        @isset($stockCardRoute)
            <li role="presentation">
            <a class="dropdown-item" href="{{ $stockCardRoute }}">
               <i class="nav-icon i-Receipt font-weight-bold mr-2"></i> {{ $stockCardLabel ?? 'View Stock Card' }}
            </a>
        </li>
        @endisset

        <!-- View User Profile -->
        @if(isset($profileRoute) && $status !== 'archived')
            <a href="{{ $profileRoute }}" target="_blank" class="dropdown-item">
                <i class="nav-icon i-Eye font-weight-bold mr-2"></i> View User Profile
            </a>
        @endif

        <!-- Cancel Static-->
        {{-- @isset($cancelRoute)
            <li role="presentation">
            <a class="dropdown-item" href="{{ $cancelRoute }}">
                <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i> {{ $cancelLabel ?? 'Print Bill Out' }}
            </a>
        </li>
        @endisset --}}

        {{-- AFTER --}}
        @isset($cancelRoute)
            @if(isset($billOutPreviewModalId))
                <li role="presentation">
                    <a class="dropdown-item" href="javascript:void(0);"
                        data-bs-toggle="modal"
                        data-bs-target="#{{ $billOutPreviewModalId }}">
                        <i class="nav-icon i-Receipt font-weight-bold mr-2"></i> {{ $cancelLabel ?? 'Print Bill Out' }}
                    </a>
                </li>
            @endif
        @endisset


        <!-- View / Bill out -->
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

        <!-- Delete / Cancel -->
        @if(isset($status) && $status === 'archived' && isset($deleteRoute))
        <li role="presentation">
            <form action="{{ $deleteRoute }}" method="POST"
                    class="swal-confirm"
                    data-title="Are you sure?"
                    data-text="This will permanently delete the record."
                    data-confirm-button="Permanently Delete"
                    style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i> {{ $deleteLabel ?? 'Permanently Delete' }}
                </button>
            </form>
        </li>
        @endif

        
        <!-- ✅ Move to Archive (for both approved and active statuses) -->
        @if ($currentRoute === 'accounts-payables.index' && isset($ap) && $ap->status === 'approved')
                    <li role="presentation">
                <a href="javascript:void(0);" class="dropdown-item" onclick="openMakePaymentModal({{ $ap->id }})">
                    <i class="nav-icon i-Money font-weight-bold mr-2"></i> Make Payment
                </a>
            </li>
        @endif

        @if(isset($status) && in_array($status, ['active', 'approved']) && isset($archiveRoute))
        <li role="presentation">
            <form action="{{ $archiveRoute }}" method="POST"
                class="swal-confirm"
                data-title="Move to archive?"
                data-text="Move this item to the archive?"
                data-confirm-button="Move to Archive"
                style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                    {{ $archiveLabel ?? 'Move to Archive' }}
                </button>
            </form>
        </li>
        @endif

    {{-- test --}}
    @if(isset($resignRoute) && $status !== 'resigned')
    <li>
        <form action="{{ $resignRoute }}" method="POST" class="swal-confirm" data-title="Mark as Resigned?" data-text="This will change user status to Resigned." data-confirm-button="Yes" style="display:inline;">
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
        <form action="{{ $terminateRoute }}" method="POST" class="swal-confirm" data-title="Mark as Terminated?" data-text="This will change user status to Terminated." data-confirm-button="Yes" style="display:inline;">
            @csrf
            @method('PUT')
            <button type="submit" class="dropdown-item">
                <i class="i-Close me-1"></i> Terminate
            </button>
        </form>
    </li>
    @endif

        {{-- @if(isset($profileRoute))
        <li>
            <a href="{{ $profileRoute }}" target="_blank" class="dropdown-item">
                <i class="i-Eye me-1"></i> View Profile
            </a>
        </li>
        @endif --}}

        <!-- Restore -->
        @if(isset($status) && $status === 'archived' && isset($restoreRoute))
            <form action="{{ $restoreRoute }}" method="POST"
                  class="swal-confirm"
                  data-title="Restore item?"
                  data-text="Restore this item to active status?"
                  data-confirm-button="Restore"
                  style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="dropdown-item">
                    <i class="nav-icon i-Eye font-weight-bold mr-2"></i> {{ $restoreLabel ?? 'Restore as Active' }}
                </button>
            </form>
        @endif

        <!-- Logs -->
        @isset($logsRoute)
        <li role="presentation">
            <a class="dropdown-item" href="{{ $logsRoute }}">
                <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i> {{ $logsLabel ?? 'Logs' }}
            </a>
        </li>
        @endisset

        <!-- Remarks -->
        @isset($remarksRoute)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item" onclick="openRemarksModal({{ $id }})">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
            </a>
        </li>
        @endisset

        <!-- Remarks Sample-->
        @isset($remarksSample)
        <li role="presentation">
            <a href="javascript:void(0);" class="dropdown-item">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
            </a>
        </li>
        @endisset

        </ul>
        
</div>
