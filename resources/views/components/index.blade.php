@extends('layouts.app')
@section('content')

<div class="main-content" id="app">
   <div>
      <div class="breadcrumb">
         <h1 class="mr-3">Products and Components</h1>
         <div class="breadcrumb-action"></div>
      </div>
      <div class="separator-breadcrumb border-top"></div>
   </div>
   <!----> 
   <div class="wrapper">
      <div class="row">
         <div class="col-md-4">
            <label class="col-form-label pt-0">Select Type</label>
            <v-select
               :options="types"
               label="label"
               :reduce="type => type.value"
               v-model="selectedType"
               @input="goToPage"
               placeholder="Select type"
               />
         </div>
      </div>
      <div class="card mt-4">
         <!----><!---->
         <div class="card-body">
            <nav class="card-header">
               <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                     <a href="#" 
                           class="nav-link"
                           :class="{ active: statusFilter === 'active' }"
                           @click.prevent="setStatus('active')">
                           Active
                     </a>
                  </li>

                  <li class="nav-item">
                     <a href="#"
                           class="nav-link"
                           :class="{ active: statusFilter === 'archived' }"
                           @click.prevent="setStatus('archived')">
                           Archived
                     </a>
                  </li>
               </ul>
         </nav>
            <div class="card-body">
               <!----><!---->
               <div class="vgt-wrap ">
                  <!----> 
                  <div class="vgt-inner-wrap">
                     <!----> 
                     <div class="vgt-global-search vgt-clearfix">
                        <div class="vgt-global-search__input vgt-pull-left">
                           <span aria-hidden="true" class="input__icon">
                              <div class="magnifying-glass"></div>
                           </span>
                           <form role="search" method="GET" action="{{ route('components.index') }}" class="mb-3" style="position: relative;">
                              <label for="tableSearch" style="cursor: pointer;" onclick="this.closest('form').submit()">
                              <span class="sr-only">Search</span>
                              </label>
                              <input 
                                 id="tableSearch" 
                                 name="search" 
                                 type="text" 
                                 value="{{ request('search') }}" 
                                 placeholder="Search this table" 
                                 class="vgt-input vgt-pull-left"
                                 onkeydown="if(event.key === 'Enter') this.form.submit()"
                                 >
                           </form>
                        </div>
                        <div class="vgt-global-search__actions vgt-pull-right">
                           <div ref="dropdownWrapper">
                              <div id="dropdown-form"
                                 class="dropdown b-dropdown mx-1 btn-group"
                                 :class="{ show: showColumnDropdown }">
                                 <!-- Gear button -->
                                 <button
                                    type="button"
                                    class="btn dropdown-toggle btn-light dropdown-toggle-no-caret"
                                    @click="toggleDropdown"
                                    aria-haspopup="menu">
                                 <i class="i-Gear"></i>
                                 </button>
                                 <!-- Dropdown -->
                                 <ul
                                    class="dropdown-menu dropdown-menu-right"
                                    v-show="showColumnDropdown"
                                    role="menu"
                                    style="display: block;">
                                    <li role="presentation">
                                       <header class="dropdown-header">
                                          Columns
                                       </header>
                                    </li>
                                    <li role="presentation" style="width: 220px;">
                                       <form class="b-dropdown-form p-0">
                                          <section>
                                             <div class="px-4" style="max-height: 400px; overflow:auto;">
                                                <ul class="list-unstyled">
                                                   <li v-for="col in columns" :key="col.field">
                                                      <div class="my-1 custom-control custom-checkbox">
                                                         <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            :id="`col-${col.field}`"
                                                            :checked="!col.hidden"
                                                            @change="toggleColumn(col.field)"
                                                            >
                                                         <label
                                                            class="custom-control-label"
                                                            :for="`col-${col.field}`">
                                                         @{{ col.label }}
                                                         </label>
                                                      </div>
                                                   </li>
                                                </ul>
                                             </div>
                                          </section>
                                       </form>
                                    </li>
                                 </ul>
                              </div>
                              <button
                                 type="button"
                                 class="btn mx-1 btn-outline-info btn-sm"
                                 @click="showFilterSidebar = true"
                                 >
                              <i class="i-Filter-2"></i> Filter
                              </button>
                              <button
                                 class="btn btn-sm btn-outline-danger ripple mx-1"
                                 @click="exportExcel"
                                 >
                                 <i class="i-File-Excel"></i> Export
                              </button>
                              {{-- Add button: hide if archived --}}
                              @if ($status !== 'archived')
                              <button type="button" class="btn mx-1 btn-btn btn-primary btn-icon"
                                 onclick="window.location='{{ url('components/create') }}'">
                              <i class="i-Add"></i> Add
                              </button>
                              @endif
                              <button type="button" class="btn mx-1 btn-btn btn-primary">
                              Stock Alert Summary
                              </button>
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
            <div class="vgt-responsive" style="max-height: 400px; overflow-y: auto;">
               <table class="table-hover tableOne vgt-table custom-vgt-table">
                  <!-- COLGROUP (must match visible columns) -->
                  <colgroup>
                     <col v-for="(col, i) in visibleColumns" :key="i">
                  </colgroup>
                  <thead>
                     <tr>
                        <th
                           v-for="col in visibleColumns"
                           :key="col.field"
                           class="vgt-left-align text-left sortable"
                           :data-column="col.field"
                           >
                           <span>@{{ col.label }}</span>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr v-for="row in filteredRows" :key="row.id">
                        <td v-for="col in visibleColumns"
                           :key="col.field"
                           :data-column="col.field">
                           <template v-if="col.field === 'component_sku'">
                              @{{ row.code }}
                           </template>
                           <template v-if="col.field === 'component_name'">
                              @{{ row.name }}
                           </template>
                           <template v-else-if="col.field === 'category_name'">
                              @{{ row.category?.name || 'N/A' }}
                           </template>
                           <template v-else-if="col.field === 'subcategory_name'">
                              @{{ row.subcategory?.name || 'N/A' }}
                           </template>
                           <template v-else-if="col.field === 'component_cost'">
                              @{{ Number(row.cost).toFixed(2) }}
                           </template>
                           <template v-else-if="col.field === 'component_price'">
                              @{{ Number(row.price).toFixed(2) }}
                           </template>
                           <template v-else-if="col.field === 'component_unit'">
                              @{{ row.unit }}
                           </template>
                           <template v-else-if="col.field === 'onhand'">
                              @{{ row.onhand }}
                           </template>
                           <template v-else-if="col.field === 'for_sale'">
                              <input type="checkbox" :checked="row.for_sale">
                           </template>
                           <template v-else-if="col.field === 'action'">
                              <!-- keep blade partial if needed -->
                              <actions-dropdown 
                                 :row="row" 
                                 @edit-route="editRoute"
                                 @delete-route="deleteRoute"
                                 @archive-route="archiveRoute"
                                 @restore-route="restoreRoute"
                                 @stock-card-route="stockCardRoute"
                                 @logs-route="logsRoute"
                                 @remarks-route="remarksRoute"
                                 @open-remarks-modal="openRemarksModal"
                                 >
                              </actions-dropdown>
                           </template>
                        </td>
                     </tr>
                     <tr v-if="!rows.length">
                        <td :colspan="visibleColumns.length" class="vgt-center-align vgt-text-disabled">
                           No data for table
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Remarks Modal -->
   <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <header class="modal-header">
               <h5 class="modal-title" id="remarksModalLabel">Remarks</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </header>
            <div class="modal-body">
               <form id="remarksForm">
                  @csrf
                  <input type="hidden" id="remarksItemId" value="{{ $component->id ?? '' }}">
                  <fieldset class="form-group">
                     <textarea 
                        name="remarks" placeholder="Type your message" rows="3" wrap="soft" class="form-control" cols="30" aria-describedby="Message-feedback" label="Message" id="remarksText">
            </textarea>
                     <div class="invalid-feedback">This field is required</div>
                  </fieldset>
                  <div class="d-flex justify-content-end">
                     <button type="submit" class="btn btn-primary btn-icon btn-rounded">
                     <i class="i-Yes me-2 font-weight-bold"></i> Submit
                     </button>
                  </div>
               </form>
               <hr>
               <div class="modal-body">
                  <!-- Form -->
                  <form id="remarksForm">
                  @csrf
                  <input type="hidden" id="remarksItemId" value="{{ $component->id ?? '' }}">
                  <div class="mb-3">
                     <div class="d-flex align-items-center">
                        <i class="i-User me-2"></i>
                        <span class="text-primary fw-bold">
                        {{ Auth::check() ? Auth::user()->name : 'Guest User' }}
                        </span>
                     </div>
                  </div>
                  <ul class="timeline" id="remarksTimeline"></ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!----> 
   <div class="vgt-wrap__footer vgt-clearfix mt-3">
      <!-- Rows per page -->
      <div class="footer__row-count vgt-pull-left">
         <label class="footer__row-count__label">
         Rows per page:
         </label>
         <select v-model="perPage" @change="fetchComponents(1)">
            <option v-for="size in [10,20,30,40,50]" :key="size" :value="size">
               @{{ size }}
            </option>
         </select>
      </div>
      <!-- Pagination -->
      <div class="footer__navigation vgt-pull-right">
         <!-- Page info -->
         <div class="footer__navigation__page-info me-3">
            <div>
               @{{ pageFrom }} - @{{ pageTo }} of @{{ pagination.total }}
            </div>
         </div>
         <!-- Prev -->
         <button
            class="footer__navigation__page-btn"
            :class="{ disabled: pagination.current_page === 1 }"
            @click="fetchComponents(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            >
         <span class="chevron left"></span>
         <span>prev</span>
         </button>
         <!-- Next -->
         <button
            class="footer__navigation__page-btn"
            :class="{ disabled: pagination.current_page === pagination.last_page }"
            @click="fetchComponents(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            >
         <span>next</span>
         <span class="chevron right"></span>
         </button>
      </div>
   </div>
   <div tabindex="-1" class="b-sidebar-outer">
      <!-- Sidebar -->
      <div
         id="sidebar-right"
         tabindex="-1"
         class="b-sidebar shadow b-sidebar-right bg-white text-dark sidebar-open"
         v-show="showFilterSidebar"
         >
         <!-- Header -->
         <header class="b-sidebar-header">
            <button
               type="button"
               aria-label="Close"
               class="close text-dark"
               @click="showFilterSidebar = false"
               >
            ✕
            </button>
            <strong id="sidebar-right___title__">Filter</strong>
         </header>
         <!-- Body -->
         <div class="b-sidebar-body">
            <div class="px-3 py-2">
               <div class="row">
                  <!-- Component Name -->
                  <div class="col-md-12">
                     <fieldset class="form-group">
                        <legend class="col-form-label pt-0">
                           Component Name
                        </legend>
                        <input
                           type="text"
                           class="form-control"
                           placeholder="Search by component name"
                           v-model="filters.name"
                           >
                     </fieldset>
                  </div>
                  <!-- Category -->
                  <div class="col-md-12">
                     <fieldset class="form-group">
                        <legend class="col-form-label pt-0">
                           Category
                        </legend>

                        <v-select
                           :options="categories"
                           label="name"
                           :reduce="c => c.id"
                           v-model="filters.category"
                           placeholder="Select category"
                           clearable
                        />
                     </fieldset>
                  </div>
                  <!-- Subcategory -->
                  <div class="col-md-12">
                     <fieldset class="form-group">
                        <legend class="col-form-label pt-0">
                           Subcategory
                        </legend>
                        <v-select
                           :options="filteredSubcategories"
                           label="name"
                           :reduce="s => s.id"
                           v-model="filters.subcategory"
                           placeholder="Select subcategory"
                           :disabled="!filters.category"
                           clearable
                        />
                     </fieldset>
                  </div>
                  <!-- Cost Range -->
                  <div class="col-md-12">
                     <fieldset class="form-group">
                        <legend class="col-form-label pt-0">
                           Cost Range
                        </legend>
                        <div class="d-flex gap-2">
                           <input
                              type="number"
                              class="form-control"
                              placeholder="From"
                              v-model.number="filters.cost_from"
                              >
                           <input
                              type="number"
                              class="form-control"
                              placeholder="To"
                              v-model.number="filters.cost_to"
                              >
                        </div>
                     </fieldset>
                  </div>
                  <!-- Price Range -->
                  <div class="col-md-12">
                     <fieldset class="form-group">
                        <legend class="col-form-label pt-0">
                           Price Range
                        </legend>
                        <div class="d-flex gap-2">
                           <input
                              type="number"
                              class="form-control"
                              placeholder="From"
                              v-model.number="filters.price_from"
                              >
                           <input
                              type="number"
                              class="form-control"
                              placeholder="To"
                              v-model.number="filters.price_to"
                              >
                        </div>
                     </fieldset>
                  </div>
                  <!-- For Sale -->
                  <div class="col-md-12">
                     <fieldset class="form-group">
                        <legend class="col-form-label pt-0">
                           For Sale
                        </legend>
                        <select class="form-control" v-model="filters.for_sale">
                           <option :value="null">All</option>
                           <option :value="true">For Sale</option>
                           <option :value="false">Not For Sale</option>
                        </select>
                     </fieldset>
                  </div>
                  <!-- Buttons -->
                  <div class="col-sm-12 col-md-6">
                     <button
                        type="button"
                        class="btn btn-primary btn-sm btn-block"
                        @click="applyFilter"
                        >
                     <i class="i-Filter-2"></i>
                     Filter
                     </button>
                  </div>
                  <div class="col-sm-12 col-md-6">
                     <button
                        type="button"
                        class="btn btn-danger btn-sm btn-block"
                        @click="resetFilter"
                        >
                     <i class="i-Power-2"></i>
                     Reset
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <span data-v-03022ced="">
      <!---->
   </span>
