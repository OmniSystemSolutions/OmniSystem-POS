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
            <h1 class="mr-3">Chart of Accounts</h1>
            <ul>
                <li><a href="">Accounting</a></li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>
    <div class="modal fade" id="chartsModal" tabindex="-1" aria-labelledby="chartsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chartsModalLabel">
                        @{{ isEditing ? "Edit Chart Account" : "Add Account" }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="column">
                        <!-- Date Only -->
                        <div class="col-md-12">
                            <label class="form-label">Date & Time Created</label>
                            <input type="datetime-local"
                                class="form-control"
                                :value="createdDateTime"
                                readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Account Code</label>
                            <input type="text" class="form-control" v-model="code" placeholder="Enter Account Code">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Account Name</label>
                            <input type="text" class="form-control" v-model="accountName" placeholder="Enter Name of Account">
                        </div>
                        <div class="col-md-12">
                            <label>Category</label>
                            <div class="d-flex">
                                <select class="custom-select mr-2"
                                            v-model="form.category_id">
                                            <option disabled value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                            {{ $category->category }}
                                            </option>
                                            @endforeach
                                        </select>
                                <button type="button"
                                    class="btn btn-outline-success btn-sm"
                                    @click="showCategoryForm = !showCategoryForm">
                                <i class="i-Add"></i>
                                </button>
                            </div>
                        </div>
                        <div v-if="showCategoryForm"
                            class="border rounded p-4 mt-3 bg-white shadow-sm">
                            <h4 class="text-center mb-4">Add Category</h4>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text"
                                    class="form-control"
                                    v-model="newCategory.category"
                                    :class="{'is-invalid': errors.category}">
                                <div class="invalid-feedback">@{{ errors.category }}</div>
                            </div>
                            <div class="form-group">
                                <label>Account Code</label>
                                <textarea class="form-control"
                                    v-model="newCategory.account_code"></textarea>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-success mr-2"
                                    @click="saveCategory">
                                Save
                                </button>
                                <button class="btn btn-danger"
                                    @click="showCategoryForm = false">
                                Cancel
                                </button>
                            </div>
                        </div>

                        <!-- Subcategory select + New button -->
                        <div class="col-md-12">
                            <label for="subcategory_id">Subcategory</label>
                            <div class="d-flex">
                                <select class="custom-select mr-2" v-model="form.subcategory_id">
                                    <option value="" disabled selected>Select Subcategory</option>
                                    <!-- Filtered subcategories -->
                                   <option v-for="sub in form.subcategories" :key="sub.id" :value="sub.id">
                                    @{{ sub.sub_category }}
                                </option>
                                </select>
                                <button type="button" class="btn btn-outline-success btn-sm" @click="toggleSubCategoryForm">
                                <i class="i-Add"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Inline New Subcategory Form -->
                        <div v-if="showSubCategoryForm" class="border rounded p-4 mt-3 bg-white shadow-sm" style="max-width:600px; margin:auto;">
                            <h4 class="text-center mb-4">Add Subcategory</h4>
                            <div class="form-group">
                                <label class="font-weight-bold">Subcategory Name</label>
                                <input type="text" class="form-control" v-model="newSubCategory.sub_category" :class="{ 'is-invalid': errors.sub_category }">
                                <div class="invalid-feedback">@{{ errors.sub_category }}</div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control" rows="3" v-model="newSubCategory.account_code" :class="{ 'is-invalid': errors.account_code }"></textarea>
                                <div class="invalid-feedback">@{{ errors.account_code }}</div>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-success px-4 mr-2" @click="saveSubCategory">Save</button>
                                <button type="button" class="btn btn-danger px-4" @click="toggleSubCategoryForm">Cancel</button>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Classification</label>
                            <select class="custom-select mr-2"
                                    v-model="classification">
                                    <option disabled value="">Select Classification</option>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">BIR Tax Mapping</label>
                            <input type="text" class="form-control" v-model="tax_mapping" placeholder="Enter BIR Tax Mapping">
                        </div>
                        <div class="col-12 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-primary" @click="saveChart">
                                <i class="i-Yes me-2"></i> @{{ isEditing ? "Update" : "Submit" }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="card mt-4">
        <div class="card-body">
            <!-- Status Tabs -->
            <nav class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item" v-for="status in statusList" :key="status.value">
                        <a href="#" class="nav-link" 
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
                                    <button type="button" class="btn btn-outline-info ripple m-1 btn-sm collapsed" aria-expanded="false" aria-controls="sidebar-right" style="overflow-anchor: none;"><i class="i-Filter-2"></i>
                                    Filter
                                    </button> <button type="button" class="btn btn-outline-success ripple m-1 btn-sm"><i class="i-File-Copy"></i> PDF
                                    </button> <button class="btn btn-sm btn-outline-danger ripple m-1"><i class="i-File-Excel"></i> EXCEL
                                    </button><button @click="openAddModal" class="btn btn-primary btn-rounded btn-icon m-1">
                                        <i class="i-Add"></i> Add
                                    </button>
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
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>Account Code</th>
                                    <th>Account Name</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Classification</th>
                                    <th>BIR Mapping</th>
                                    <th>Action</th>   
                                </tr>
                                <!---->
                                </thead>
                                <tbody>
                                    <tr v-for="row in filteredRecords" :key="row.id">
                                        <td class="vgt-left-align text-left"> @{{ row.code }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.name }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.category_name }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.subcategory_name }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.classification }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.tax_mapping }}</td>
                                        <td class="vgt-left-align text-left">
                                            <actions-dropdown :row="row" 
                                                @edit-chart="openEditModal"
                                                @archive-chart="archiveChart"
                                                @restore-chart="restoreChart"
                                                @delete-chart="deleteChart"
                                            ></actions-dropdown>
                                        </td>

                                    <tr v-if="records.length === 0">
                                        <td colspan="7" class="text-center text-muted">No data available.</td>
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
@endsection
@section('scripts')
<script type="text/x-template" id="actions-dropdown-template">
<div class="dropdown btn-group" ref="dropdown">
    <button type="button" class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
            @click.stop="toggleDropdown">
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
    </button>
    <ul :class="['dropdown-menu dropdown-menu-right', { show: isOpen }]">
        <template v-if="row.status === 'inactive'">
            <li>
                <a class="dropdown-item" @click.prevent="editChart">
                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="#" @click.prevent="$emit('delete-chart', row.id)">
                    <i class="nav-icon i-Remove-Basket font-weight-bold mr-2"></i> Permanently Delete
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="$emit('restore-chart', row.id)">
                    <i class="nav-icon i-Restore-Window font-weight-bold mr-2"></i> Restore as Active
                </a>
            </li>
        </template>
        
        <template v-else>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="editChart">
                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i> Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="archiveChart">
                    <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i> Move to Archive
                </a>
            </li>
            <li>
                <a class="dropdown-item" :href="'/chart-of-accounts/' + row.id + '/logs'">
                    <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i> Logs
                </a>
            </li>
        </template>
        <li>
            <a href="javascript:void(0);" class="dropdown-item" @click="$emit('open-remarks', row.id)">
                <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i> Remarks
            </a>
        </li>
    </ul>
