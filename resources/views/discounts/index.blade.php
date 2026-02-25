@extends('layouts.app')
@section('content')

<div class="main-content">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Discount Method</h1>
            <ul>
                <li><a href=""> Sales Settings </a></li>
                <!----> <!---->
            </ul>
            <div class="breadcrumb-action"></div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>
    <!----> 
    
    <div class="card wrapper">
        <!----><!---->
        <div class="card-body">
            <nav class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a href="{{ route('discounts.index', ['status' => 'active']) }}" class="nav-link {{ $status === 'active' ? 'active' : '' }}">Active</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('discounts.index', ['status' => 'archived']) }}" class="nav-link {{ $status === 'archived' ? 'active' : '' }}">Archived</a>
                </li>
            </ul>
        </nav>
            <!----><!---->
            <div class="vgt-wrap ">
                <!----> 
                <div class="vgt-inner-wrap">
                <!----> 
                <div class="vgt-global-search vgt-clearfix">
                    <div class="vgt-global-search__input vgt-pull-left">
                        <form role="search">
                            <label for="vgt-search-1307774914959">
                            <span aria-hidden="true" class="input__icon">
                                <div class="magnifying-glass"></div>
                            </span>
                            <span class="sr-only">Search</span>
                            </label>
                            <input id="vgt-search-1307774914959" type="text" placeholder="Search this table" class="vgt-input vgt-pull-left">
                        </form>
                    </div>
                    <div class="vgt-global-search__actions vgt-pull-right">
                        <div class="mt-2 mb-3">
                            <button id="dropdown-form__BV_toggle_" aria-haspopup="menu" aria-expanded="false" type="button" class="btn dropdown-toggle btn-light dropdown-toggle-no-caret"><i class="i-Gear"></i></button>
                            <button type="button" class="btn btn-outline-info ripple m-1 btn-sm collapsed" aria-expanded="false" aria-controls="sidebar-right" style="overflow-anchor: none;"><i class="i-Filter-2"></i>Filter</button>
                            <button type="button" class="btn btn-outline-success ripple m-1 btn-sm"><i class="i-File-Copy"></i> PDF
                            </button> <button class="btn btn-sm btn-outline-danger ripple m-1"><i class="i-File-Excel"></i> EXCEL
                            </button> <button type="button" class="btn btn-rounded btn-btn btn-primary btn-icon m-1" 
                                    data-bs-toggle="modal" data-bs-target="#New_Branch">
                                <i class="i-Add"></i> Add
                            </button> <!---->

                            <!-- Add Branch Modal -->
    <div class="modal fade" id="New_Branch" tabindex="-1" role="dialog" aria-labelledby="New_BranchLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="New_BranchLabel">Add Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('discounts.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div id="CreateModal___BV_modal_body_" class="modal-body">
            <form class="">
                <div class="row">
                    <div class="col-md-12">
                        <label for="created_at">Date and Time Created</label>
                        <div class="d-flex">
                            <input type="datetime-local" 
                                id="created_at" 
                                name="created_at" 
                                class="form-control" 
                                value="{{ old('created_at') }}">
                            
                            <button type="button" 
                                class="btn btn-secondary ml-2"
                                onclick="document.getElementById('created_at').value = ''">
                                Clear
                            </button>
                        </div>
                        <small class="form-text text-muted">
                            Leave blank if you want the system to use the current time automatically.
                        </small>
                    </div>
                    <div class="col-md-12">
                        <label>Name *</label>
                        <input placeholder="Enter Name of Discount" type="text" name="name" class="form-control" required>
                    </div>

                <div class="col-md-12">
                    <label for="type">Type *</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="percentage" {{ old('type', $discount->type ?? '') == 'percentage' ? 'selected' : '' }}>
                            Percentage
                        </option>
                        <option value="amount" {{ old('type', $discount->type ?? '') == 'amount' ? 'selected' : '' }}>
                            Amount
                        </option>
                    </select>
                    @error('type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="value">Discount Value per Unit *</label>
                    <div class="input-group">
                        <input 
                            type="number" 
                            step="0.01" 
                            name="value" 
                            id="value" 
                            class="form-control" 
                            placeholder="Enter Discount Value per Unit" 
                            value="{{ old('value', $discount->value ?? '') }}" 
                            required
                        >
                        <div class="input-group-append">
                            <span class="input-group-text" id="value-addon">
                                {{ old('type', $discount->type ?? '') == 'percentage' ? '%' : '₱' }}
                            </span>
                        </div>
                    </div>
                    @error('value')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                    {{-- Small script to switch addon dynamically --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const typeSelect = document.getElementById('type');
                            const addon = document.getElementById('value-addon');

                            function updateAddon() {
                                addon.textContent = typeSelect.value === 'percentage' ? '%' : '₱';
                            }

                            typeSelect.addEventListener('change', updateAddon);
                            updateAddon(); // initial
                        });
                    </script>

                    <div class="mt-3 col-md-12">
                        <div class="mr-2">
                        <div class="b-overlay-wrap position-relative d-inline-block btn-loader">
                            <button type="submit" class="btn btn-primary"><i class="i-Yes me-2 font-weight-bold"></i>
                            Submit</button><!---->
                        </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>
                        </div>
                    </div>
                </div>
                <!----> 
                <div class="vgt-fixed-header">
                    <!---->
                </div>
                <div class="vgt-responsive">
                    <table id="vgt-table" class="table-hover tableOne vgt-table ">
                        <thead>
                            <tr>
                            <!----> <!----> 
                            <th scope="col" class="vgt-checkbox-col"><input type="checkbox"></th>
                            <th scope="col" aria-sort="descending" aria-controls="col-0" class="vgt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Date and Time Created</span> <button><span class="sr-only">
                                Sort table by Date and Time Created in descending order
                                </span></button>
                            </th>
                            <th scope="col" aria-sort="descending" aria-controls="col-1" class="gvt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Name</span> <button><span class="sr-only">
                                Sort table by Name in descending order
                                </span></button>
                            </th>
                            <th scope="col" aria-sort="descending" aria-controls="col-1" class="gvt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Type</span> <button><span class="sr-only">
                                Sort table by Type in descending order
                                </span></button>
                            </th>
                            <th scope="col" aria-sort="descending" aria-controls="col-1" class="gvt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Value</span> <button><span class="sr-only">
                                Sort table by Value in descending order
                                </span></button>
                            </th>
                            <th scope="col" aria-sort="descending" aria-controls="col-3" class="vgt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Created By</span> <button><span class="sr-only">
                                Sort table by Created By in descending order
                                </span></button>
                            </th>
                            <th scope="col" aria-sort="descending" aria-controls="col-4" class="vgt-left-align text-right" style="min-width: auto; width: auto;">
                                <span>Action</span> <!---->
                            </th>
                            </tr>
                            <!---->
                        </thead>
                        <tbody>
                        @forelse($discounts as $discount)
        <tr>
            <td class="vgt-checkbox-col"><input type="checkbox"></td>
            <td class="vgt-left-align text-left">{{ $discount->created_at->format('Y-m-d H:i') }}</td>
            <td class="vgt-left-align text-left">{{ $discount->name }}</td>
            <td class="vgt-left-align text-left">{{ $discount->type }}</td>
            <td class="vgt-left-align text-left">
                        {{-- Show value depending on type --}}
                        @if($discount->type === 'percentage')
                            {{ $discount->value }}%
                        @elseif($discount->type === 'amount')
                            ₱{{ number_format($discount->value, 2) }}
                        @endif
                    </td>
            <td class="vgt-left-align text-left">{{ $discount->creator?->username ?? 'N/A' }}</td>
            <td class="vgt-left-align text-right">
                <div class="dropdown b-dropdown btn-group">
                    <!-- 3-dot button -->
                    <button id="dropdownMenu{{ $discount->id }}"
                        type="button"
                        class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <span class="_dot _r_block-dot bg-dark"></span>
                        <span class="_dot _r_block-dot bg-dark"></span>
                        <span class="_dot _r_block-dot bg-dark"></span>
                    </button>

            <!-- Dropdown items -->
            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $discount->id }}">
                <!-- Edit -->
                <li role="presentation">
                    <a class="dropdown-item" href="#"
                        data-bs-toggle="modal"
                        data-bs-target="#editDiscountModal{{ $discount->id }}">
                        <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                    </a>
                </li>
                
                <!-- Archive -->
                @if($discount->status === 'active')
                <form action="{{ route('discounts.archive', $discount) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to move this item to the archive?');"
                    style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="dropdown-item">
                        <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i> Move to Archive
                    </button>
                </form>
                @endif

                <!-- Restore -->
                @if($discount->status === 'archived')
                <form action="{{ route('discounts.restore', $discount) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to restore this item to active?');"
                    style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="dropdown-item">
                        <i class="nav-icon i-Eye font-weight-bold mr-2font-weight-bold mr-2"></i> Restore as Active
                    </button>
                </form>
                @endif

                <!-- Logs -->
                <li role="presentation">
                    <a class="dropdown-item" href="#">
                        <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i> Logs
                    </a>
                </li>

                <!-- Remarks -->
                <li role="presentation">
                    <a class="dropdown-item" href="#">
                        <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
                    </a>
                </li>
            </ul>
        </div>
    </td>