</div>
@endsection

@section('scripts')
<script type="text/x-template" id="actions-dropdown-template">
<div class="dropdown btn-group" ref="dropdown">
    <!-- 3 Dots Button -->
    <button type="button" 
            class="btn dropdown-toggle btn-link btn-lg text-decoration-none dropdown-toggle-no-caret"
            @click.stop="toggleDropdown"
            :aria-expanded="isOpen.toString()">
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
        <span class="_dot _r_block-dot bg-dark"></span>
            <!-- 🔴 Remarks Badge (BESIDE the dots) -->
    <span
        :id="`remarksBadge-${row.id}`"
        class="badge bg-danger text-white remarks-badge d-none position-absolute "
        style="font-size: 0.55rem; transform: translate(40%, -40%) !important;"
    >
        1
    </span>
    </button>



    <!-- Dropdown menu -->
    <ul :class="['dropdown-menu dropdown-menu-right', { show: isOpen }]">

        <!-- Edit -->
           <li v-if="row.status == 'active'">
               <a class="dropdown-item" :href="`/components/${row.id}/edit`">
                   <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                   Edit
               </a>
           </li>

           <li v-if="row.status == 'active'">
               <a class="dropdown-item" @click="archive(row.id)">
                   <i class="nav-icon i-Letter-Close font-weight-bold mr-2"></i>
                   Archive
               </a>
           </li>

           <li v-if="row.status == 'archived'">
               <a class="dropdown-item" @click="restore(row.id)">
                   <i class="nav-icon i-Refresh font-weight-bold mr-2"></i>
                   Restore
               </a>
           </li>

           <li v-if="row.status == 'active'">
               <a class="dropdown-item" :href="`/components/${row.id}/stock-card`">
                   <i class="nav-icon i-Receipt font-weight-bold mr-2"></i>
                   View Stock Card
               </a>
           </li>

             <li v-if="row.status == 'active'">
                <a class="dropdown-item" :href="`/components/${row.id}/logs`">
                      <i class="nav-icon i-Computer-Secure font-weight-bold mr-2"></i>
                      Logs
                </a>
             </li>

               <li v-if="row.status == 'active'">
                  <button class="dropdown-item" @click="$emit('open-remarks-modal', row.id)">
                        <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                        Remarks
                        
                  </button>
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
        return {
            isOpen: false
        };
    },
    methods: {
      archive(componentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to move this unit to archive!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, archive it!',
            }).then((result) => {
               if (result.isConfirmed) {
                     axios.put(`/components/${componentId}/archive`)
                        .then(res => {
                           Swal.fire('Archived!', res.data.message, 'success')
                                 .then(() => {
                                    // Reload after user clicks Okay
                                    window.location.reload();
                                 });
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Failed!', 'Could not archive component.', 'error');
                        });
                }
            });
        },
        restore(componentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to restore this component!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, restore it!',
            }).then((result) => {
               if (result.isConfirmed) {
                     axios.put(`/components/${componentId}/restore`)
                        .then(res => {
                           Swal.fire('Restored!', res.data.message, 'success')
                                 .then(() => {
                                    // Reload after user clicks Okay
                                    window.location.reload();
                                 });
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Failed!', 'Could not restore component.', 'error');
                        });
                }
            });
        },
        toggleDropdown() { this.isOpen = !this.isOpen; },
        handleClickOutside(event) {
            if (!this.$refs.dropdown?.contains(event.target)) this.isOpen = false;
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
  document.addEventListener("DOMContentLoaded", function() {
    const table = document.querySelector("#vgt-table");
    if (!table) return;
    const headers = table.querySelectorAll("thead th");
    headers.forEach((header, index) => {
      // Make header visually clickable
      header.style.cursor = "pointer";
      header.addEventListener("click", function() {
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const isAsc = header.classList.toggle("asc");
        // Remove sorting classes from other headers
        headers.forEach((h, i) => {
          if (i !== index) h.classList.remove("asc", "desc");
        });
        header.classList.toggle("desc", !isAsc);
        rows.sort((a, b) => {
          const aText = a.children[index].textContent.trim();
          const bText = b.children[index].textContent.trim();
          const aNum = parseFloat(aText.replace(/,/g, ""));
          const bNum = parseFloat(bText.replace(/,/g, ""));
          const bothNumbers = !isNaN(aNum) && !isNaN(bNum);
          if (bothNumbers) {
            return isAsc ? aNum - bNum : bNum - aNum;
          } else {
            return isAsc ?
              aText.localeCompare(bText) :
              bText.localeCompare(aText);
          }
        });
        // Reattach sorted rows
        rows.forEach(row => tbody.appendChild(row));
      });
    });
  });
</script>

<script>
  function openRemarksModal(componentId) {
    // Set the hidden input
    document.getElementById('remarksItemId').value = componentId;

    // Clear previous remarks
    document.getElementById('remarksText').value = '';

    // Fetch existing remarks via /remarks?component_id=ID
    fetch(`/remarks?component_id=${componentId}`)
      .then(res => res.json())
      .then(data => {
        const timeline = document.getElementById('remarksTimeline');
        timeline.innerHTML = '';

        const filteredRemarks = data.filter(remark => remark.component_id == componentId);

        if (filteredRemarks.length === 0) {
          timeline.innerHTML = '<li>No remarks yet for this component.</li>';
        } else {
          filteredRemarks.forEach(remark => {
            const li = document.createElement('li');
            li.classList.add('mb-3', 'p-2', 'border-start', 'border-3', 'border-primary');

            // Format timestamp
            const date = new Date(remark.created_at);
            const formattedDate = date.toLocaleString('en-US', {
              month: '2-digit',
              day: '2-digit',
              year: 'numeric',
              hour: '2-digit',
              minute: '2-digit',
              second: '2-digit',
              hour12: true
            });

            // HTML layout
            li.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-primary">
                            </span>
                            <small class="text-muted">${formattedDate}</small>
                        </div>
                        <p class="mb-2">${remark.remarks}</p>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-1"
                              onclick="markAsRead(${remark.id}, ${componentId})">Mark as Read</button>
                           <button class="btn btn-sm btn-primary"
                              onclick="markAsUnread(${remark.id}, ${componentId})">Mark as Unread</button>
                        </div>
                    `;

            timeline.appendChild(li);
          });
        }
      })
      .catch(err => console.error(err));

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('remarksModal'));
    modal.show();
  }

  function showRemarksBadge(componentId) {
    const badge = document.getElementById(`remarksBadge-${componentId}`);
    if (badge) badge.classList.remove('d-none');
  }

  function hideRemarksBadge(componentId) {
    const badge = document.getElementById(`remarksBadge-${componentId}`);
    if (badge) badge.classList.add('d-none');
  }

  function markAsRead(remarkId, componentId) {
    fetch(`/component-remarks/${remarkId}/mark-read`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(res => res.json())
      .then(() => {
        hideRemarksBadge(componentId);
        alert('✅ Marked as Read');
      })
      .catch(err => console.error('Error marking as read:', err));
  }

  function markAsUnread(remarkId, componentId) {
    fetch(`/component-remarks/${remarkId}/mark-unread`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(res => res.json())
      .then(() => {
        showRemarksBadge(componentId);
        alert('🔔 Marked as Unread');
      })
      .catch(err => console.error('Error marking as unread:', err));
  }

  // Handle form submission
  document.addEventListener('DOMContentLoaded', function() {
    const remarksForm = document.getElementById('remarksForm');
    const remarksText = document.getElementById('remarksText');
    const timeline = document.getElementById('remarksTimeline');

    // Create success alert element
    const alertBox = document.createElement('div');
    alertBox.className = 'alert alert-success mt-2 d-none';
    alertBox.textContent = '✅ Remark added successfully!';
    remarksForm.appendChild(alertBox);

    remarksForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const remarks = remarksText.value.trim();
      const componentId = document.getElementById('remarksItemId').value;

      if (!remarks || !componentId) {
        alert('Please enter a remark.');
        return;
      }

      fetch(`/component-remarks/store`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            component_id: componentId,
            remarks: remarks
          })
        })
        .then(res => res.json())
        .then(data => {
          // Show success message
          alertBox.classList.remove('d-none');

          // Clear input field
          remarksText.value = '';

          // Refresh remarks list
          fetch(`/remarks?component_id=${componentId}`)
            .then(res => res.json())
            .then(updatedData => {
              timeline.innerHTML = '';
              const filteredRemarks = updatedData.filter(r => r.component_id == componentId);

              if (filteredRemarks.length === 0) {
                timeline.innerHTML = '<li>No remarks yet for this component.</li>';
              } else {
                filteredRemarks.forEach(r => {
                  const li = document.createElement('li');
                  li.textContent = `${r.remarks}`;
                  timeline.appendChild(li);
                });
              }

              // Show badge for component
              showRemarksBadge(componentId);

              // Hide alert after 2s
              setTimeout(() => alertBox.classList.add('d-none'), 2000);
            });
        })
        .catch(err => {
          console.error('Error:', err);
          alert('❌ Failed to add remark');
        });
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    fetch('/component-remarks')
      .then(res => res.json())
      .then(data => {
        // Filter only unread remarks
        const unreadRemarks = data.filter(r => r.status === 'unread');

        // Get unique component IDs with unread remarks
        const componentIdsWithUnread = [...new Set(
          unreadRemarks.map(r => r.component_id)
        )];

        // Loop through badges and show only those with unread remarks
        componentIdsWithUnread.forEach(componentId => {
          const badge = document.getElementById(`remarksBadge-${componentId}`);
          if (badge) {
            badge.classList.remove('d-none'); // show static badge
          }
        });
      })
      .catch(err => console.error('Error fetching remarks:', err));
  });
</script>

<script>
  window.currentPage = "{{ request()->is('components*') ? 'components' : 'products' }}";
</script>

<script src="{{ asset('js/tableFunctions.js') }}"></script>
    <script>
      Vue.component('v-select', VueSelect.VueSelect);
      new Vue({
    el: '#app',
    data() {
        return {
         selectedType: 'components',
         statusFilter: 'active',
         types: [
         { label: 'Products', value: 'products', url: '/products' },
         { label: 'Components', value: 'components', url: '/components' },
         { label: 'Bundled Items', value: 'bundled_items', url: '/bundled-items' },
         ],
         showColumnDropdown: false,
         showFilterSidebar: false,
         filters: {
            sku: '',
            name: '',
            category: null,
            subcategory: null,
            cost_from: null,
            cost_to: null,
            price_from: null,
            price_to: null,
            for_sale: null,
         },
         columns: [
            { label: 'SKU', field: 'component_sku', hidden: false },
            { label: 'Component Name', field: 'component_name', hidden: false },
            { label: 'Category Name', field: 'category_name', hidden: false },
            { label: 'SubCategory Name', field: 'subcategory_name', hidden: false },
            { label: 'Component Cost', field: 'component_cost', hidden: false },
            { label: 'Component Price', field: 'component_price', hidden: false },
            { label: 'Component Unit', field: 'component_unit', hidden: false },
            { label: 'Onhand', field: 'onhand', hidden: false },
            { label: 'For Sale', field: 'for_sale', hidden: false },
            { label: 'Action', field: 'action', hidden: false },
         ],
          rows: [],
          search: '',
          perPage: 10,
          status: 'active',
          loading: false,
          categories: [],
          subcategories: [],

          pagination: {
            current_page: 1,
            per_page: 10,
            total: 0,
            last_page: 1,
         }
  }
},
  computed: {
  visibleColumns() {
    return this.columns.filter(col => !col.hidden);
  },
  pageFrom() {
    if (!this.pagination.total) return 0;
    return (this.pagination.current_page - 1) * this.pagination.per_page + 1;
  },
  pageTo() {
    return Math.min(
      this.pageFrom + this.rows.length - 1,
      this.pagination.total
    );
  },
  filteredRows() {
    return this.rows.filter(row => {
      if (this.filters.name &&
        !row.name?.toLowerCase().includes(this.filters.name.toLowerCase())
      ) return false;

      // Category filter
      if (
        this.filters.category &&
        (!row.category || row.category.id !== this.filters.category)
      ) {
        return false;
      }

      // Subcategory filter
      if (
        this.filters.subcategory &&
        (!row.subcategory || row.subcategory.id !== this.filters.subcategory)
      ) {
        return false;
      }

      if (this.filters.cost_from !== null &&
        Number(row.cost) < this.filters.cost_from
      ) return false;

      if (this.filters.cost_to !== null &&
        Number(row.cost) > this.filters.cost_to
      ) return false;

      if (this.filters.price_from !== null &&
        Number(row.price) < this.filters.price_from
      ) return false;

      if (this.filters.price_to !== null &&
        Number(row.price) > this.filters.price_to
      ) return false;

      if (this.filters.for_sale !== null &&
        row.for_sale !== this.filters.for_sale
      ) return false;

      return true;
    });
  },
   filteredSubcategories() {
      if (!this.filters.category) return [];

      return this.subcategories.filter(
         s => Number(s.category_id) === Number(this.filters.category)
      );
   },
},

  methods: {
   setStatus(status) {
         console.log("Status filter changed to:", status);
            this.statusFilter = status;
            this.fetchComponents();
        },
   getCellValue(row, field) {
    switch (field) {
      case 'component_sku':
        return row.code;

      case 'component_name':
        return row.name;

      case 'category_name':
        return row.category?.name || 'N/A';

      case 'subcategory_name':
        return row.subcategory?.name || 'N/A';

      case 'component_cost':
        return Number(row.cost || 0);

      case 'component_price':
        return Number(row.price || 0);

      case 'component_unit':
        return row.unit || '';

      case 'onhand':
        return row.onhand || 0;

      case 'for_sale':
        return row.for_sale ? 'Yes' : 'No';

      default:
        return '';
    }
   },
     exportExcel() {
    if (!this.filteredRows.length) {
      alert('No data to export');
      return;
    }

    // only visible columns (gear dropdown)
    const visibleCols = this.columns.filter(col => !col.hidden && col.field !== 'action');

    const data = this.filteredRows.map(row => {
      const obj = {};

      visibleCols.forEach(col => {
        obj[col.label] = this.getCellValue(row, col.field);
      });

      return obj;
    });

    const worksheet = XLSX.utils.json_to_sheet(data);
    const workbook  = XLSX.utils.book_new();

    XLSX.utils.book_append_sheet(workbook, worksheet, 'Components');

    const filename = `components_${new Date().toISOString().slice(0, 10)}.xlsx`;

    XLSX.writeFile(workbook, filename);
  },
   goToPage(value) {
      const selected = this.types.find(t => t.value === value)
      if (selected) {
        window.location.href = selected.url
      }
    },
   openSidebar() {
      this.showFilterSidebar = true;
      console.log("Button clicked! showFilterSidebar =", this.showFilterSidebar);
    },
    closeSidebar() {
      this.showFilterSidebar = false;
      console.log("Closed sidebar:", this.showFilterSidebar);
    },
   fetchComponents(page = 1) {
   this.loading = true;

   axios.get('/components/fetch', {
      params: {
         search: this.search,
         perPage: this.perPage,
         status: this.statusFilter,
         page: page,

         // 🔹 filters
         category: this.filters.category,
         subcategory: this.filters.subcategory,
      }
   })
   .then(res => {
      // table rows
      this.rows = res.data.data;

      // pagination
      this.pagination.current_page = res.data.current_page;
      this.pagination.per_page    = res.data.per_page;
      this.pagination.total       = res.data.total;
      this.pagination.last_page   = res.data.last_page;

      // 🔹 build dropdown lists
      this.buildCategoryLists();
   })
   .finally(() => {
      this.loading = false;
   });
   },
   buildCategoryLists() {
  const categoryMap = {};
  const subcategoryMap = {};

  this.rows.forEach(c => {
    if (c.category) {
      categoryMap[c.category.id] = c.category;
    }

    if (c.subcategory) {
      subcategoryMap[c.subcategory.id] = {
        ...c.subcategory,
        category_id: c.category?.id,
      };
    }
  });

  this.categories = Object.values(categoryMap);
  this.subcategories = Object.values(subcategoryMap);
},



  toggleDropdown() {
    this.showColumnDropdown = !this.showColumnDropdown;
  },

  handleClickOutside(event) {
    const dropdown = this.$refs.dropdownWrapper;
    if (dropdown && !dropdown.contains(event.target)) {
      this.showColumnDropdown = false;
    }
  },

//   handleOutside(e) {
//     const sidebar = document.getElementById('sidebar-right');
//     if (
//       this.showFilterSidebar &&
//       sidebar &&
//       !sidebar.contains(e.target) &&
//       !e.target.closest('.i-Filter-2')
//     ) {
//       this.showFilterSidebar = false;
//     }
//   },

  resetFilter() {
    this.filters = {
      name: '',
      category: '',
      subcategory: '',
      cost_from: null,
      cost_to: null,
      price_from: null,
      price_to: null,
      for_sale: null,
    };
  },

  toggleColumn(field) {
    const col = this.columns.find(c => c.field === field);
    if (col) col.hidden = !col.hidden;
  },

  isColumnVisible(field) {
    const col = this.columns.find(c => c.field === field);
    return col && !col.hidden;
  },

  applyFilter() {
  this.fetchComponents(1);
  this.showFilterSidebar = false;
}
},
    mounted() {
    this.fetchComponents();
     document.addEventListener('click', this.handleClickOutside);
     document.addEventListener('click', this.handleOutside)
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  },
  watch: {
  'filters.category'() {
    this.filters.subcategory = null;
  },
},
      });
    </script>
@endsection