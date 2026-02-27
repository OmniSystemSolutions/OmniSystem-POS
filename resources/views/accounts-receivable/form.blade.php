@extends('layouts.app')
@section('content')

<div class="main-content" id="app">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">
                {{ $mode === 'edit' ? 'Edit Accounts Receivable' : 'Create Accounts Receivable' }}
            </h1>
            <ul>
                <li><a href="/accounts-receivable">Accounting</a></li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>

    <div class="wrapper">
        <div class="row">

            {{-- ─── STEP 1: Basic Information ──────────────────────────────────── --}}
            <div class="px-xl-1 col-lg-6 col-xl-3">
                <div class="list-group h-100">
                    <div class="list-group-item h-100 mb-3">
                        <div :style="{ opacity: step1Locked ? 0.7 : 1, pointerEvents: step1Locked ? 'none' : 'auto' }">
                            <p><span class="t-font-boldest">Step 1: Basic Information</span></p>

                            <fieldset class="form-group">
                                <legend class="col-form-label pt-0">Date And Time of Transaction *</legend>
                                <div class="d-flex">
                                    <input type="text" class="form-control" id="transaction_datetime"
                                           v-model="form.transaction_datetime"
                                           :disabled="step1Locked"
                                           placeholder="Select date & time" readonly>
                                    <button type="button" class="btn btn-secondary btn-sm ml-2"
                                            @click="clearDate">Clear</button>
                                </div>
                                <small class="form-text text-muted">Cannot select future date. Edit to backdate.</small>
                            </fieldset>

                            <fieldset class="form-group">
                                <legend class="col-form-label pt-0">Reference #</legend>
                                <input type="text" class="form-control"
                                       v-model="form.reference_no" :disabled="true"
                                       placeholder="Auto-generated">
                                <small class="text-muted">Auto-generated per branch (e.g., AR-15-00001)</small>
                            </fieldset>

                            <fieldset class="form-group mt-3">
                                <legend class="col-form-label pt-0">Payor Details *</legend>
                                <input type="text" class="form-control mb-2" v-model="form.payor_name"
                                       :disabled="step1Locked" placeholder="Enter Name">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="text" class="form-control mb-2" v-model="form.company"
                                       :disabled="step1Locked" placeholder="Company">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="text" class="form-control mb-2" v-model="form.address"
                                       :disabled="step1Locked" placeholder="Address">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="text" class="form-control mb-2" v-model="form.mobile_no"
                                       :disabled="step1Locked" placeholder="Mobile #">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="text" class="form-control mb-2" v-model="form.email"
                                       :disabled="step1Locked" placeholder="Email Address">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="text" class="form-control mb-2" v-model="form.tin"
                                       :disabled="step1Locked" placeholder="TIN">
                            </fieldset>

                            <fieldset class="form-group mt-3">
                                <legend class="col-form-label pt-0">Set Due Date *</legend>
                                <input type="text" id="due_date" class="form-control"
                                       v-model="form.due_date" :disabled="step1Locked"
                                       placeholder="Select Date Here" readonly>
                            </fieldset>
                        </div>

                        <div class="mt-3" v-if="step1Locked">
                            <button class="btn btn-warning btn-sm" @click="step1Locked = false">
                                Edit Basic Information
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── STEP 2: Particulars ─────────────────────────────────────────── --}}
            <div class="px-xl-1 col-lg-6 col-xl-3">
                <div class="list-group h-100">
                    <div class="list-group-item h-100 mb-3">
                        <div class="h-100 d-flex flex-column">
                            <p><span class="t-font-boldest">Step 2: Particulars</span></p>

                            {{-- Account Name — from chart_accounts --}}
                            <fieldset class="form-group">
                                <legend class="bv-no-focus-ring col-form-label pt-0">Account Name *</legend>
                                <select class="form-control" v-model="form.chart_account_id"
                                        @change="onAccountNameChange">
                                    <option value="" disabled hidden>Select Account Name</option>
                                    <option v-for="a in accountNames" :key="a.id" :value="a.id">
                                        @{{ a.display_name }}
                                    </option>
                                </select>
                            </fieldset>

                            {{-- Category + Type — auto-filled, read-only --}}
                            <fieldset class="form-group">
                                <div class="row">
                                    <div class="col-6 pr-1">
                                        <legend class="bv-no-focus-ring col-form-label pt-0">Category</legend>
                                        <input type="text" class="form-control"
                                               :value="form.category_display"
                                               readonly placeholder="Auto-filled"
                                               style="background:#f8f9fa; cursor:default;">
                                    </div>
                                    <div class="col-6 pl-1">
                                        <legend class="bv-no-focus-ring col-form-label pt-0">Sub Category</legend>
                                        <input type="text" class="form-control"
                                               :value="form.sub_category_display"
                                               readonly placeholder="Auto-filled"
                                               style="background:#f8f9fa; cursor:default;">
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-group">
                                <legend class="bv-no-focus-ring col-form-label pt-0">Description *</legend>
                                <textarea rows="3" class="form-control" v-model="form.description"
                                          placeholder="Enter Description here"></textarea>
                            </fieldset>

                            <fieldset class="form-group">
                                <legend class="bv-no-focus-ring col-form-label pt-0">Mode *</legend>
                                <div class="d-flex gap-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="mode_regular" value="Regular"
                                               class="custom-control-input" v-model="form.mode">
                                        <label class="custom-control-label" for="mode_regular">Regular</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="mode_recurring" value="Recurring"
                                               class="custom-control-input" v-model="form.mode">
                                        <label class="custom-control-label" for="mode_recurring">Recurring</label>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-group">
                                <legend class="bv-no-focus-ring col-form-label pt-0">Quantity *</legend>
                                <input type="number" class="form-control"
                                       v-model.number="form.quantity" min="1">
                            </fieldset>

                            <fieldset class="form-group">
                                <legend class="bv-no-focus-ring col-form-label pt-0">Tax</legend>
                                <select class="form-control" v-model="form.tax">
                                    <option value="VAT">VAT</option>
                                    <option value="NON-VAT">NON-VAT</option>
                                    <option value="ZERO-RATED">Zero Rated</option>
                                </select>
                            </fieldset>

                            <fieldset class="form-group mb-3">
                                <legend class="bv-no-focus-ring col-form-label pt-0">Amount per Unit *</legend>
                                <input type="number" step="0.01" class="form-control"
                                       placeholder="0" v-model.number="form.amount_per_unit">
                            </fieldset>

                            <div class="mt-auto">
                                <button class="btn btn-info" @click.prevent="addSummary">
                                    Add to Summary
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── STEP 3: Summary ─────────────────────────────────────────────── --}}
            <div class="px-xl-1 col-lg-12 col-xl-6">
                <div class="list-group h-100">
                    <div class="list-group-item h-100 mb-3">
                        <div class="h-100 d-flex flex-column">
                            <p><span class="t-font-boldest">Step 3: Summary</span></p>

                            <div class="table-responsive flex-grow-1">
                                <table class="table table-hover tableOne">
                                    <thead>
                                        <tr>
                                            <th>Account Name</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Sub-Total</th>
                                            <th>Tax</th>
                                            <th>Total</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="!summaryList.length">
                                            <td colspan="9" class="text-center text-muted">No items added</td>
                                        </tr>
                                        <tr v-for="(item, index) in summaryList" :key="index">
                                            <td>@{{ item.account_name_display }}</td>
                                            <td>@{{ item.category_display }}</td>
                                            <td>@{{ item.sub_category_display }}</td>
                                            <td>@{{ item.description }}</td>
                                            <td>@{{ item.quantity }}</td>
                                            <td>₱@{{ item.subtotal.toFixed(2) }}</td>
                                            <td>₱@{{ item.tax_amount.toFixed(2) }}</td>
                                            <td>₱@{{ item.total.toFixed(2) }}</td>
                                            <td class="text-right">
                                                <button class="btn btn-sm btn-danger"
                                                        @click="removeSummary(index)">Remove</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <div class="offset-md-6 col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <td class="font-weight-bold">Sub-Total</td>
                                            <td>@{{ formatSubTotal }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tax</td>
                                            <td>@{{ formatTax }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Amount</td>
                                            <td class="font-weight-bold">@{{ formatTotalAmount }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-auto d-flex gap-2">
                                <button class="btn btn-primary" @click="submitReceivable"
                                        :disabled="isSubmitting">
                                    <i class="i-Yes mr-1"></i>
                                    {{ $mode === 'edit' ? 'Update' : 'Submit' }}
                                </button>
                                <a href="/accounts-receivable" class="btn btn-outline-secondary ml-4">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
new Vue({
    el: '#app',

    data() {
        return {
            mode:       '{{ $mode ?? "create" }}',
            receivable: @json($receivable ?? null),

            // Account names from chart_accounts
            accountNames: [],

            summaryList:  [],
            step1Locked:  false,
            isSubmitting: false,

            form: {
                transaction_datetime: '',
                reference_no:         '{{ $next_reference_no ?? "" }}',
                payor_name:           '',
                company:              '',
                address:              '',
                mobile_no:            '',
                email:                '',
                tin:                  '',
                due_date:             '',

                // Step 2 fields
                chart_account_id:    '',   // selected from Account Name dropdown
                category_display:    '',   // auto-filled (read-only display)
                sub_category_display:'',   // auto-filled (read-only display)
                // Internal IDs stored for submission
                accounting_category_id:    null,
                accounting_subcategory_id: null,

                description:     '',
                mode:            'Regular',
                quantity:        1,
                amount_per_unit: '',
                tax:             'VAT',
            },
        };
    },

    computed: {
        isStep2Valid() {
            return this.form.chart_account_id &&
                   this.form.description &&
                   this.form.quantity > 0 &&
                   this.form.amount_per_unit > 0;
        },
        subTotal() {
            return this.summaryList.reduce((s, i) => s + i.subtotal, 0);
        },
        totalTax() {
            return this.summaryList.reduce((s, i) => s + i.tax_amount, 0);
        },
        totalAmount() {
            return this.subTotal + this.totalTax;
        },
        formatSubTotal()   { return '₱' + this.subTotal.toLocaleString('en-US',   { minimumFractionDigits: 2 }); },
        formatTax()        { return '₱' + this.totalTax.toLocaleString('en-US',   { minimumFractionDigits: 2 }); },
        formatTotalAmount(){ return '₱' + this.totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2 }); },
    },

    mounted() {
        this.fetchAccountNames();
        this.$nextTick(() => {
            this.initDatePickers();
            if (this.mode === 'edit' && this.receivable) {
                this.loadEditData();
            }
        });
    },

    methods: {

        // ─── Fetch chart_accounts ──────────────────────────────────────────
        fetchAccountNames() {
            axios.get('/api/receivable/account-names').then(res => {
                this.accountNames = res.data;
            }).catch(() => {
                console.error('Failed to load account names');
            });
        },

        // ─── When Account Name is selected → auto-fill Category & Sub Category
        onAccountNameChange() {
            const selected = this.accountNames.find(a => a.id == this.form.chart_account_id);

            if (selected) {
                this.form.category_display         = selected.category_name    || '';
                this.form.sub_category_display     = selected.subcategory_name || '';
                this.form.accounting_category_id   = selected.category_id      || null;
                this.form.accounting_subcategory_id= selected.subcategory_id   || null;
            } else {
                this.form.category_display          = '';
                this.form.sub_category_display      = '';
                this.form.accounting_category_id    = null;
                this.form.accounting_subcategory_id = null;
            }
        },

        // ─── Add to Summary ────────────────────────────────────────────────
        addSummary() {
            if (!this.isStep2Valid) {
                Swal.fire('Incomplete', 'Please fill in all required fields.', 'warning');
                return;
            }

            const account  = this.accountNames.find(a => a.id == this.form.chart_account_id);
            const qty      = Number(this.form.quantity);
            const price    = Number(this.form.amount_per_unit);
            const taxRate  = this.form.tax === 'VAT' ? 0.12 : 0;
            const subtotal = qty * price;
            const taxAmt   = subtotal * taxRate;
            const total    = subtotal + taxAmt;

            this.summaryList.push({
                chart_account_id      : this.form.chart_account_id,
                account_name_display  : account ? account.display_name : '',
                category_display      : this.form.category_display,
                sub_category_display  : this.form.sub_category_display,
                accounting_category_id   : this.form.accounting_category_id,
                accounting_subcategory_id: this.form.accounting_subcategory_id,
                description           : this.form.description,
                quantity              : qty,
                unit_price            : price,
                tax                   : this.form.tax,
                tax_amount            : taxAmt,
                subtotal,
                total,
            });

            // Reset Step 2 fields
            this.form.chart_account_id          = '';
            this.form.category_display          = '';
            this.form.sub_category_display      = '';
            this.form.accounting_category_id    = null;
            this.form.accounting_subcategory_id = null;
            this.form.description               = '';
            this.form.quantity                  = 1;
            this.form.amount_per_unit           = '';
            this.form.tax                       = 'VAT';

            // Lock Step 1 on first add
            if (this.summaryList.length === 1) {
                this.step1Locked = true;
            }
        },

        removeSummary(index) {
            this.summaryList.splice(index, 1);
        },

        // ─── Submit ────────────────────────────────────────────────────────
        async submitReceivable() {
            if (this.summaryList.length === 0) {
                Swal.fire('Error', 'Please add at least 1 item to the summary.', 'error');
                return;
            }

            if (!this.form.transaction_datetime || !this.form.payor_name || !this.form.due_date) {
                Swal.fire('Error', 'Please complete Step 1 basic information.', 'error');
                return;
            }

            this.isSubmitting = true;

            const payload = {
                transaction_datetime : this.form.transaction_datetime,
                payor_name           : this.form.payor_name,
                company              : this.form.company,
                address              : this.form.address,
                mobile_no            : this.form.mobile_no,
                email                : this.form.email,
                tin                  : this.form.tin,
                due_date             : this.form.due_date,

                items: this.summaryList.map(i => ({
                    chart_account_id: i.chart_account_id,
                    type_id         : i.accounting_subcategory_id,
                    description     : i.description,
                    qty             : i.quantity,
                    unit_price      : i.unit_price,
                    tax             : i.tax,
                    tax_amount      : i.tax_amount,
                    sub_total       : i.subtotal,
                    total_amount    : i.total,
                })),

                sub_total    : this.subTotal,
                total_tax    : this.totalTax,
                total_amount : this.totalAmount,
            };

            const url = this.mode === 'edit'
                ? `/accounts-receivable/${this.receivable.id}/update`
                : '/accounts-receivable/store';

            try {
                await axios.post(url, payload);
                Swal.fire('Success!', 'Accounts Receivable saved.', 'success');
                setTimeout(() => location.href = '/accounts-receivable', 1500);
            } catch (err) {
                const errors = err.response?.data?.errors;
                const msg    = errors
                    ? Object.values(errors).flat().join('\n')
                    : (err.response?.data?.message || 'Failed to save');
                Swal.fire('Error', msg, 'error');
            } finally {
                this.isSubmitting = false;
            }
        },

        // ─── Date Pickers ──────────────────────────────────────────────────
        initDatePickers() {
            const vm  = this;
            const now = moment().format('YYYY-MM-DD HH:mm:ss');

            if (!this.form.transaction_datetime && this.mode !== 'edit') {
                this.form.transaction_datetime = now;
            }

            $('#transaction_datetime').daterangepicker({
                singleDatePicker : true,
                showDropdowns    : true,
                timePicker       : true,
                timePicker24Hour : true,
                timePickerIncrement: 1,
                autoApply        : true,
                maxDate          : moment(),
                drops            : 'down',
                locale           : { format: 'YYYY-MM-DD HH:mm:ss' },
                startDate        : this.form.transaction_datetime || now,
            }).on('apply.daterangepicker', (ev, picker) => {
                vm.form.transaction_datetime = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
            });

            $('#transaction_datetime').val(this.form.transaction_datetime);

            $('#due_date').daterangepicker({
                singleDatePicker : true,
                showDropdowns    : true,
                autoApply        : true,
                minDate          : moment(),
                drops            : 'down',
                locale           : { format: 'YYYY-MM-DD' },
                startDate        : this.form.due_date || moment(),
            }).on('apply.daterangepicker', (ev, picker) => {
                vm.form.due_date = picker.startDate.format('YYYY-MM-DD');
            });

            if (this.form.due_date) {
                $('#due_date').val(this.form.due_date);
            }
        },

        clearDate() {
            this.form.transaction_datetime = '';
            $('#transaction_datetime').val('');
        },

        // ─── Load Edit Data ────────────────────────────────────────────────
        loadEditData() {
            const r = this.receivable;

            this.form.transaction_datetime = r.transaction_datetime || '';
            this.form.reference_no         = r.reference_no         || '';
            this.form.payor_name           = r.payor_name           || '';
            this.form.company              = r.company              || '';
            this.form.address              = r.address              || '';
            this.form.mobile_no            = r.mobile_no            || '';
            this.form.email                = r.email                || '';
            this.form.tin                  = r.tin                  || '';
            this.form.due_date             = r.due_date             || '';

            this.$nextTick(() => {
                if (r.transaction_datetime) {
                    $('#transaction_datetime').data('daterangepicker')
                        ?.setStartDate(moment(r.transaction_datetime));
                    $('#transaction_datetime').val(r.transaction_datetime);
                }
                if (r.due_date) {
                    $('#due_date').data('daterangepicker')
                        ?.setStartDate(moment(r.due_date));
                    $('#due_date').val(r.due_date);
                }
            });

            this.summaryList = (r.items || []).map(item => ({
                chart_account_id         : item.chart_account_id         || null,
                account_name_display     : item.account_name             || 'Unknown',
                category_display         : item.category                 || 'Unknown',
                sub_category_display     : item.sub_category_name        || 'Unknown',
                accounting_category_id   : null,
                accounting_subcategory_id: item.type_id                  || null,
                description              : item.description              || '',
                quantity                 : Number(item.quantity)         || 0,
                unit_price               : Number(item.unit_price)       || 0,
                tax                      : item.tax                      || 'NON-VAT',
                tax_amount               : Number(item.tax_amount)       || 0,
                subtotal                 : Number(item.subtotal)         || 0,
                total                    : Number(item.total)            || 0,
            }));

            if (this.summaryList.length > 0) {
                this.step1Locked = true;
            }
        },
    },
});
</script>
@endsection