@extends('layouts.app')
@section('content')
<style>
     .dropdown-menu {
        position: relative;
    }
</style>
<div class="main-content" id="app">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Inventory</h1>
            <ul>
            <li><a href=""> Audit </a></li>
            <!----> <!---->
            </ul>
            <div class="breadcrumb-action"></div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <fieldset class="form-group">
                    <legend class="col-form-label pt-0">Select Year *</legend>
                    <v-select
                    v-model="selectedYear"
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
                    v-model="selectedMonth"
                    :options="monthOptions"
                    :clearable="false"
                    placeholder="Select month"
                    label="label"
                />
                </fieldset>
            </div>
            <div class="col-sm-12 col-md-3">
                <fieldset class="form-group">
                    <legend class="col-form-label pt-0">Select Type of Audit</legend>
                    <v-select
                    v-model="selectedType"
                    :options="auditTypeOptions"
                    :clearable="true"
                    placeholder="Select type"
                    label="label"
                    ></v-select>
                </fieldset>
            </div>
        </div>
        <div class="card mt-4">
            <nav class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link"
                            :class="{ active: statusFilter === 'active' }"
                            @click.prevent="setStatusFilter('active')">
                            Active
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" 
                            class="nav-link"
                            :class="{ active: statusFilter === 'completed' }"
                            @click.prevent="setStatusFilter('completed')">
                            Completed
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#"
                            class="nav-link"
                            :class="{ active: statusFilter === 'archived' }"
                            @click.prevent="setStatusFilter('archived')">
                            Archived
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
                                    <label for="vgt-search-426127929825">
                                        <span aria-hidden="true" class="input__icon">
                                        <div class="magnifying-glass"></div>
                                        </span>
                                        <span class="sr-only">Search</span>
                                    </label>
                                    <input id="vgt-search-426127929825" type="text" placeholder="Search this table" class="vgt-input vgt-pull-left">
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
                                        <li role="presentation">
                                            <form tabindex="-1" class="b-dropdown-form">
                                                <ul class="list-unstyled">
                                                    <li>
                                                    <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__220"><label class="custom-control-label" for="__BVID__220">Date and Time of Entry</label></div>
                                                    </li>
                                                    <li>
                                                    <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__221"><label class="custom-control-label" for="__BVID__221">Date and Time of Actual Audit</label></div>
                                                    </li>
                                                    <li>
                                                    <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__222"><label class="custom-control-label" for="__BVID__222">Audited by</label></div>
                                                    </li>
                                                    <li>
                                                    <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__223"><label class="custom-control-label" for="__BVID__223">Reference #</label></div>
                                                    </li>
                                                    <li>
                                                    <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__224"><label class="custom-control-label" for="__BVID__224">Warehouse</label></div>
                                                    </li>
                                                    <li>
                                                    <div class="my-1 custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" value="true" id="__BVID__225"><label class="custom-control-label" for="__BVID__225">Action</label></div>
                                                    </li>
                                                    <li><button type="button" class="btn mt-2 mb-3 btn-primary btn-sm">Save</button></li>
                                                </ul>
                                            </form>
                                        </li>
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-outline-info ripple m-1 btn-sm collapsed" aria-expanded="false" aria-controls="sidebar-right" style="overflow-anchor: none;"><i class="i-Filter-2"></i>
                                    Filter
                                    </button> <button type="button" class="btn btn-outline-success ripple m-1 btn-sm"><i class="i-File-Copy"></i> PDF
                                    </button> <button class="btn btn-sm btn-outline-danger ripple m-1"><i class="i-File-Excel"></i> EXCEL
                                    </button> <a href="/inventory/audits/create" class="btn btn-primary btn-rounded btn-icon m-1"><i class="i-Add"></i>
                                    Add
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="vgt-fixed-header">
                            <!---->
                        </div>
                        <div class="vgt-responsive">
                            <table id="vgt-table" class="table-hover tableOne vgt-table">
                                <thead>
                                <tr>
                                    <th class="vgt-checkbox-col"><input type="checkbox" /></th>
                                    <th class="vgt-left-align text-left sortable">Date and Time of Entry</th>
                                    <th class="vgt-left-align text-left sortable">Date and Time of Actual Audit</th>
                                    <th class="vgt-left-align text-left sortable">Audited by</th>
                                    <th class="vgt-left-align text-left sortable">Reference #</th>
                                    <th class="vgt-left-align text-left sortable">Warehouse</th>
                                    <th class="vgt-left-align text-right">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <!-- When there are records -->
                                <tr v-for="(audit, index) in audits" :key="index">
                                    <th class="vgt-checkbox-col"><input type="checkbox" /></th>
                                    <td class="vgt-left-align text-left">@{{ audit.entry_datetime }}</td>
                                    <td class="vgt-left-align text-left">@{{ audit.audit_datetime }}</td>
                          <td class="vgt-left-align text-left">
    @{{ audit.auditor ? audit.auditor.name : '-' }}
