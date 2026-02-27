@extends('layouts.app')
@section('content')
<style>
    .vs__search {
        font-size: 14px;
    }
    .dropdown-menu {
        position: relative;
    }
</style>
<div class="main-content" id="app">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Accounts Receivable</h1>
            <ul>
                <li><a href="">Accounting</a></li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>
    <!-- Item Details Modal -->
    <div class="modal fade" id="ItemDetailsModal" tabindex="-1" aria-labelledby="ItemDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="ItemDetailsModalLabel">Amount Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="list-group">
                <div class="list-group-item p-0">
                    <table class="table mb-0">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Tax</th>
                        <th>Price/Unit</th>
                        <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in modalItems" :key="index">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ item.category }}</td>
                            <td>@{{ item.type }}</td>
                            <td>@{{ item.description }}</td>
                            <td>@{{ item.quantity }}</td>
                            <td>₱@{{ item.tax.toFixed(2) }}</td>
                            <td>₱@{{ item.unit_price.toFixed(2) }}</td>
                            <td>₱@{{ item.subtotal.toFixed(2) }}</td>
                        </tr>
                    </tbody>
                    </table>

                    <div class="row mt-3">
                    <div class="offset-md-6 col-md-6">
                        <table class="table table-striped table-sm">
                        <tbody>
                            <tr>
                            <td class="bold">Tax</td>
                            <td>₱@{{ modalTax.toFixed(2) }}</td>
                            </tr>
                            <tr>
                            <td class="bold">Sub-Total</td>
                            <td>₱@{{ modalSubTotal.toFixed(2) }}</td>
                            </tr>
                            <tr>
                            <td><span class="font-weight-bold">Total Amount</span></td>
                            <td><span class="font-weight-bold">₱@{{ modalTotal.toFixed(2) }}</span></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    </div>

                </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <!-- Receive Payment Modal -->
    <div class="modal fade" id="receivePaymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form @submit.prevent="submitPayment">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Receive Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        
                        <!-- Must match controller -->
                        <input type="hidden" v-model="paymentForm.account_receivable_id">

                        <div class="row g-3">

                            <!-- Date & Time -->
                            <div class="col-12">
                                <label class="form-label">Date And Time of Transaction <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <input type="text" 
                                        class="form-control"
                                        id="receive_payment_datetime"
                                        v-model="paymentForm.transaction_datetime"
                                        placeholder="Select date & time"
                                        readonly>
                                    <button type="button" 
                                            class="btn btn-secondary btn-sm ms-2" 
                                            @click="clearPaymentDate">
                                        Clear
                                    </button>
                                </div>
                                <small class="text-muted">Cannot select future date.</small>
                            </div>

                            <!-- Amount -->
                            <div class="col-12">
                                <label class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control"
                                    v-model.number="paymentForm.amount" placeholder="0.00" required>
                            </div>

                            <!-- Cash Equivalent -->
                            <div class="col-12">
                                <label class="form-label">Cash Equivalent <span class="text-danger">*</span></label>
                                <v-select
                                    :options="cashEquivalents"
                                    label="label"
                                    :reduce="opt => opt.id"
                                    v-model="paymentForm.cash_equivalent_id"
                                    placeholder="Select Destination Account"
                                ></v-select>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-12">
                                <label class="form-label">Method of Payment <span class="text-danger">*</span></label>
                                <v-select
                                    :options="paymentMethods"
                                    label="label"
                                    :reduce="opt => opt.id"
                                    v-model="paymentForm.payment_method_id"
                                    placeholder="Select Payment Method"
                                ></v-select>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary" :disabled="submitting">
                                    <span v-if="submitting" class="spinner-border spinner-border-sm me-2"></span>
                                    Submit Payment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

   <!-- Edit Due Date Modal -->
    <div class="modal fade" id="editDueDateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form @submit.prevent="submitDueDate">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Due Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">New Due Date <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="due_date_picker"
                                    v-model="dueDateForm.due_date"
                                    placeholder="Select due date"
                                    readonly
                                    required
                                >
                                <small class="text-muted">You cannot select a date in the past.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" :disabled="submittingDueDate || !dueDateForm.due_date">
                            <span v-if="submittingDueDate" class="spinner-border spinner-border-sm me-2"></span>
                            Update Due Date
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="wrapper">
        <div class="row row mb-4">
            <div class="col-sm-12 col-md-3">
                <fieldset class="form-group">
                    <legend class="col-form-label pt-0">Select Year *</legend>
                    <v-select
                        v-model="filter.year"         
                        :options="yearOptions"         
                        :clearable="false"
                        placeholder="Select year"
                        label="label"                  
                    ></v-select>
                </fieldset>
            </div>
            <div class="col-sm-12 col-md-3">
                <fieldset class="form-group">
                <legend class="col-form-label pt-0">Select Month *</legend>
                <v-select
                    v-model="filter.month"
                    :options="months"
                    :clearable="false"
                    placeholder="Select month"
                    label="label"
                />
                </fieldset>
            </div>
        <div class="card-body">
            <nav class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item" v-for="status in statusList" :key="status.value">
                        <a href="#" 
                        class="nav-link" 
                        :class="{ active: statusFilter === status.value }" 
                        @click.prevent="setStatus(status.value)">
                        @{{ status.label }}
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="card-body">
                <div class="vgt-wrap">
                    <div class="vgt-inner-wrap">
                        <div class="vgt-global-search vgt-clearfix">
                            <div class="vgt-global-search__input vgt-pull-left">
                                <form role="search">
                                    <label for="vgt-search">
                                        <span aria-hidden="true" class="input_icon">
                                            <div class="magnifying-glass">
                                            </div>
                                        </span>
                                        <span class="sr-only">Search:</span>
                                    </label>
                                    <input id="vgt-search" type="text" placeholder="Search this table" class="vgt-input vgt-pull-left">
                                </form>
                            </div>
                            <div class="vgt-global-search__actions vgt-pull-right">
                                <div class="mt-2 mb-3">
                                    <div id="dropdown-form" class="dropdown b-dropdown m-2 btn-group" rounded="">
                                        <!----><button id="dropdown-form__BV_toggle_" aria-haspopup="menu" aria-expanded="false" type="button" class="btn dropdown-toggle btn-light dropdown-toggle-no-caret"><i class="i-Gear"></i></button>
                                        <ul role="menu" tabindex="-1" aria-labelledby="dropdown-form__BV_toggle_" class="dropdown-menu dropdown-menu-right">
                                            <li role="presentation">
                                            <header id="dropdown-header-label" class="dropdown-header">
                                                Columns
                                            </header>
                                            </li>
                                            <li role="presentation" style="width: 220px;">
                                            <form tabindex="-1" class="b-dropdown-form p-0">
                                                <section class="ps-container ps">
                                                    <div class="px-4" style="max-height: 400px;">
                                                        <ul class="list-unstyled">
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__309"><label class="custom-control-label" for="__BVID__309">Date and Time of Entry</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__310"><label class="custom-control-label" for="__BVID__310">Date And Time of Transaction</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__311"><label class="custom-control-label" for="__BVID__311">Created By</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__312"><label class="custom-control-label" for="__BVID__312">Branch</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__313"><label class="custom-control-label" for="__BVID__313">Transaction</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__314"><label class="custom-control-label" for="__BVID__314">Reference #</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__315"><label class="custom-control-label" for="__BVID__315">Payor</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__317"><label class="custom-control-label" for="__BVID__317">Amount Due</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__318"><label class="custom-control-label" for="__BVID__318">Amount Details</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__319"><label class="custom-control-label" for="__BVID__319">Due Date</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__320"><label class="custom-control-label" for="__BVID__320">Total received</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__321"><label class="custom-control-label" for="__BVID__321">Balance</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__322"><label class="custom-control-label" for="__BVID__322">Date of Completion</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__323"><label class="custom-control-label" for="__BVID__323">Status</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__324"><label class="custom-control-label" for="__BVID__324">Approved by</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__325"><label class="custom-control-label" for="__BVID__325">Date and Time Approved</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__326"><label class="custom-control-label" for="__BVID__326">Completed by</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__327"><label class="custom-control-label" for="__BVID__327">Date and Time Completed</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__328"><label class="custom-control-label" for="__BVID__328">Disapproved by</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__329"><label class="custom-control-label" for="__BVID__329">Date and Time Disapproved</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__330"><label class="custom-control-label" for="__BVID__330">Archived by</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__331"><label class="custom-control-label" for="__BVID__331">Date and Time Archived</label></div>
                                                        </li>
                                                        <li>
                                                            <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__332"><label class="custom-control-label" for="__BVID__332">Action</label></div>
                                                        </li>
                                                        <li><button type="button" class="btn mt-2 mb-3 btn-primary btn-sm">Save</button></li>
                                                        </ul>
                                                    </div>
                                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                                    </div>
                                                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                                    </div>
                                                </section>
                                            </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-outline-info ripple m-1 btn-sm collapsed" aria-expanded="false" aria-controls="sidebar-right" style="overflow-anchor: none;"><i class="i-Filter-2"></i>
                                    Filter
                                    </button> <button type="button" class="btn btn-outline-success ripple m-1 btn-sm"><i class="i-File-Copy"></i> PDF
                                    </button> <button class="btn btn-sm btn-outline-danger ripple m-1"><i class="i-File-Excel"></i> EXCEL
                                    </button> <button type="button" class="btn btn-info m-1 btn-sm"><i class="i-Upload"></i>
                                    Import
                                    </button> <a href="/accounts-receivable/create" class="btn btn-primary btn-icon m-1"><i class="i-Add"></i>
                                    Add
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="vgt-fixed-header">
                        </div>
                        <div class="vgt-responsive">
                            <table id="vgt-table"  class="table-hover tableOne vgt-table">
                                <colgroup>
                                    <col id="col-0">
                                    <col id="col-1">
                                    <col id="col-2">
                                    <col id="col-3">
                                    <col id="col-4">
                                    <col id="col-5">
                                    <col id="col-6">
                                    <col id="col-7">
                                    <col id="col-8">
                                    <col id="col-9">
                                    <col id="col-10">
                                    <col id="col-11">
                                    <col id="col-12">
                                    <col id="col-13">
                                    <col id="col-14">
                                    <col id="col-15">
                                    <col id="col-16">
                                    <col id="col-17">
                                    <col id="col-18">
                                    <col id="col-19">
                                    <col id="col-20">
                                    <col id="col-21">
                                    <col id="col-22">
                                    <col id="col-23">
                                </colgroup>
                                <thead>
                                <tr>
                                    <!----> 
                                    <th scope="col" class="vgt-checkbox-col"><input type="checkbox"></th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-0" class="vgt-left-align text-left w-190px sortable" style="min-width: auto; width: auto;"><span>Date and Time of Entry</span> <button><span class="sr-only">
                                        Sort table by Date and Time of Entry in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-1" class="vgt-left-align text-left w-220px sortable" style="min-width: auto; width: auto;"><span>Date And Time of Transaction</span> <button><span class="sr-only">
                                        Sort table by Date And Time of Transaction in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-2" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Created By</span> <button><span class="sr-only">
                                        Sort table by Created By in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-3" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Branch</span> <button><span class="sr-only">
                                        Sort table by Branch in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-4" class="vgt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Transaction</span> <button><span class="sr-only">
                                        Sort table by Transaction in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-5" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Reference #</span> <button><span class="sr-only">
                                        Sort table by Reference # in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-6" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Payor</span> <button><span class="sr-only">
                                        Sort table by Payor in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-8" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Amount Due</span> <button><span class="sr-only">
                                        Sort table by Amount Due in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-9" class="vgt-left-align text-left w-160px" style="min-width: auto; width: auto;">
                                        <span>Amount Details</span> <!---->
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-10" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Due Date</span> <button><span class="sr-only">
                                        Sort table by Due Date in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-11" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Total received</span> <button><span class="sr-only">
                                        Sort table by Total received in descending order
                                        </span></button>
                                    </th>
                                    <th scope="col" aria-sort="descending" aria-controls="col-12" class="vgt-left-align text-left w-160px sortable" style="min-width: auto; width: auto;"><span>Balance</span> <button><span class="sr-only">
                                        Sort table by Balance in descending order
                                        </span></button>
                                    </th>
                                    <!---->
                                    <th scope="col" aria-sort="descending" aria-controls="col-14" class="vgt-left-align text-left sortable" style="min-width: auto; width: auto;"><span>Status</span> <button><span class="sr-only">
                                        Sort table by Status in descending order
                                        </span></button>
                                    </th>

                                    <!-- DYNAMIC HEADERS BASED ON CURRENT TAB (statusFilter) -->
                                    <template v-if="statusFilter === 'approved' || statusFilter === 'completed'">
                                        <th>Approved By</th>
                                        <th>Date & Time Approved</th>
                                    </template>

                                    <template v-if="statusFilter === 'completed'">
                                        <th>Completed By</th>
                                        <th>Date & Time Completed</th>
                                    </template>

                                    <template v-if="statusFilter === 'disapproved'">
                                        <th>Disapproved By</th>
                                        <th>Date & Time Disapproved</th>
                                    </template>

                                    <template v-if="statusFilter === 'archived'">
                                        <th>Archived By</th>
                                        <th>Date & Time Archived</th>
                                    </template>
                                    <!----><!----><!----><!----><!----><!----><!----><!---->
                                    <th scope="col" aria-sort="descending" aria-controls="col-23" class="vgt-left-align text-right" style="min-width: auto; width: auto;">
                                        <span>Action</span> <!---->
                                    </th>
                                </tr>
                                <!---->
                                </thead>
                                <tbody>
                                    <tr v-for="row in records" :key="row.id">

                                        <!-- Checkbox -->
                                        <td>
                                            <input type="checkbox" :value="row.id">
                                        </td>

                                        <!-- Date and Time of Entry -->
                                        <td>@{{ row.created_at ? new Date(row.created_at).toLocaleString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true}) : '—' }}</td>

                                        <!-- Date and Time of Transaction -->
                                       <td>@{{ row.transaction_datetime ? new Date(row.transaction_datetime + ' UTC').toLocaleString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true}) : '—' }}</td>

                                        <!-- Created By -->
                                        <td>@{{ row.user?.name }}</td>

                                        <!-- Branch -->
                                        <td>@{{ row.branch?.name }}</td>

                                        <!-- Transaction -->
                                        <td>@{{ row.transaction_type }}</td>

                                        <!-- Reference # -->
                                        <td>@{{ row.reference_no }}</td>

                                        <!-- Payor -->
                                        <td>@{{ row.payor_name }}</td>

                                        <!-- Amount Due -->
                                        <td>@{{ row.amount_due }}</td>

                                        <!-- Amount Details -->
                                        <td><button class="btn btn-sm btn-primary" @click="openModal(row.items)">View</button></td>

                                        <!-- Due Date -->
                                        <td>@{{ row.due_date ? new Date(row.due_date).toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'}) : '—' }}</td>

                                        <!-- Total Received -->
                                        <td>@{{ row.total_received }}</td>

                                        <!-- Balance -->
                                        <td>@{{ row.balance }}</td>

                                        <!-- Status -->
                                        <td>@{{ row.status }}</td>

                                        <!-- Approved By / At -->
                                        <template v-if="statusFilter === 'approved' || statusFilter === 'completed'">
                                            <td>@{{ row.approved_by?.name || '-' }}</td>
                                            <td>@{{ row.approved_at ? new Date(row.approved_at).toLocaleString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true}) : '' }}</td>
                                        </template>

                                        <!-- Completed By / At -->
                                        <template v-if="statusFilter === 'completed'">
                                            <td>@{{ row.completed_by?.name || '-' }}</td>
                                            <td>@{{ row.completed_at ? new Date(row.completed_at).toLocaleString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true}) : '' }}</td>
                                        </template>

                                         <!-- Disapproved By / At -->
                                        <template v-if="statusFilter === 'disapproved'">
                                            <td>@{{ row.disapproved_by?.name || '-' }}</td>
                                            <td>@{{ row.disapproved_at ? new Date(row.disapproved_at).toLocaleString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true}) : '' }}</td>
                                        </template>

                                         <!-- Archived By / At -->
                                        <template v-if="statusFilter === 'archived'">
                                            <td>@{{ row.archived_by?.name || '-' }}</td>
                                            <td>@{{ row.archived_at ? new Date(row.archived_at).toLocaleString('en-US', {month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true}) : '' }}</td>
                                        </template>

                                        <!-- Action -->
                                        <td class="text-right">
                                            <actions-dropdown :row="row"></actions-dropdown>
                                        </td>
                                    </tr>

                                    <tr v-if="records.length === 0">
                                        <td colspan="20" class="text-center text-muted">No data available.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="vgt-wrap__footer vgt-clearfix">
                            <!-- Rows per page -->
                            <div class="footer__row-count vgt-pull-left">
                                <form>
                                    <label class="footer__row-count__label">Rows per page:</label>
                                    <select v-model.number="pagination.per_page" @change="fetchRecords(1)" class="footer__row-count__select">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </form>
                            </div>

                            <!-- Showing X to Y of Z -->
                            <div class="footer__navigation vgt-pull-right">
                                <div class="footer__navigation__page-info">
                                    <div v-if="pagination.total > 0">
                                        Showing @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }} entries
                                    </div>
                                    <div v-else class="text-muted">
                                        No entries found
                                    </div>
                                </div>

                                <!-- Prev / Next Buttons -->
                                <button type="button"
                                        class="footer__navigation__page-btn"
                                        :class="{ disabled: pagination.current_page <= 1 }"
                                        :disabled="pagination.current_page <= 1"
                                        @click="fetchRecords(pagination.current_page - 1)">
                                    <span class="chevron left"></span> prev
                                </button>

                                <button type="button"
                                        class="footer__navigation__page-btn"
                                        :class="{ disabled: pagination.current_page >= pagination.last_page }"
                                        :disabled="pagination.current_page >= pagination.last_page"
                                        @click="fetchRecords(pagination.current_page + 1)">
                                    next <span class="chevron right"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/x-template" id="actions-dropdown-template">
