@extends('layouts.app')
@section('content')
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
                            <input type="text" class="form-control" v-model="name" placeholder="Enter Name of Account">
                        </div>
                        <div class="col-md-12">
                            <label>Category</label>
                            <div class="d-flex">
                                <select class="custom-select mr-2"
                                    v-model="category">
                                    <option value="" disabled selected>Select Category</option>
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
                                <select class="custom-select mr-2" v-model="subcategory">
                                    <option value="" disabled selected>Select Subcategory</option>
                                    <option v-for="sub in subcategories" :key="sub.id" :value="sub.id">
                                    @{{ sub.sub_category }}
                                    </option>
                                </select>
                                <button type="button" class="btn btn-outline-success btn-sm" @click="toggleSubCategoryForm">
                                <i class="i-Add"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Inline New Subcategory Form -->
                        {{-- <div v-if="showSubCategoryForm" class="border rounded p-4 mt-3 bg-white shadow-sm" style="max-width:600px; margin:auto;">
                            <h4 class="text-center mb-4">Add Subcategory</h4>
                            <div class="form-group">
                                <label class="font-weight-bold">Subcategory Name</label>
                                <input type="text" class="form-control" v-model="newSubCategory.name" :class="{ 'is-invalid': errors.subcategory_name }">
                                <div class="invalid-feedback">@{{ errors.subcategory_name }}</div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control" rows="3" v-model="newSubCategory.description" :class="{ 'is-invalid': errors.subcategory_description }"></textarea>
                                <div class="invalid-feedback">@{{ errors.subcategory_description }}</div>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-success px-4 mr-2" @click="saveSubCategory">Save</button>
                                <button type="button" class="btn btn-danger px-4" @click="toggleSubCategoryForm">Cancel</button>
                            </div>
                        </div> --}}
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Classification</label>
                            <select class="custom-select mr-2"
                                    v-model="category">
                                    <option disabled value="">Select Classification</option>
                                    <option v-for="c in classifications" :key="c.id" :value="c.id">
                                    @{{ c.name }}
                                    </option>
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
                            <button type="button" class="btn btn-primary" @click="savechart">
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
                                        <td class="vgt-left-align text-left">@{{ row.category }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.subcategory }}</td>
                                        <td class="vgt-left-align text-left">@{{ row.normal_balance }}</td>
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
        <template v-if="row.status === 'archived'">
            <li>
                <a class="dropdown-item" @click.prevent="editChart">
                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                    Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="#" @click.prevent="$emit('delete-chart', row.id)">
                    <i class="nav-icon i-Remove-Basket font-weight-bold mr-2"></i>
                    Permanently Delete
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="$emit('restore-chart', row.id)">
                    <i class="nav-icon i-Restore-Window font-weight-bold mr-2"></i>
                    Restore as Active
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="dropdown-item" @click="$emit('open-remarks', chartId)">
                    <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                    Remarks
                </a>
            </li>
        </template>
        <template v-else>
            <li>
                <a class="dropdown-item" href="#"
                @click.prevent="editChart">
                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                    Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="archiveChart">
                    <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                    Move to Archive
                </a>
            </li>
            <li>
                <a class="dropdown-item" :href="`/chart-of-accounts/${chartId}/logs`">
                    <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i>
                    Logs
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="dropdown-item" @click="$emit('open-remarks', chartId)">
                    <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                    Remarks
                </a>
            </li>
        </template>
    </ul>