</td>
                                    <td class="vgt-left-align text-left">@{{ audit.reference_no }}</td>
                                    <td class="vgt-left-align text-left">@{{ audit.warehouse }}</td>
                                    <td class="vgt-left-align text-right">
                                        <actions-dropdown
                                        :audit-id="audit.id"
                                        :reference-no="audit.reference_no"
                                        :status="audit.status"
                                        @apply-adjustment="applyAdjustment"
                                        @archive-audit="archiveAudit"
                                        @restore-audit="restoreAudit"
                                        @delete-permanently="deletePermanent"
                                    ></actions-dropdown>
                                    </td>
                                </tr>

                                <!-- When no records -->
                                <tr v-if="audits.length === 0">
                                    <td colspan="7" class="text-center text-muted py-3">
                                    No records found as of the moment.
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Vue Dropdown Component -->
<script type="text/x-template" id="actions-dropdown-template">
<div class="dropdown btn-group" ref="dropdown">
    <!-- 3 Dots Button -->
    <button
        type="button"
        class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
        @click.stop="toggleDropdown"
        :aria-expanded="isOpen.toString()"
    >
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
    </button>

    <ul :class="['dropdown-menu dropdown-menu-right', { show: isOpen }]">
        <template v-if="status === 'archived'">
            <li>
                <a class="dropdown-item" :href="`/inventory/audits/${auditId}/edit`">
                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                    Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="#" @click.prevent="$emit('delete-permanently', auditId)">
                    <i class="nav-icon i-Remove-Basket font-weight-bold mr-2"></i>
                    Permanently Delete
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="$emit('restore-audit', auditId)">
                    <i class="nav-icon i-Restore-Window font-weight-bold mr-2"></i>
                    Restore as Active
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="dropdown-item" @click="$emit('open-remarks', auditId)">
                    <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                    Remarks
                </a>
            </li>
        </template>

        <template v-else-if="status === 'completed'">
            <li>
                <a class="dropdown-item" :href="`/inventory/audits/${auditId}/show`">
                    <i class="nav-icon i-Eye font-weight-bold mr-2"></i>
                    View Audit Report
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i>
                    Logs
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="dropdown-item" @click="$emit('open-remarks', auditId)">
                    <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                    Remarks
                </a>
            </li>
        </template>

        <template v-else>
            <li>
                <a class="dropdown-item" :href="`/inventory/audits/${auditId}/edit`">
                    <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                    Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="confirmApply">
                    <i class="nav-icon i-Folder-Download font-weight-bold mr-2"></i>
                    Apply Adjustment to Stock Card
                </a>
            </li>
            <li>
                <a class="dropdown-item" :href="`/inventory/audits/${auditId}/show`">
                    <i class="nav-icon i-Eye font-weight-bold mr-2"></i>
                    View Audit Report
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#" @click.prevent="confirmArchive">
                    <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                    Move to Archive
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="#">
                    <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i>
                    Logs
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="dropdown-item" @click="$emit('open-remarks', auditId)">
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
        auditId: Number,
        referenceNo: {
            type: [String, Number],
            default: ''
        },
        status: {
            type: String,
            default: 'active'
        }
    },
    data() {
        return {
            isOpen: false
        };
    },
    methods: {
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        confirmApply() {
            const ref = this.referenceNo || '';
            if (typeof Swal === 'undefined') {
                alert(`Are you sure you want to apply adjustments to Stock Card? Reference: ${ref}`);
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: '',
                html: `Are you sure you want to apply adjustments to Stock Card?<br><strong>Reference: ${ref}</strong>`,
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal2-custom-popup'
                },
                confirmButtonColor: '#ff630f',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // emit event for parent to handle actual apply action (parent will prompt for credentials)
                    this.$emit('apply-adjustment', this.auditId);
                }
            });
        },
        confirmArchive() {
            const ref = this.referenceNo || '';
            if (typeof Swal === 'undefined') {
                if (!confirm(`Move audit ${ref} to archive?`)) return;
                this.$emit('archive-audit', this.auditId);
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: '',
                html: `Are you sure you want to move this audit to archive?<br><strong>Reference: ${ref}</strong>`,
                showCancelButton: true,
                confirmButtonText: 'Yes, archive it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$emit('archive-audit', this.auditId);
                }
            });
        },
        handleClickOutside(event) {
            if (!this.$refs.dropdown.contains(event.target)) {
                this.isOpen = false;
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
</script>

<script>
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
    el: '#app',
    data() {
        return {
            selectedYear: null,
            yearOptions: @json($yearOptions), // Use dynamic years from PHP
             monthOptions: [
            { label: 'All Months', value: 'All Months' },
            { label: 'January', value: 'January' },
            { label: 'February', value: 'February' },
            { label: 'March', value: 'March' },
            { label: 'April', value: 'April' },
            { label: 'May', value: 'May' },
            { label: 'June', value: 'June' },
            { label: 'July', value: 'July' },
            { label: 'August', value: 'August' },
            { label: 'September', value: 'September' },
            { label: 'October', value: 'October' },
            { label: 'November', value: 'November' },
            { label: 'December', value: 'December' },
            ],
            selectedMonth: { label: 'All Months', value: 'All Months' },
            selectedType: 'Products',
            auditTypeOptions: [
                { label: 'Products', value: 'products' },
                { label: 'Components', value: 'components' },
                { label: 'Consumables/Engineering', value: 'consumables' },
                { label: 'Assets', value: 'assets' },
            ],
            audits: @json($audits),
            currentUserName: @json(optional(auth()->user())->name ?? ''),
            statusFilter: 'active',
        };
    },
    created() {
        // Default selected year = latest year in options
        if (this.yearOptions.length) {
            this.selectedYear = this.yearOptions[this.yearOptions.length - 1].value;
        }
    },
    watch: {
        selectedYear() {
            this.fetchAudits();
        },
        selectedMonth(newVal) {
            this.fetchAudits();
        },
        selectedType() {
            this.fetchAudits();
        },
    },
    methods: {
        fetchAudits() {
        axios.get('{{ route('inventory_audit.fetch') }}', {
            params: {
                year: this.selectedYear,
                month: this.selectedMonth.value, // pass only value, not object
                type: this.selectedType.value || this.selectedType,
                status: this.statusFilter,
            }
        }).then(res => {
            this.audits = res.data.audits || [];
        }).catch(err => {
            console.error(err);
            this.audits = [];
        });
        },
        setStatusFilter(status) {
            this.statusFilter = status;
            this.fetchAudits();
        },
        applyAdjustment(auditId) {
            const vm = this;
            const ref = '';
            if (typeof Swal === 'undefined') {
                // fallback prompt
                const username = this.currentUserName || prompt('Username');
                const password = prompt('Password');
                if (!username || !password) return alert('Credentials required');
                axios.post(`/inventory/audits/${auditId}/apply`, { username, password })
                    .then(res => { alert(res.data.message || 'Applied'); vm.fetchAudits(); })
                    .catch(err => { alert(err.response?.data?.message || 'Failed'); });
                return;
            }

            Swal.fire({
                title: 'Authenticate',
                html: `
                    <label>Username</label>
                    <input id="swal-username" class="swal2-input" value="${this.currentUserName}">
                    <label>Password</label>
                    <input id="swal-password" type="password" class="swal2-input" placeholder="Enter password">
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                focusConfirm: false,
                preConfirm: () => {
                    const username = document.getElementById('swal-username').value;
                    const password = document.getElementById('swal-password').value;
                    if (!username || !password) {
                        Swal.showValidationMessage('Both username and password are required');
                        return false;
                    }
                    return { username, password };
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const { username, password } = result.value;
                    Swal.showLoading();
                    axios.post(`/inventory/audits/${auditId}/apply`, { username, password })
                        .then(res => {
                            Swal.close();
                            Swal.fire({ icon: 'success', title: 'Applied', text: res.data.message || 'Adjustments applied.' });
                            vm.fetchAudits();
                        })
                        .catch(err => {
                            Swal.close();
                            const msg = err.response?.data?.message || 'Failed to apply adjustments.';
                            Swal.fire({ icon: 'error', title: 'Error', text: msg });
                        });
                }
            });
        },
        archiveAudit(auditId) {
            const vm = this;
            if (typeof Swal === 'undefined') {
                if (!confirm('Move this audit to archive?')) return;
                axios.put(`/inventory/audits/${auditId}/archive`).then(res => {
                    alert(res.data.message || 'Archived');
                    vm.fetchAudits();
                }).catch(err => {
                    alert(err.response?.data?.message || 'Failed to archive');
                });
                return;
            }

            Swal.fire({
                title: 'Move to Archive',
                text: 'Are you sure you want to move this audit to archive?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    axios.put(`/inventory/audits/${auditId}/archive`).then(res => {
                        Swal.close();
                        Swal.fire({ icon: 'success', title: 'Archived', text: res.data.message });
                        vm.fetchAudits();
                    }).catch(err => {
                        Swal.close();
                        Swal.fire({ icon: 'error', title: 'Error', text: err.response?.data?.message || 'Failed to archive' });
                    });
                }
            });
        },
        // Restore an archived audit back to active
        restoreAudit(auditId) {
            const vm = this;
            if (typeof Swal === 'undefined') {
                if (!confirm('Restore this audit to Audit Logs (active)?')) return;
                axios.put(`/inventory/audits/${auditId}/restore`).then(res => {
                    alert(res.data.message || 'Restored');
                    vm.fetchAudits();
                }).catch(err => {
                    alert(err.response?.data?.message || 'Failed to restore');
                });
                return;
            }

            Swal.fire({
                title: 'Restore Audit',
                text: 'Restore this audit to Audit Logs (active)?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Restore',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    axios.put(`/inventory/audits/${auditId}/restore`).then(res => {
                        Swal.close();
                        Swal.fire({ icon: 'success', title: 'Restored', text: res.data.message });
                        vm.fetchAudits();
                    }).catch(err => {
                        Swal.close();
                        Swal.fire({ icon: 'error', title: 'Error', text: err.response?.data?.message || 'Failed to restore' });
                    });
                }
            });
        },

        // Permanent delete of an audit
        deletePermanent(auditId) {
            const vm = this;
            if (typeof Swal === 'undefined') {
                if (!confirm('Permanently delete this audit? This cannot be undone.')) return;
                axios.delete(`/inventory/audits/${auditId}/destroy`).then(res => {
                    alert(res.data.message || 'Deleted');
                    vm.fetchAudits();
                }).catch(err => {
                    alert(err.response?.data?.message || 'Failed to delete');
                });
                return;
            }

            Swal.fire({
                title: 'Permanent Delete',
                text: 'This audit will be permanently deleted and cannot be restored.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    axios.delete(`/inventory/audits/${auditId}/destroy`).then(res => {
                        Swal.close();
                        Swal.fire({ icon: 'success', title: 'Deleted', text: res.data.message });
                        vm.fetchAudits();
                    }).catch(err => {
                        Swal.close();
                        Swal.fire({ icon: 'error', title: 'Error', text: err.response?.data?.message || 'Failed to delete' });
                    });
                }
            });
        },
    },
});
</script>

@endsection