<div class="dropdown btn-group" ref="dropdown">
    <button type="button" class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
            @click.stop="toggleDropdown">
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
    </button>

    <ul :class="['dropdown-menu dropdown-menu-right', { show: isOpen }]">

        <!-- 1. View Invoice -->
        <li>
            <a class="dropdown-item" href="#" @click.prevent="$emit('view-invoice', row.id)">
                <i class="nav-icon i-Receipt font-weight-bold mr-2"></i>
                View Invoice
            </a>
        </li>

        <!-- 1.5 View Delivery Reciept -->
        <li v-if="['approved', 'completed','archived'].includes(row.status)">
            <a class="dropdown-item" href="#" @click.prevent="$emit('view-delivery-reciept', row.id)">
                <i class="nav-icon i-Receipt font-weight-bold mr-2"></i>
                View Delivery Reciept
            </a>
        </li>

        <!-- 2. Approve – Only for pending -->
        <li v-if="row.status === 'pending'">
            <a class="dropdown-item" href="#" @click.prevent="changeStatus(row.id, 'approved')">
                <i class="nav-icon i-Like font-weight-bold mr-2"></i>
                Approve
            </a>
        </li>

        <!-- 3. Disapprove – Only for pending & approved -->
        <li v-if="['pending'].includes(row.status)">
            <a class="dropdown-item" href="#" @click.prevent="changeStatus(row.id, 'disapproved')">
                <i class="nav-icon i-Unlike-2 font-weight-bold mr-2"></i>
                Disapprove
            </a>
        </li>

        <!-- 4. Edit Receivable – Only for pending & approved -->
        <li v-if="['pending'].includes(row.status)">
            <a class="dropdown-item" :href="`/accounts-receivable/${row.id}/edit`">
                <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                Edit Receivable
            </a>
        </li>

        <!-- 5. Add Attachment -->
        <li>
            <a class="dropdown-item" href="#" @click.prevent="$emit('add-attachment', row.id)">
                <i class="nav-icon i-Add-File font-weight-bold mr-2"></i>
                Add Attachment
            </a>
        </li>

        <!-- 6. View Attached File -->
        <li>
            <a class="dropdown-item" href="#" @click.prevent="$emit('view-attachments', row.id)">
                <i class="nav-icon i-Files font-weight-bold mr-2"></i>
                View Attached File
            </a>
        </li>

        <!-- For Disapproved & Archived – Add Restore Option -->
        <li v-if="['disapproved', 'archived'].includes(row.status)">
            <a class="dropdown-item" href="#" @click.prevent="changeStatus(row.id, 'pending')">
                <i class="nav-icon i-Restore-Window font-weight-bold mr-2"></i>
                Restore to Pending
            </a>
        </li>

        <!-- 7. Edit Due Date – Only pending & approved -->
        <li v-if="['pending', 'approved'].includes(row.status)">
            <a class="dropdown-item" href="#" @click.prevent="$parent.openEditDueDateModal(row)">
                <i class="nav-icon i-Calendar font-weight-bold mr-2"></i>
                Edit Due Date
            </a>
        </li>

        <!-- 7.5 Receive Payment – Only approved -->
        <li v-if="['approved'].includes(row.status)">
            <a class="dropdown-item" href="#" 
            @click.prevent="$parent.openReceivePayment(row)">
                <i class="nav-icon i-Money font-weight-bold mr-2"></i>
                Receive Payment
            </a>
        </li>

        <!-- 7. Mark as Completed – approved -->
        <li v-if="['approved'].includes(row.status)">
            <a class="dropdown-item" href="#" @click.prevent="$emit('edit-due-date', row.id)">
                <i class="nav-icon i-Check font-weight-bold mr-2"></i>
                Mark as Completed
            </a>
        </li>

        <!-- 8. Move to Archive – pending, approved, completed, disapproved -->
        <li v-if="['pending', 'approved', 'completed', 'disapproved'].includes(row.status)">
            <a class="dropdown-item" href="#" @click.prevent="changeStatus(row.id, 'archived')">
                <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                Move to Archive
            </a>
        </li>

        <!-- ARCHIVED: Replace "Move to Archive" with these -->
        <template v-if="row.status === 'archived'">
            <li>
                <a class="dropdown-item" href="#" @click.prevent="$emit('delete-permanently', row.id)">
                    <i class="nav-icon i-Close font-weight-bold mr-2"></i>
                    Permanently Delete
                </a>
            </li>
        </template>

        <!-- 9. Logs -->
        <li>
            <a class="dropdown-item" href="#" @click.prevent="$emit('logs', row.id)">
                <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i>
                Logs
            </a>
        </li>

        <!-- 10. Remarks -->
        <li>
            <a class="dropdown-item" href="#" @click.prevent="$emit('open-remarks', row.id)">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                Remarks
            </a>
        </li>

    </ul>