</div>
</script>
<script>
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
        editChart() {
            // Emit event to parent with the row
            this.$emit('edit-chart', this.row);
            this.isOpen = false; // close dropdown
        },
        archiveChart() {
            // Emit event to parent with the chart ID
            this.$emit('archive-chart', this.row.id);
            this.isOpen = false; // close dropdown
        },
        toggleDropdown() { this.isOpen = !this.isOpen; },
        handleClickOutside(event) {
            if (!this.$refs.dropdown?.contains(event.target)) this.isOpen = false;
        },
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener("click", this.handleClickOutside);
    }
});
</script>
<script>
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
                { label: 'Archived', value: 'archived' },
            ],
            createdDate: '',
            createdTime: '',
            isEditing: false,
            editId: null,
            accountName: '',
            showCategoryForm: false,
            showSubCategoryForm: false,
            category: '',
            subcategories: @json($subcategories),
            subcategory: '',
            selectedClassification: '',
            classifications: [
                { id: 1, name: 'Credit'},
                { id: 2, name: 'Debit'},
            ]
        }
    },
    mounted() {
        const now = new Date();

        const manila = new Date(
            now.toLocaleString('en-US', { timeZone: 'Asia/Manila' })
        );

        const year = manila.getFullYear();
        const month = String(manila.getMonth() + 1).padStart(2, '0');
        const day = String(manila.getDate()).padStart(2, '0');
        const hours = String(manila.getHours()).padStart(2, '0');
        const minutes = String(manila.getMinutes()).padStart(2, '0');

        this.createdDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        this.fetchRecords();
        },
        methods: {
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
            this.errors.sub_category = '';
            this.errors.sub_account_code = '';
            this.newSubCategory.sub_category = '';
            this.newSubCategory.account_code = '';
        },
        async saveCategory() {
            this.errors = {};
            if (!this.newCategory.category.trim()) {
                this.errors.category = 'Category Name is required.';
                return;
            }
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

                // Add to select
                const option = { id: data.id, category: data.category };
                this.$set(this.form, 'categories', [...(this.form.categories || []), option]);
                this.form.category_id = data.id;
                this.toggleCategoryForm();
                Swal.fire('Success', 'Category created', 'success');
            } catch (err) {
                this.errors = err.errors || { name: err.message || 'Something went wrong' };
            }
        },
        async saveSubCategory() {
            this.errors = {};
            if (!this.newSubCategory.sub_category.trim()) {
                this.errors.sub_category = 'Subcategory Name is required.';
                return;
            }
            if (!this.form.category_id) {
                Swal.fire('Error', 'Please select a parent category first.', 'error');
                return;
            }
            try {
                const res = await fetch("{{ route('accounting-categories.sub-category.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        sub_category: this.newSubCategory.sub_category,
                        account_code: this.newSubCategory.account_code,
                        category_id: this.form.category_id
                    })
                });
                const data = await res.json();
                if (!res.ok) throw data;

                // Add to subcategory list
                this.form.subcategories.push({ id: data.id, sub_category: data.sub_category });
                this.form.subcategory_id = data.id;
                this.toggleSubCategoryForm();
                Swal.fire({ icon: 'success', title: 'Subcategory created', timer: 1500, showConfirmButton: false });
            } catch (err) {
                this.errors.subcategory_name = err.errors?.name?.[0] || err.message || 'Something went wrong';
            }
        },
            openAddModal() {
                this.isEditing = false;
                this.editId = null;

                this.accountName = '';

                const now = new Date();
                const manila = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));

                this.createdDate = manila.toISOString().split('T')[0];
                this.createdTime = manila.toTimeString().slice(0, 5);

                const modalEl = document.getElementById('chartsModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            },

            openEditModal(row) {
                this.isEditing = true;
                this.editId = row.id;

                this.allowanceName = row.name;

                // Format existing created date & time
                const created = new Date(row.created_at);
                const manila = new Date(created.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));

                this.createdDate = manila.toISOString().split('T')[0];
                this.createdTime = manila.toTimeString().slice(0, 5);

                const modalEl = document.getElementById('chartsModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            },
            async archiveChart(chartId) {
                try {
                    const res = await axios.patch(`/chart-of-accounts/${chartId}/archive`);
                    
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
                    const res = await axios.patch(`/chart-of-accounts/${chartId}/restore`);
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

            async deleteChart(chartsId) {
                const confirm = await Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: "This will permanently delete the account chart!",
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
                        text: "Account Chart has been deleted.",
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
                        page: page,
                        per_page: this.pagination.per_page,
                    }
                })
                .then(response => {
                    const res = response.data;

                    // Main data
                    this.records = res.data || [];

                    console.log("✅ Fetched records:", this.records);

                    // Pagination (now inside res.pagination)
                    if (res.pagination) {
                        this.pagination.current_page = res.pagination.current_page;
                        this.pagination.per_page = res.pagination.per_page;
                        this.pagination.total = res.pagination.total;
                        this.pagination.from = res.pagination.from;
                        this.pagination.to = res.pagination.to;
                        this.pagination.last_page = res.pagination.last_page;
                    }

                    // Categories & Subcategories for dropdowns
                    if (res.categories) {
                        this.categoryOptions = res.categories;
                    }
                    if (res.subcategories) {
                        this.subcategoryOptions = res.subcategories;
                    }
                })
                .catch(error => {
                    console.error("❌ Error fetching records:", error);
                });
            },

            // Reformatted date/time to Asia/Manila
            formatDateTime(datetime) {
                if (!datetime) return '';

                return new Date(datetime).toLocaleString('en-US', {
                    timeZone: 'Asia/Manila',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            },

            setStatus(status) {
                this.statusFilter = status;
                this.fetchRecords(1);
            },
            async saveChart() {
                if (!this.allowanceName || this.allowanceName.trim() === "") {
                    return Swal.fire("Required", "Chart name is required.", "warning");
                }

                let payload = {
                    name: this.allowanceName.trim(),
                };

                try {
                    let res;

                    if (this.isEditing) {
                        // UPDATE
                        res = await axios.put(`/chart-of-accounts/${this.editId}`, payload);
                    } else {
                        // CREATE
                        res = await axios.post('/chart-of-accounts', payload);
                    }

                    Swal.fire({
                        icon: "success",
                        title: this.isEditing ? "Updated successfully!" : "Added successfully!",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    this.fetchRecords();
                    bootstrap.Modal.getInstance(document.getElementById('chartsModal')).hide();

                } catch (err) {
                    Swal.fire("Error", err.response?.data?.message || "Something went wrong.", "error");
                }
            }


        },
        computed: {
            filteredRecords() {
                return this.records.filter(r => r.status === this.statusFilter);
            },
        }
});
</script>
@endsection