</tr>
<!-- Edit Modal for this Discount -->
<div class="modal fade" id="editDiscountModal{{ $discount->id }}" tabindex="-1" aria-labelledby="editDiscountModalLabel{{ $discount->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editDiscountModalLabel{{ $discount->id }}">Edit Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Created At -->
                    <div class="form-group mb-3">
                        <label for="discount-created-{{ $discount->id }}">Date &amp; Time Created</label>
                        <input type="datetime-local"
                                name="created_at"
                                id="discount-created-{{ $discount->id }}"
                                class="form-control"
                                value="{{ $discount->created_at ? $discount->created_at->format('Y-m-d\TH:i') : '' }}">
                        <small class="form-text text-muted">
                            Leave blank to keep the original creation date.
                        </small>
                    </div>

                    <!-- Discount Name -->
                    <div class="form-group mb-3">
                        <label for="discount-name-{{ $discount->id }}">Name</label>
                        <input type="text"
                                name="name"
                                id="discount-name-{{ $discount->id }}"
                                class="form-control"
                                value="{{ $discount->name }}" required>
                    </div>

                    <!-- Discount Type -->
                    <div class="form-group mb-3">
                        <label for="discount-type-{{ $discount->id }}">Type</label>
                        <select name="type" id="discount-type-{{ $discount->id }}" class="form-control" required>
                            <option value="percentage" {{ $discount->type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="amount" {{ $discount->type === 'amount' ? 'selected' : '' }}>Amount</option>
                        </select>
                    </div>

                    <!-- Discount Value -->
                    <div class="form-group mb-3">
                        <label for="discount-value-{{ $discount->id }}">Value</label>
                        <input type="number"
                                step="0.01"
                                name="value"
                                id="discount-value-{{ $discount->id }}"
                                class="form-control"
                                value="{{ $discount->value }}" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@empty
@endforelse
                    </tbody>
                        
                        <!---->
                    </table>
                </div>
                <!----> 
                <div class="vgt-wrap__footer vgt-clearfix">
                    <div class="footer__row-count vgt-pull-left">
                        <form>
                            <label for="vgt-select-rpp-1491334360472" class="footer__row-count__label">Rows per page:</label> 
                            <select id="vgt-select-rpp-1491334360472" autocomplete="off" name="perPageSelect" aria-controls="vgt-table" class="footer__row-count__select">
                            <option value="10">
                                10
                            </option>
                            <option value="20">
                                20
                            </option>
                            <option value="30">
                                30
                            </option>
                            <option value="40">
                                40
                            </option>
                            <option value="50">
                                50
                            </option>
                            <option value="-1">All</option>
                            </select>
                        </form>
                    </div>
                    <div class="footer__navigation vgt-pull-right">
                        <div data-v-347cbcfa="" class="footer__navigation__page-info">
                            <div data-v-347cbcfa="">
                            1 - 4 of 4
                            </div>
                        </div>
                        <!----> <button type="button" aria-controls="vgt-table" class="footer__navigation__page-btn disabled"><span aria-hidden="true" class="chevron left"></span> <span>prev</span></button> <button type="button" aria-controls="vgt-table" class="footer__navigation__page-btn disabled"><span>next</span> <span aria-hidden="true" class="chevron right"></span></button> <!---->
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!----><!---->
    </div>
    <span>
        <!---->
    </span>
    <!----> 
    <span>
        <!---->
    </span>
</div>

@endsection