</div>
</script>

<script>
    const receivables = @json($receivables);
    console.log(receivables);
</script>
<script>

window.yearRange = {
    min: {{ $minYear ?? 'null' }},
    max: {{ $maxYear ?? 'null' }}
};
Vue.component("actions-dropdown", {
    template: "#actions-dropdown-template",
    props: {
        row: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            isOpen: false
        };
    },
    methods: {
        toggleDropdown() { this.isOpen = !this.isOpen; },
        handleClickOutside(event) {
            if (!this.$refs.dropdown?.contains(event.target)) this.isOpen = false;
        },
        async changeStatus(id, status) {
            const labels = {
                approved: 'APPROVE',
                disapproved: 'DISAPPROVE',
                completed: 'MARK AS COMPLETED',
                archived: 'ARCHIVE',
                pending: 'RESTORE TO PENDING'
            };

            const result = await Swal.fire({
                title: 'Are you sure?',
                text: `You are about to ${labels[status] || status.toUpperCase()} this receivable.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const res = await axios.post(`/accounts-receivable/${id}/status`, { status });
                const rec = this.$parent.records.find(r => r.id === id);
                if (rec) {
                    rec.status = status;
                    rec.updated_at = res.data.updated_at || new Date();
                }
                this.$parent.fetchRecords(this.$parent.pagination.current_page);
                this.isOpen = false;
                this.$emit('status-updated');

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: `Receivable has been ${status}.`,
                    timer: 2000,
                    showConfirmButton: false
                });
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.response?.data?.message || 'Something went wrong!'
                });
            }
        }
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.handleClickOutside);
    }
});

Vue.component('v-select', VueSelect.VueSelect);


new Vue({
    el: '#app',

    data() {
        return {
            yearOptions: [],
            modalItems: [],
            months: [
                { label: 'All Months', value: 'all' },
                { label: 'January', value: 1 },
                { label: 'February', value: 2 },
                { label: 'March', value: 3 },
                { label: 'April', value: 4 },
                { label: 'May', value: 5 },
                { label: 'June', value: 6 },
                { label: 'July', value: 7 },
                { label: 'August', value: 8 },
                { label: 'September', value: 9 },
                { label: 'October', value: 10 },
                { label: 'November', value: 11 },
                { label: 'December', value: 12 },
            ],
            statusFilter: 'pending',
            statusList: [
                { label: 'Pending', value: 'pending' },
                { label: 'Approved', value: 'approved' },
                { label: 'Completed', value: 'completed' },
                { label: 'Disapproved', value: 'disapproved' },
                { label: 'Archived', value: 'archived' },
            ],

            filter: {
                year: null,
                month: { label: 'All Months', value: 'all' },
            },

            records: [],
            currentInvoice: null,
            paymentForm: {
                 account_receivable_id: null,
                transaction_datetime: '',
                amount: 0,
                cash_equivalent_id: null,
                payment_method_id: null,
            },
            cashEquivalents: [],
            paymentMethods: [],
            submitting: false,
            dueDateForm: {
                id: null,
                due_date: ''
            },
            submittingDueDate: false,
            currentDueDateRow: null,
            pagination: {
                current_page: 1,
                from: 0,
                to: 0,
                total: 0,
                per_page: 10,
                last_page: 1
            },
            loading: false,
        };
    },

    mounted() {
        this.generateYears();
        this.fetchRecords(); // load initial data
        this.loadPaymentOptions();

       this.$nextTick(() => {
            // Existing datetime picker (for other forms)
            if (this.$refs.someOtherPicker) { /* ... */ }

            // NEW: Initialize for Receive Payment modal
            $('#receive_payment_datetime').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                maxDate: moment(), // This line blocks future dates
                locale: {
                    format: 'YYYY-MM-DD HH:mm'
                }
            }).on('apply.daterangepicker', (ev, picker) => {
                this.paymentForm.transaction_datetime = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
            });
        });
    },

    watch: {
        "filter.year"() { this.fetchRecords(1); },
        "filter.month"() { this.fetchRecords(1); },
        statusFilter() { this.fetchRecords(1); },
        "pagination.per_page"() { this.fetchRecords(1); } // reset to page 1 when changing rows
    },

    methods: {
        openModal(items) {
    if (!items || items.length === 0) {
        this.modalItems = [];
        const modal = new bootstrap.Modal(document.getElementById('ItemDetailsModal'));
        modal.show();
        return;
    }

    this.modalItems = items.map(item => {
        const chart      = item.chart_account;
        const legacyType = item.type; // AccountingSubCategory (old records)

        return {
            account_name : chart
                ? (chart.code ? `${chart.code} – ${chart.name}` : chart.name)
                : (legacyType?.sub_category ?? 'N/A'),

            category     : chart?.category?.category
                ?? legacyType?.category?.category
                ?? 'N/A',

            sub_category : chart?.subcategory?.sub_category
                ?? legacyType?.sub_category
                ?? 'N/A',

            description  : item.description || '',
            quantity     : Number(item.qty  || 0),
            unit_price   : Number(item.unit_price || 0),

            // Handle both: new 'tax' string column OR old 'tax_id' numeric
            tax_label    : item.tax ? String(item.tax).toUpperCase() : 'NON-VAT',
            tax          : Number(item.tax_amount || 0),

            subtotal     : Number(item.sub_total || (item.qty * item.unit_price) || 0),
        };
    });

    const modal = new bootstrap.Modal(document.getElementById('ItemDetailsModal'));
    modal.show();
},

        generateYears() {
            const min = window.yearRange.min;
            const max = window.yearRange.max;
            this.yearOptions = [];

            if (!min || !max) {
                const currentYear = new Date().getFullYear();
                this.yearOptions.push({ label: currentYear, value: currentYear });
                this.filter.year = currentYear;
                return;
            }

            for (let y = max; y >= min; y--) {
                this.yearOptions.push({ label: y.toString(), value: y });
            }

            const currentYear = new Date().getFullYear();
            this.filter.year = (currentYear >= min && currentYear <= max) ? currentYear : max;
        },

        setStatus(status) {
            this.statusFilter = status;
            this.fetchRecords();
        },

        fetchRecords(page = 1) {
            if (!this.filter.year || !this.filter.month) return;

            this.loading = true;

            axios.get('/accounts-receivable/filter', {
                params: {
                    year: this.filter.year,
                    month: this.filter.month.value,
                    status: this.statusFilter,
                    page: page,
                    per_page: this.pagination.per_page || 10
                }
            })
            .then(res => {
                this.records = res.data.data;

                // Update pagination info
                this.pagination = {
                    current_page: res.data.current_page,
                    from: res.data.from || 0,
                    to: res.data.to || 0,
                    total: res.data.total,
                    per_page: parseInt(res.data.per_page),
                    last_page: res.data.last_page
                };
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Failed to load data', 'error');
            })
            .finally(() => this.loading = false);
        },

        // New: Open Receive Payment Modal
        openReceivePayment(invoice) {
            this.currentInvoice = invoice;

            this.paymentForm = {
                account_receivable_id: invoice.id,
                transaction_datetime: moment().format("YYYY-MM-DD HH:mm:ss"),
                amount: parseFloat(invoice.remaining_balance || invoice.total || 0),
                cash_equivalent_id: null,
                payment_method_id: null,
            };

            this.$nextTick(() => {
                this.initDatePickers();
                const modal = new bootstrap.Modal(document.getElementById('receivePaymentModal'));
                modal.show();
            });
        },

        loadPaymentOptions() {
            axios.get('/receive-payment-options')
                .then(res => {
                    this.cashEquivalents = res.data.cash_equivalents;
                    this.paymentMethods   = res.data.payment_methods;
                })
                .catch(() => {
                    Swal.fire('Error', 'Failed to load payment options', 'error');
                });
        },

        initDatePickers() {
            const vm = this;
            const today = moment();

            $('#receive_payment_datetime').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                maxDate: today, // Prevent future datetime
                locale: { format: 'YYYY-MM-DD HH:mm:ss' }
            }).on('apply.daterangepicker', (ev, picker) => {
                vm.paymentForm.transaction_datetime = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
            });
        },

        openEditDueDateModal(row) {
            this.currentDueDateRow = row;
            
            const existingDueDate = row.due_date ? moment(row.due_date) : null;
            const today = moment().startOf('day');

            this.dueDateForm = {
                id: row.id,
                due_date: existingDueDate && existingDueDate.isSameOrAfter(today, 'day')
                    ? existingDueDate.format('YYYY-MM-DD')
                    : today.format('YYYY-MM-DD')  // Force today if old date was in the past
            };

            this.$nextTick(() => {
                this.initDueDatePicker();
                const modal = new bootstrap.Modal(document.getElementById('editDueDateModal'));
                modal.show();
            });
        },

        initDueDatePicker() {
            const vm = this;
            const today = moment().startOf('day'); // Today at 00:00

            // Destroy previous instance if exists
            if ($('#due_date_picker').data('daterangepicker')) {
                $('#due_date_picker').data('daterangepicker').remove();
            }

            $('#due_date_picker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minDate: today,                    // This disables all past dates
                startDate: vm.dueDateForm.due_date ? moment(vm.dueDateForm.due_date) : today,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }).on('apply.daterangepicker', function(ev, picker) {
                const selectedDate = picker.startDate.format('YYYY-MM-DD');
                vm.dueDateForm.due_date = selectedDate;
                $(this).val(selectedDate);
            }).on('cancel.daterangepicker', function() {
                $(this).val('');
                vm.dueDateForm.due_date = '';
            });

            // Pre-fill if due_date already exists and is today or future
            if (vm.dueDateForm.due_date) {
                const date = moment(vm.dueDateForm.due_date);
                if (date.isSameOrAfter(today, 'day')) {
                    $('#due_date_picker').val(date.format('YYYY-MM-DD'));
                } else {
                    // If current due_date is in the past, default to today
                    vm.dueDateForm.due_date = today.format('YYYY-MM-DD');
                    $('#due_date_picker').val(today.format('YYYY-MM-DD'));
                }
            } else {
                $('#due_date_picker').val(today.format('YYYY-MM-DD'));
                vm.dueDateForm.due_date = today.format('YYYY-MM-DD');
            }
        },

        async submitDueDate() {
            if (this.submittingDueDate || !this.dueDateForm.due_date) return;

            this.submittingDueDate = true;

            try {
                const response = await axios.patch(`/accounts-receivable/${this.dueDateForm.id}/due-date`, {
                    due_date: this.dueDateForm.due_date
                });

                // Update the row in the table
                const record = this.records.find(r => r.id === this.dueDateForm.id);
                if (record) {
                    record.due_date = this.dueDateForm.due_date;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Due date updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                this.fetchRecords(this.pagination.current_page);

                bootstrap.Modal.getInstance(document.getElementById('editDueDateModal')).hide();
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.response?.data?.message || 'Failed to update due date.'
                });
            } finally {
                this.submittingDueDate = false;
            }
        },


        async submitPayment() {
            if (this.submitting) return;
            this.submitting = true;

            const url = `/accounts-receivables/${this.paymentForm.account_receivable_id}/payments`;

            try {
                await axios.post(url, this.paymentForm);

                // Success SweetAlert
                await Swal.fire({
                    icon: 'success',
                    title: 'Payment Recorded!',
                    text: 'The payment has been successfully saved.',
                    timer: 2500,
                    showConfirmButton: false
                });

                bootstrap.Modal.getInstance(document.getElementById('receivePaymentModal')).hide();
                this.fetchRecords(this.pagination.current_page);

                // Reset form
                this.paymentForm = {
                    account_receivable_id: this.paymentForm.account_receivable_id,
                    transaction_datetime: '',
                    amount: 0,
                    cash_equivalent_id: null,
                    payment_method_id: null,
                };

            } catch (err) {
                const msg = err.response?.data?.message || 'Payment failed. Please try again.';
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed',
                    text: msg
                });
            } finally {
                this.submitting = false;
            }
        },
        clearPaymentDate() {
            this.paymentForm.transaction_datetime = '';
            $('#receive_payment_datetime').val(''); // Clear the input visually
        },
    },
    computed: {
         modalSubTotal() {
            return this.modalItems.reduce((sum, item) => sum + Number(item.subtotal), 0);
        },
        modalTax() {
            return this.modalItems.reduce((sum, item) => sum + Number(item.tax), 0);
        },
        modalTotal() {
            return this.modalSubTotal + this.modalTax;
        }
    },

});
</script>


@endsection