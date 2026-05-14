@extends('layouts.app')
@section('content')
<style>
    .sortable {
        user-select: none;
    }

    .sortable span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .modern-search-wrapper {
        position: relative;
        width: 320px;
    }

    .modern-search-input {
        width: 100%;

        border: 1px solid #e2e8f0;

        border-radius: 12px;

        padding: 10px 40px;

        font-size: 14px;

        transition: all 0.2s ease;
    }

    .modern-search-input:focus {
        outline: none;

        border-color: #6366f1;

        box-shadow:
            0 0 0 4px rgba(99, 102, 241, 0.10);
    }

    .search-icon {
        position: absolute;

        left: 14px;
        top: 50%;

        transform: translateY(-50%);

        color: #94a3b8;
    }

    .audit-table-container {
        max-height: 500px;

        overflow-x: auto;
        overflow-y: auto;

        border-radius: 14px;

        border: 1px solid #eef2f7;
    }

    .audit-table-container thead th {
        position: sticky;

        top: 0;

        background: #fff;

        z-index: 20;
    }

    .vgt-table tbody tr {
        transition: all 0.15s ease;
    }

    .vgt-table tbody tr:hover {
        background: #f8fafc;
    }
</style>

<div class="main-content" id="app">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Inventory</h1>
            <ul>
                <li><a href="">{{ $mode === 'edit' ? 'Edit Audit Form' : 'Create Audit Form' }}</a></li>
            </ul>
            <div class="breadcrumb-action"></div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>

    <div class="wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Reference Number -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <fieldset class="form-group">
                            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0">Reference # *</legend>
                            <input type="text" class="form-control" v-model="referenceNo" readonly placeholder="Auto-generated Reference #">
                        </fieldset>
                    </div>

                    <!-- Entry Date/Time -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <fieldset class="form-group">
                            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0">Date and Time of Entry</legend>
                            <div class="d-flex align-items-center">
                                <div class="vue-daterange-picker form-control reportrange-text">@{{ formattedNow }}</div>
                                <button type="button" class="btn ml-2 btn-secondary btn-sm" @click="clearDate">Clear</button>
                            </div>
                            <small class="form-text text-muted">
                                Edit the Date/Time to backdate, otherwise leave blank for real-time.
                            </small>
                        </fieldset>
                    </div>

                    <!-- Audit Date/Time -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <fieldset class="form-group">
                            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0">Date and Time of Audit *</legend>
                            <div class="d-flex align-items-center">
                                <div class="vue-daterange-picker form-control reportrange-text">@{{ formattedAudit }}</div>
                                <button type="button" class="btn ml-2 btn-secondary btn-sm" @click="clearAuditDate">Clear</button>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Auditor -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <fieldset class="form-group">
                            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0">Audited by *</legend>
                            <select class="form-control" v-model="selectedAuditor">
                                <option disabled value="">Select Auditor</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">@{{ user.name }}</option>
                            </select>
                        </fieldset>
                    </div>

                    <!-- Type -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <fieldset class="form-group">
                            <legend tabindex="-1" class="bv-no-focus-ring col-form-label pt-0">Type *</legend>
                            <v-select v-model="selectedType" :options="auditTypeOptions" :clearable="true" placeholder="Select type" label="label"></v-select>
                        </fieldset>
                    </div>

                    <!-- Products Table -->
                    <div class="col-sm-12">
                        <div class="list-group mt-2">
                            <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">

                                <h6 class="mb-0 font-weight-bold">
                                    List of Items to Audit
                                </h6>

                                <div class="modern-search-wrapper">

                                    <i class="fa fa-search search-icon"></i>

                                    <input
                                        type="text"
                                        v-model="search"
                                        placeholder="Search items..."
                                        class="modern-search-input" />

                                </div>

                            </div>
                            <div class="list-group-item audit-table-container">
                                <table class="table-hover tableOne vgt-table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" v-model="selectAll" @change="toggleAll"></th>
                                            <th @click="sortTable('name')" class="sortable">Name <i :class="sortIcon('name')"></i></th>
                                            <th @click="sortTable('code')" class="sortable">SKU (Code) <i :class="sortIcon('code')"></i></th>
                                            <th @click="sortTable('category')" class="sortable">Category <i :class="sortIcon('category')"></i></th>
                                            <th @click="sortTable('subcategory')" class="sortable">Subcategory <i :class="sortIcon('subcategory')"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in sortedData" :key="item.id" @click="toggleRow(item)" :class="{     'table-primary': selected.includes(item.id) }" style="cursor: pointer;">
                                            <td><input type="checkbox" v-model="selected" :value="item.id" @click.stop></td>
                                            <td>@{{ item.name }}</td>
                                            <td>@{{ item.code }}</td>
                                            <td>@{{ item.category ? item.category.name : 'N/A' }}</td>
                                            <td>@{{ item.subcategory ? item.subcategory.name : 'N/A' }}</td>
                                        </tr>

                                        <tr v-if="!items.length">
                                            <td colspan="6" class="text-center text-muted">No items found</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">

                                    <div class="text-muted small">
                                        Showing
                                        @{{ filteredData.length ? ((currentPage - 1) * perPage) + 1 : 0 }}
                                        -
                                        @{{ Math.min(currentPage * perPage, filteredData.length) }}
                                        of
                                        @{{ filteredData.length }}
                                        items
                                    </div>

                                    <div class="d-flex align-items-center gap-2">

                                        <button
                                            class="btn btn-sm btn-outline-secondary"
                                            :disabled="currentPage === 1"
                                            @click="currentPage--">
                                            Previous
                                        </button>

                                        <span class="mx-2 small">
                                            Page @{{ currentPage }} of @{{ totalPages || 1 }}
                                        </span>

                                        <button
                                            class="btn btn-sm btn-outline-secondary"
                                            :disabled="currentPage >= totalPages"
                                            @click="currentPage++">
                                            Next
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Products Quantity -->
                    <div class="col-sm-12">
                        <div class="list-group mt-4">
                            <div class="list-group-item audit-table-container">
                                <h6 class="mb-0 font-weight-bold">Enter Quantity of Audited Items Here</h6>
                            </div>
                            <div class="list-group-item audit-table-container">
                                <table class="table-hover tableOne vgt-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>SKU</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="selectedItems.length === 0">
                                            <td colspan="7" class="text-center">No Selected Items</td>
                                        </tr>
                                        <tr v-for="item in selectedItems" :key="item.id">
                                            <td>@{{ item.name }}</td>
                                            <td>@{{ item.code }}</td>
                                            <td>@{{ item.category ? item.category.name : 'N/A' }}</td>
                                            <td>@{{ item.subcategory ? item.subcategory.name : 'N/A' }}</td>
                                            <td>
                                                <div style="width: 200px;">
                                                    <div role="group" class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-primary" @click="decrementQuantity(item)">-</button>
                                                        </div>
                                                        <input type="number" class="form-control" v-model.number="item.quantity" min="0" step="0.01">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary" @click="incrementQuantity(item)">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>@{{ item.unit || 'N/A' }}</td>
                                            <td class="vgt-left-align text-right">
                                                <div role="group" class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-danger" @click="removeItem(item)">Remove</button>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-3 col-md-12">
                        <div class="d-flex mt-4">
                            <button type="button" class="btn btn-primary mr-2" @click="submitAudit">
                                <i class="i-Yes me-2 font-weight-bold"></i> Submit
                            </button>
                            <a href="/app/inventory/audits" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    Vue.component('v-select', VueSelect.VueSelect);

    new Vue({
        el: '#app',
        data() {
            return {
                mode: '{{ $mode ?? "create" }}',
                audit: @json($audit ?? null),
                items: [], // unified items array
                users: @json($users),
                selected: [],
                selectAll: false,
                selectedAuditor: '{{ $audit->audited_by ?? "" }}',
                selectedType: {
                    label: 'Products',
                    value: 'products'
                },
                auditTypeOptions: [{
                        label: 'Products',
                        value: 'products'
                    },
                    {
                        label: 'Components',
                        value: 'components'
                    },
                    {
                        label: 'Consumables/Engineering',
                        value: 'consumables'
                    },
                    {
                        label: 'Assets',
                        value: 'assets'
                    }
                ],
                referenceNo: '',
                currentDateTime: '{{ $audit->entry_datetime ?? now() }}',
                auditDateTime: '{{ $audit->audit_datetime ?? now() }}',
                currentSort: '',
                currentSortDir: 'asc',
                isSubmitting: false,
                search: '',
                currentPage: 1,
                perPage: 10,
            }
        },
        computed: {

            formattedNow() {
                return new Date(this.currentDateTime).toLocaleString();
            },

            formattedAudit() {
                return new Date(this.auditDateTime).toLocaleString();
            },

            filteredData() {

                if (!this.search) {
                    return this.items;
                }

                const keyword = this.search.toLowerCase();

                return this.items.filter(item => {

                    return (
                        item.name?.toLowerCase().includes(keyword) ||
                        item.code?.toLowerCase().includes(keyword) ||
                        item.category?.name?.toLowerCase().includes(keyword) ||
                        item.subcategory?.name?.toLowerCase().includes(keyword)
                    );

                });

            },

            sortedData() {

                let data = [...this.filteredData];

                if (this.currentSort) {

                    data.sort((a, b) => {

                        let modifier = this.currentSortDir === 'asc' ? 1 : -1;

                        let valA = a[this.currentSort];
                        let valB = b[this.currentSort];

                        if (valA && typeof valA === 'object') {
                            valA = valA.name;
                        }

                        if (valB && typeof valB === 'object') {
                            valB = valB.name;
                        }

                        valA = valA ?
                            valA.toString().toLowerCase() :
                            '';

                        valB = valB ?
                            valB.toString().toLowerCase() :
                            '';

                        return valA < valB ?
                            -1 * modifier :
                            valA > valB ?
                            1 * modifier :
                            0;

                    });

                }

                const start = (this.currentPage - 1) * this.perPage;

                const end = start + this.perPage;

                return data.slice(start, end);

            },

            totalPages() {
                return Math.ceil(this.filteredData.length / this.perPage);
            },

            selectedItems() {
                return this.items.filter(i => this.selected.includes(i.id));
            }

        },
        mounted() {
            // Determine selected type
            if (this.mode === 'edit' && this.audit) {
                this.selectedType = this.audit.type === 'components' ? {
                    label: 'Components',
                    value: 'components'
                } : {
                    label: 'Products',
                    value: 'products'
                };
            }

            // Auto-generate reference number in CREATE mode
            if (this.mode === 'create') {
                this.generateReferenceNo();
            }

            // Fetch items for both create and edit
            axios.get('/inventory/items/fetch', {
                    params: {
                        type: this.selectedType.value
                    }
                })
                .then(res => {
                    // Add quantity field to all items
                    this.items = res.data.items.map(i => ({
                        ...i,
                        quantity: 0
                    }));

                    // PRELOAD for EDIT mode
                    if (this.mode === 'edit' && this.audit) {
                        // Map selected item IDs correctly
                        const itemIdField = this.selectedType.value === 'products' ? 'product_id' : 'component_id';
                        const itemIds = this.audit.items.map(a => a[itemIdField]);
                        this.selected = itemIds;

                        // Assign correct quantities to each item
                        this.items.forEach(i => {
                            const matched = this.audit.items.find(a => a[itemIdField] === i.id);
                            if (matched) {
                                i.quantity = Number(matched.quantity) || 0;
                            }
                        });
                    }
                })
                .catch(e => {
                    console.error('Failed to fetch items:', e);
                    Swal.fire('Error', 'Failed to load items for selected type', 'error');
                });
        },
        watch: {
            async selectedType(newVal, oldVal) {
                if (!newVal || (oldVal && newVal.value === oldVal.value)) return;
                this.selected = [];
                this.selectAll = false;
                this.loadItems();
            }
        },
        methods: {
            // ----------------- Sorting -----------------
            sortTable(col) {
                if (this.currentSort === col) this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                else {
                    this.currentSort = col;
                    this.currentSortDir = 'asc';
                }
            },

            sortIcon(col) {
                return ['fa', this.currentSort === col ? (this.currentSortDir === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort'];
            },

            // ----------------- Selection -----------------
            toggleAll() {
                this.selected = this.selectAll ? this.items.map(i => i.id) : [];
            },
            toggleRow(item) {

                const exists = this.selected.includes(item.id);

                if (exists) {

                    this.selected = this.selected.filter(
                        id => id !== item.id
                    );

                } else {

                    this.selected.push(item.id);

                }

            },


            // ----------------- Quantity -----------------
            incrementQuantity(item) {
                item.quantity = parseFloat(item.quantity) + 1;
            },
            decrementQuantity(item) {
                item.quantity = Math.max(parseFloat(item.quantity) - 1, 0);
            },
            removeItem(item) {
                this.selected = this.selected.filter(id => id !== item.id);
                item.quantity = 0;
            },



            // ----------------- Dates -----------------
            clearDate() {
                this.currentDateTime = null;
                this.auditDateTime = null;
            },
            clearAuditDate() {
                this.auditDateTime = null;
            },

            // ----------------- Reference -----------------
            generateReferenceNo() {
                const now = new Date();
                const yyyy = now.getFullYear();
                const mm = String(now.getMonth() + 1).padStart(2, '0');
                const dd = String(now.getDate()).padStart(2, '0');
                const hh = String(now.getHours()).padStart(2, '0');
                const min = String(now.getMinutes()).padStart(2, '0');
                const ss = String(now.getSeconds()).padStart(2, '0');
                this.referenceNo = `AUD-${yyyy}${mm}${dd}${hh}${min}${ss}`;
            },

            // ----------------- Form -----------------
            resetForm() {
                this.selected = [];
                this.selectAll = false;
                this.items.forEach(i => i.quantity = 0);
                this.selectedAuditor = '';
                this.generateReferenceNo();
                this.currentDateTime = new Date();
                this.auditDateTime = new Date();
            },

            // ----------------- Load Items -----------------
            async loadItems() {
                try {
                    const response = await axios.get('/inventory/items/fetch', {
                        params: {
                            type: this.selectedType.value
                        }
                    });
                    this.items = response.data.items.map(i => ({
                        id: i.id,
                        ...i,
                        quantity: 0
                    }));

                    // Preload selected items and quantities in edit mode
                    if (this.mode === 'edit' && this.audit) {
                        const itemIds = this.audit.items.map(a => a.product_id ?? a.component_id);
                        this.selected = itemIds;

                        this.items.forEach(i => {
                            const field = this.selectedType.value === 'products' ? 'product_id' : 'component_id';
                            const matched = this.audit.items.find(a => a[field] === i.id);
                            if (matched) i.quantity = matched.quantity;
                        });
                    }
                } catch (e) {
                    console.error('Failed to fetch items', e);
                    Swal.fire('Error', 'Failed to load items', 'error');
                }
            },

            // ----------------- Submit -----------------
            async submitAudit() {
                if (this.isSubmitting) return;

                // Validation before sending
                if (!this.selectedItems.length) {
                    Swal.fire('Warning', 'Select at least one item', 'warning');
                    return;
                }
                if (!this.selectedAuditor) {
                    Swal.fire('Warning', 'Select an auditor', 'warning');
                    return;
                }

                // Validate quantities: none of the selected items should have 0 or null quantity
                const invalidItems = this.selectedItems.filter(i => i.quantity === null || i.quantity === '' || isNaN(Number(i.quantity)) || Number(i.quantity) <= 0);
                if (invalidItems.length) {
                    const names = invalidItems.map(it => it.name).slice(0, 5).join(', ');
                    const more = invalidItems.length > 5 ? ` and ${invalidItems.length - 5} more` : '';
                    Swal.fire('Warning', `Quantity cannot be 0 or empty for selected items. Affected: ${names}${more}`, 'warning');
                    return;
                }

                // Ensure reference number exists
                if (!this.referenceNo) this.generateReferenceNo();

                // Build payload
                const payload = {
                    reference_no: this.referenceNo,
                    audited_by: Number(this.selectedAuditor),
                    type: this.selectedType.value, // products/components/...
                    entry_datetime: this.currentDateTime ?
                        new Date(this.currentDateTime).toISOString().slice(0, 19).replace('T', ' ') : null,
                    audit_datetime: this.auditDateTime ?
                        new Date(this.auditDateTime).toISOString().slice(0, 19).replace('T', ' ') : null,
                    items: this.selectedItems.map(i => {
                        const itemIdField = this.selectedType.value === 'products' ? 'product_id' : 'component_id';
                        return {
                            [itemIdField]: Number(i.id),
                            quantity: Number(i.quantity) || 0,
                        };
                    })
                };

                const url = this.mode === 'edit' ?
                    `/inventory/audits/${this.audit.id}/update` :
                    '/inventory/audits/store';

                this.isSubmitting = true;
                Swal.fire({
                    title: 'Saving...',
                    html: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                try {
                    const response = await axios.post(url, payload);
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved',
                        text: response.data.message || 'Audit saved',
                        timer: 2000,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.href = '/inventory/audits';
                        }
                    });

                    if (this.mode === 'create') this.resetForm();
                } catch (error) {
                    console.error(error);

                    let msg = 'Failed to save audit';
                    if (error.response && error.response.data && error.response.data.errors) {
                        // Show first validation error
                        const firstError = Object.values(error.response.data.errors)[0][0];
                        msg = firstError || msg;
                    }

                    Swal.fire('Error', msg, 'error');
                } finally {
                    this.isSubmitting = false;
                }
            }

        }
    });
</script>


@endsection