</div>
</script>

<script>
Vue.component("actions-dropdown", {
    template: "#actions-dropdown-template",
    props: {
        row: { type: Object, required: true }
    },
    data() {
        return { isOpen: false };
    },
    methods: {
        editChart() {
            this.$emit('edit-chart', this.row);
            this.isOpen = false;
        },
        archiveChart() {
            this.$emit('archive-chart', this.row.id);
            this.isOpen = false;
        },
        toggleDropdown() { this.isOpen = !this.isOpen; },
        handleClickOutside(event) {
            if (this.$refs.dropdown && !this.$refs.dropdown.contains(event.target)) {
                this.isOpen = false;
            }
        },
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
            createdDateTime: '',
            records: [],
            pagination: {
                current_page: 1,
                per_page: 10,
                total: 0,
                from: 1,
                to: 0,
                last_page: 1,
            },
            statusFilter: 'active',
            statusList: [
                { label: 'Active', value: 'active' },
                { label: 'Archived', value: 'inactive' },
            ],
            createdDate: '',
            createdTime: '',
            isEditing: false,
            editId: null,
            accountName: '',
            classification: '',
            code: '', // Added missing field
            tax_mapping: '', // Added missing field
            showCategoryForm: false,
            showSubCategoryForm: false,
            errors: {},
            newCategory: { category: '', account_code: '' },
            newSubCategory: { sub_category: '', account_code: '' },
            form: {
                category_id: '',
                subcategory_id: '',
                subcategories: [],
                categories: @json($categories ?? []) // Ensure this is defined
            },
            allSubCategories: @json($subcategories ?? [])
        }
    },
    mounted() {
        this.fetchRecords();
        this.setInitialTime();
    },
    methods: {
        setStatus(status) {
            this.statusFilter = status;
            this.fetchRecords(1);
        },
        setInitialTime() {
            const now = new Date();
            const manila = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
            const year = manila.getFullYear();
            const month = String(manila.getMonth() + 1).padStart(2, '0');
            const day = String(manila.getDate()).padStart(2, '0');
            const hours = String(manila.getHours()).padStart(2, '0');
            const minutes = String(manila.getMinutes()).padStart(2, '0');
            this.createdDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        },
        toggleCategoryForm() {
            this.showCategoryForm = !this.showCategoryForm;
            this.clearCategoryErrors();
        },
        toggleSubCategoryForm() {
            this.showSubCategoryForm = !this.showSubCategoryForm;
            this.clearSubCategoryErrors();
        },
        clearCategoryErrors() {
            this.errors = {};
            this.newCategory.category = '';
            this.newCategory.account_code = '';
        },
        clearSubCategoryErrors() {
            this.errors = {};
            this.newSubCategory.sub_category = '';
            this.newSubCategory.account_code = '';
        },
        async saveCategory() {
            try {
                const res = await fetch("{{ route('accounting-categories.category.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.newCategory)
                });
                const data = await res.json();
                if (!res.ok) throw data;

                const option = { id: data.id, name: data.category };
                this.form.categories.push(option);
                this.form.category_id = data.id;
                this.toggleCategoryForm();
                Swal.fire('Success', 'Category created', 'success');
            } catch (err) {
                this.errors = err.errors || { general: 'Something went wrong' };
            }
        },
        async saveChart() {
            let payload = {
                code: this.code,
                name: this.accountName.trim(),
                accounting_category_id: this.form.category_id,
                accounting_subcategory_id: this.form.subcategory_id,
                classification: this.classification,
                tax_mapping: this.tax_mapping
            };

            try {
                let res;
                if (this.isEditing) {
                    res = await axios.put(`/chart-of-accounts/${this.editId}`, payload);
                } else {
                    res = await axios.post('/chart-of-accounts', payload);
                }

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: this.isEditing ? "Updated successfully!" : "Added successfully!",
                    timer: 1500,
                    showConfirmButton: false
                });

                this.fetchRecords();
                bootstrap.Modal.getInstance(document.getElementById('chartsModal')).hide();
            } catch (err) {
                Swal.fire("Error", err.response?.data?.message || "Something went wrong.", "error");
            }
        },
        async archiveChart(chartId) {
            try {
                const res = await axios.put(`/chart-of-accounts/${chartId}/archive`);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Archived!',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // Refresh the table
                this.fetchRecords(this.pagination.current_page);
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.response?.data?.message || 'Something went wrong'
                });
            }
        },
        async restoreChart(chartId) {
            try {
                const res = await axios.put(`/chart-of-accounts/${chartId}/restore`);
                Swal.fire({
                    icon: 'success',
                    title: 'Restored!',
                    text: res.data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                this.fetchRecords(this.pagination.current_page);
            } catch (err) {
                Swal.fire("Error", err.response?.data?.message || "Something went wrong.", "error");
            }
        },

        async deleteChart(chartId) {
            const confirm = await Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: "This will permanently delete the allowance!",
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            });

            if (!confirm.isConfirmed) return;

            try {
                await axios.delete(`/chart-of-accounts/${chartId}`);
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: "Allowance has been deleted.",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.fetchRecords(this.pagination.current_page);
            } catch (err) {
                Swal.fire("Error", err.response?.data?.message || "Something went wrong.", "error");
            }
        },
        fetchRecords(page = 1) {
            axios.get("{{ route('chart-of-accounts.fetch') }}", {
                params: {
                    status: this.statusFilter,
                    search: this.search,
                    page: page,
                    per_page: this.pagination.per_page,
                }
            })
            .then(response => {
                const charts = response.data.charts;

        // ✅ Records
            this.records = charts.data || [];

            // ✅ Pagination (THIS IS IMPORTANT)
            this.pagination.current_page = charts.current_page;
            this.pagination.per_page = charts.per_page;
            this.pagination.total = charts.total;
            this.pagination.from = charts.from;
            this.pagination.to = charts.to;
            this.pagination.last_page = charts.last_page;
            })
            .catch(error => console.error("❌ Error:", error));
        },
        openAddModal() {
            this.isEditing = false;
            this.editId = null;
            this.accountName = '';
            this.code = '';
            this.form.category_id = '';
            this.form.subcategory_id = '';
            this.errors = {};
            const modal = new bootstrap.Modal(document.getElementById('chartsModal'));
            modal.show();
        },
        openEditModal(row) {
            this.isEditing = true;
            this.editId = row.id;

            this.accountName = row.name;
            this.code = row.code;
            this.classification = row.classification;
            this.tax_mapping = row.tax_mapping;

            this.errors = {};

            this.form.category_id = row.accounting_category_id;

            this.$nextTick(() => {
                this.form.subcategory_id = row.accounting_subcategory_id ?? '';
            });

            const modal = new bootstrap.Modal(document.getElementById('chartsModal'));
            modal.show();
        },
    },
    watch: {
        'form.category_id'(newVal) {
            this.form.subcategories = this.allSubCategories.filter(
                sub => sub.accounting_category_id == newVal
            );
            this.form.subcategory_id = '';
        }
    },
    computed: {
        filteredRecords() {
                return this.records.filter(r => r.status === this.statusFilter);
            },
    },
});
</script>
@endsection