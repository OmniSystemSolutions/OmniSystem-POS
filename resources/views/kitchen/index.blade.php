@extends('layouts.app')
<script src="https://unpkg.com/timeago.js/dist/timeago.min.js"></script>

<style>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px 12px;
    vertical-align: middle !important;
}

thead {
    background-color: #e9ecf3;
    font-weight: bold;
}

tr {
    transition: background-color 0.3s ease;
}

tr:hover {
    background-color: #dcecff !important;
}

.btn {
    font-size: 0.85rem;
    padding: 4px 8px;
}

.fw-semibold {
    font-weight: 600;
}

.sortable {
  cursor: pointer;
  user-select: none;
}
.sortable:hover {
  background-color: #f8f9fa;
}

/* Wrapper keeps button + list together */
.recipe-wrapper {
  display: flex;
  flex-direction: column;
}

/* Recipe list styling */
.recipe-list {
  margin: 0;
  padding: 10px 14px;
  list-style-type: disc;
  background-color: #ffe5e5;
  border-radius: 6px;
  font-size: 0.9rem;
}

/* Optional spacing tweaks */
.recipe-list li {
  margin-bottom: 4px;
}

.recipe-name {
  font-weight: 600;
}

.recipe-qty {
  color: #555;
}

/* 🔥 Transition */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.25s ease;
}

.slide-fade-enter,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}



</style>
@section('content')
<div class="main-content" id="app">
  <div>
      <div class="breadcrumb">
          <h1 class="mr-3">POS</h1>
          <ul>
          <li><a href=""> Kitchen </a></li>
          <!----> <!---->
          </ul>
          <div class="breadcrumb-action"></div>
      </div>
      <div class="separator-breadcrumb border-top"></div>
  </div>
   <!-- ✅ Update Status Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" v-if="selectedOrder">

        <!-- Header -->
        <div class="modal-header">
          <h5 class="modal-title">@{{ modalMode === 'push' ? 'Push Item' : 'Update Status' }}
  - Order #@{{ selectedOrder.order_no }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <form @submit.prevent="submitUpdateStatus">
            
            <!-- Order Info -->
            <div class="border rounded p-3 mb-3">
              <div class="row g-2">
                <div class="col-md-3">
                  <label class="form-label">Order No</label>
                  <template v-if="modalMode === 'push'">
                  <!-- Push Mode -->
                  <v-select
                    
                    :options="availableOrders"
                    label="order_no"
                    :reduce="o => o.id"
                    v-model="selectedOrder.new_order_id"
                    placeholder="Select Order"
                    :clearable="false"
                  />
                  </template>
                  <template v-else>
                  <!-- Update Mode -->
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedOrder.order_no"
                    readonly
                  >
                  </template>
                </div>

                <div class="col-md-3">
                  <label class="form-label">Time Ordered</label>
                  <input type="text" class="form-control" :value="formatTime(selectedOrder.time_submitted)" readonly>
                </div>
                <div class="col-md-3">
                  <label class="form-label">SKU</label>
                  <input type="text" class="form-control" v-model="selectedOrder.code" readonly>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Product Name</label>
                  <input type="text" class="form-control" v-model="selectedOrder.name" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label class="form-label">Chef / Cook</label>

                <v-select
                  :options="chefs"
                  label="name"
                  :reduce="chef => chef.id"
                  v-model="selectedOrder.cook_id"
                  placeholder="-- Select Cook --"
                  :clearable="true"
                />
              </div>


              <div class="col-md-4">
  <label class="form-label">Status</label>

  <!-- Push Mode -->
  <input
    v-if="modalMode === 'push'"
    type="text"
    class="form-control"
    value="Served"
    readonly
  >

  <!-- Update Mode -->
  <v-select
    v-else
    :options="[
      { label: 'Served', value: 'served' },
      { label: 'Walked', value: 'walked' },
      { label: 'Cancelled', value: 'cancelled' }
    ]"
    label="label"
    :reduce="s => s.value"
    v-model="selectedOrder.status"
    placeholder="Select Status"
    :clearable="false"
  />
</div>


              <div class="col-md-4">
                <label class="form-label">Station</label>
                <input type="text" class="form-control" v-model="selectedOrder.station" readonly>
              </div>

              </div>

              <div v-if="selectedOrder && modalMode !== 'push'" class="mt-3">
              <h5>Ingredients for @{{ selectedOrder.name }}</h5>

              <div class="mb-2">
                <input type="checkbox" v-model="selectedOrder.showLoss"> Wasted Ingredients
              </div>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Component</th>
                    <th>Quantity</th>
                    <th v-if="selectedOrder.showLoss" colspan="3" class="text-center">Inventory Loss</th>
                  </tr>
                  <tr v-if="selectedOrder.showLoss">
                    <th></th>
                    <th></th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>Unit</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(ingredient, index) in selectedOrder.recipe" :key="index">
                    <td>@{{ ingredient.component_name }}</td>
                    <td class="text-end">@{{ ingredient.quantity }}</td>

                    <template v-if="selectedOrder.showLoss">
                      <td>
                        <select v-model="ingredient.loss_type" class="form-control">
                          <option disabled value="" style="color: #aaa;">Select Type</option>
                          <option value="wastage">Wastage</option>
                          <option value="spoilage">Spoilage</option>
                          <option value="theft">Theft</option>
                        </select>
                      </td>
                      <td>
                        <input type="number" v-model.number="ingredient.loss_qty" step="0.01" class="form-control text-end">
                      </td>
                      <td>@{{ ingredient.unit }}</td>
                    </template>
                  </tr>
                </tbody>
              </table>
            </div>

              
            {{-- </div> --}}
            <br>
            <!-- Buttons -->
            <div class="text-center">
              <button type="submit" class="btn btn-primary px-4 me-2">
                <i class="bi bi-check-circle me-1"></i> Submit
              </button>
              <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                Cancel
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <div class="row">
                    <div class="col-sm-12 col-md-3">
                      <fieldset class="form-group">
                          <legend class="col-form-label pt-0">Year</legend>
                          <v-select
                          v-model="selectedYear"
                          :options="years"
                          :clearable="false"
                          label="label"
                          ></v-select>
                      </fieldset>
                    </div>

                    <div class="col-sm-12 col-md-3">
                      <fieldset class="form-group">
                          <legend class="col-form-label pt-0">Month</legend>
                          <v-select
                          v-model="selectedMonth"
                          :options="monthOptions"
                          label="label"
                          :reduce="m => m.value"
                          :clearable="false"
                          ></v-select>
                      </fieldset>
                    </div>

                    <div class="col-sm-12 col-md-3">
                      <fieldset class="form-group">
                        <legend class="col-form-label pt-0">Day</legend>
                        <v-select
                          v-model="selectedDay"
                          :options="daysInMonth"
                          :clearable="false"
                        ></v-select>
                      </fieldset>
                    </div>

                    <div class="col-md-3 mt-3 mt-md-4">
                      <button class="btn btn-primary w-100" @click="resetToToday">Today’s Orders</button>
                    </div>
                  </div>

    <div class="wrapper">
        <div class="card mt-4">
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
                <div class="vgt-wrap ">
                  

                <div class="vgt-inner-wrap">
                    <div class="vgt-fixed-header">
                        <!---->
                    </div>
                    <div class="vgt-responsive"style="max-height: 400px; overflow-y: auto;">
                        <table id="vgt-table" class="table-hover tableOne vgt-table custom-vgt-table ">
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
                            </colgroup>
                            <thead style="min-width: auto; width: auto;">
                            <tr>
                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('order_no')">
                                <span>Order No.</span>
                                <i :class="getSortIcon('order_no')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('time_submitted')">
                                <span>Time Ordered</span>
                                <i :class="getSortIcon('time_submitted')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('code')">
                                <span>SKU</span>
                                <i :class="getSortIcon('code')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('name')">
                                <span>Product Name</span>
                                <i :class="getSortIcon('name')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('qty')">
                                <span>Qty</span>
                                <i :class="getSortIcon('qty')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('category')">
                                <span>Category</span>
                                <i :class="getSortIcon('category')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable" @click="sortTable('station')">
                                <span>Station</span>
                                <i :class="getSortIcon('station')" class="ms-1"></i>
                              </th>

                              <th scope="col" class="vgt-left-align text-left sortable"  @click="sortTable('time_submitted')">
                                <span>@{{ dynamicHeaderLabel }}</span>
                                <i :class="getSortIcon('time_submitted')" class="ms-1"></i>
                              </th>

                              <th
                                v-if="statusFilter !== 'serving'"
                                scope="col"
                                class="vgt-left-align text-left sortable"
                                @click="sortTable('cook_name')"
                              >
                                <span>Chef, Cook</span>
                                <i :class="getSortIcon('cook_name')" class="ms-1"></i>
                              </th>

                              {{-- <th scope="col" class="vgt-left-align text-right sortable" @click="sortTable('running_time')">
                                <span>Running Time</span>
                                <i :class="getSortIcon('running_time')" class="ms-1"></i>
                              </th> --}}

                              <th scope="col" class="vgt-left-align text-left sortable" v-if="statusFilter == 'serving'">
                                <span>Recipe</span>
                              </th>

                              <th 
                                v-if="statusFilter === 'serving' || statusFilter === 'walked'" 
                                scope="col" 
                                class="vgt-left-align text-left">
                                <span>Action</span>
                              </th>
                            </tr>

                            </thead>
                            <tbody>
                              <tr
  v-for="(item, index) in filteredOrders"
  :key="index"
  :style="statusFilter === 'serving'
    ? { backgroundColor: getOrderColor(item.time_submitted) }
    : {}"
>
                                <td class="text-left fw-bold text-primary">#@{{ item.order_no }}</td>
                                <td class="text-left">@{{ formatAMPM(item.created_at) }}</td>
                                <td class="text-left fw-semibold">@{{ item.code }}</td>
                                <td class="text-left">@{{ item.name }}</td>
                                <td class="text-end">@{{ item.qty }}</td>
                                <td class="text-end">@{{ item.category }}/@{{ item.subcategory }}</td>
                                <td class="text-end">@{{ item.station }}</td>
                                <td class="text-end fw-bold"
    :class="statusFilter === 'serving' 
    ?{ 'text-danger': (new Date(now) - new Date(item.time_submitted)) / 60000 >= 15 }
    : {}">

  @{{ item.status === 'serving'
      ? getRunningTime(item.time_submitted)
      : formatAMPM(item.time_submitted)
  }}

</td>

<td v-if="statusFilter == 'serving'">
  <div class="recipe-wrapper">
    <button
      class="btn btn-primary w-100 mb-2"
      @click="expandedOrderId = expandedOrderId === item.order_detail_id ? null : item.order_detail_id"
    >
      @{{ expandedOrderId === item.order_detail_id ? 'Hide Recipe' : 'View Recipe' }}
    </button>

    <transition name="slide-fade">
      <ul
        v-show="expandedOrderId === item.order_detail_id"
        class="recipe-list"
      >
        <li
          v-for="r in item.recipe"
          :key="r.component_id || r.component_name"
        >
          <span class="recipe-name">@{{ r.component_name }}</span>
          <span class="recipe-qty">— @{{ r.quantity }}</span>
        </li>
      </ul>
    </transition>
  </div>
</td>

<td v-else>
  @{{ item.cook_name || 'N/A' }}
</td>



                                <td class="text-left" v-if="statusFilter === 'serving' || statusFilter === 'walked'">
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
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                                       <!-- Update Status (only serving) -->
                                        <li v-if="statusFilter === 'serving'" role="presentation">
                                          <a
                                            class="dropdown-item"
                                            href="#"
                                            @click="openUpdateModal(item)"
                                          >
                                            <i class="nav-icon i-Edit font-weight-bold mr-2"></i>
                                            Update Status
                                          </a>
                                        </li>

                                        <!-- Remarks (only serving) -->
                                        <li v-if="statusFilter === 'serving'" role="presentation">
                                          <a class="dropdown-item" href="#">
                                            <i class="nav-icon i-Mail-Attachement font-weight-bold mr-2"></i>
                                            Remarks
                                          </a>
                                        </li>

                                        <!-- Push Item (only walked) -->
                                        <li v-if="statusFilter === 'walked'" role="presentation">
                                          <a
                                            class="dropdown-item"
                                            href="#"
                                            @click="pushItem(item)"
                                          >
                                            <i class="nav-icon i-Upload font-weight-bold mr-2"></i>
                                            Push Item
                                          </a>
                                        </li>
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                              <tr v-if="filteredOrders.length === 0">
                                  <td colspan="9" class="text-center text-muted">No data available.</td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  Vue.component('v-select', VueSelect.VueSelect);
new Vue({
  el: "#app",
  data: {
    now: new Date(), // reactive timestamp that updates every second
    selectedOrder: null,
    modalMode: null,
    orderItems: [],
    expandedOrderId: null,
    chefs: [],
    availableOrders: [],
    headerLabelMap: {
        pending: 'Running Time',
        served: 'Time Served',
        walked: 'Time Served',
        cancelled: 'Time Cancelled',
    },
    rowFieldMap: {
        pending: 'time_submitted',
        served: 'time_submitted',
        walked: 'time_submitted',
        cancelled: 'time_submitted',
    },
    statusFilter: 'serving',
    statusList: [
        { label: 'Preparing', value: 'serving' },
        { label: 'Served', value: 'served' },
        { label: 'Walked', value: 'walked' },
        { label: 'Cancelled', value: 'cancelled' },
    ],

    // 🔹 Date filter state
    selectedYear: new Date().getFullYear(),
    selectedMonth: new Date().getMonth() + 1,
    selectedDay: new Date().getDate(),
    months: [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ],
    sortKey: '',
    sortAsc: true,
  },

  computed: {
    dynamicHeaderLabel() {
                return this.headerLabelMap[this.statusFilter] || 'Running Time';
            },
            dynamicRowField() {
                return this.rowFieldMap[this.statusFilter] || '-';
            },
    // Generate list of last 5 years
    years() {
      const current = new Date().getFullYear();
      return Array.from({ length: 5 }, (_, i) => current - i);
    },
  monthOptions() {
    return this.months.map((m, i) => ({
      label: m,
      value: i + 1
    }));
  },

    // Generate days for selected month/year
    daysInMonth() {
      return Array.from(
        { length: new Date(this.selectedYear, this.selectedMonth, 0).getDate() },
        (_, i) => i + 1
      );
    },

    // 🔹 Filtered + Sorted orders based on selected date
filteredOrders() {
  // Step 1: Filter by selected date
  console.log(
  'RAW WALKED FROM API:',
  this.orderItems.filter(i => i.status === 'walked')
);
console.log('RAW:', this.orderItems);
  let data = this.orderItems.filter(item => {
    console.log('padung', item)
    const date = new Date(item.time_submitted);
    return (
      date.getFullYear() === this.selectedYear &&
      date.getMonth() + 1 === this.selectedMonth &&
      date.getDate() === this.selectedDay
    );
     console.log('return', date)
  });
  console.log('sunod', data)

  // Step 2: Sort if a column is selected
  if (this.sortKey) {
  data = [...data].sort((a, b) => {
    let valA = a[this.sortKey];
    let valB = b[this.sortKey];

    // 🕐 Special: sort running time based on difference from now
    if (this.sortKey === 'running_time') {
      const diffA = new Date(this.now) - new Date(a.time_submitted);
      const diffB = new Date(this.now) - new Date(b.time_submitted);
      return this.sortAsc ? diffA - diffB : diffB - diffA;
    }

    // 🕐 Special: sort by actual submission time
    if (this.sortKey === 'time_submitted') {
      return this.sortAsc
        ? new Date(valA) - new Date(valB)
        : new Date(valB) - new Date(valA);
    }

    // Numeric comparison (qty, etc.)
    if (!isNaN(valA) && !isNaN(valB)) {
      return this.sortAsc ? valA - valB : valB - valA;
    }

    // Default string comparison
    return this.sortAsc
      ? String(valA).localeCompare(String(valB))
      : String(valB).localeCompare(String(valA));
  });
}


  return data;
}

  },

  watch: {
    'selectedOrder.new_order_id'(val) {
    console.log('New Order Selected:', val);
  },
  statusFilter() {
    this.fetchItems()
  },
  selectedYear() {
    this.fetchItems()
  },
  selectedMonth() {
    this.fetchItems()
  },
  selectedDay() {
    this.fetchItems()
  }
},

  mounted() {
    // 🕒 Update timer every second
    setInterval(() => {
      this.now = new Date();
    }, 1000);
    this.fetchItems()
  },

  methods: {
    isServedOrWalked(item) {
    return ['served', 'walked'].includes(item.status);
  },
  formatAMPM(time) {
    if (!time) return 'N/A'
    return new Date(time).toLocaleTimeString('en-US', {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: true
    })
  },
    fetchItems() {
  const currentExpandedId = this.expandedOrderId; // remember which recipe was expanded

  axios.get('/kitchen/fetch', {
    params: {
      status: this.statusFilter,
      year: this.selectedYear,
      month: this.selectedMonth,
      day: this.selectedDay
    }
  }).then(res => {
    this.orderItems = res.data.orderItems;
    this.availableOrders = res.data.availableOrders;
    this.chefs = res.data.chefs;
    console.log('availableOrders:', this.availableOrders);
    // Restore expanded recipe if it still exists
    if (currentExpandedId && this.orderItems.some(i => i.order_detail_id === currentExpandedId)) {
      this.expandedOrderId = currentExpandedId;
    } else {
      this.expandedOrderId = null;
    }

    console.log('data today:', this.orderItems);
  }).catch(err => console.error('Failed to fetch items:', err));
},
setStatus(status) {
               this.statusFilter = status;
   
                // ✅ Remember last opened tab
              //  localStorage.setItem('inventory_transfer_last_tab', status);
              //  this.fetchRecords(1);
           },
    // Reset dropdowns to today's date
    resetToToday() {
  const now = new Date()
  this.selectedYear = now.getFullYear()
  this.selectedMonth = now.getMonth() + 1
  this.selectedDay = now.getDate()
  this.fetchItems()
},

    // 🕐 Compute live running time in H:M:S format
    getRunningTime(submitted) {
      const diffInSeconds = Math.floor((new Date(this.now) - new Date(submitted)) / 1000);
      if (diffInSeconds < 0) return "0s"; // safeguard

      const hours = Math.floor(diffInSeconds / 3600);
      const mins = Math.floor((diffInSeconds % 3600) / 60);
      const secs = diffInSeconds % 60;

      let timeStr = "";
      if (hours > 0) timeStr += `${hours}h `;
      if (mins > 0 || hours > 0) timeStr += `${mins}m `;
      timeStr += `${secs}s`;
      return timeStr.trim();
    },

    // 🟩🟧🟥 Compute background color based on elapsed time
    getOrderColor(submitted) {
      const diffInMinutes = (new Date(this.now) - new Date(submitted)) / 1000 / 60;

      if (diffInMinutes >= 15) return '#ffcccc'; // red
      if (diffInMinutes >= 10) return '#ffe5b4'; // orange
      if (diffInMinutes >= 5)  return '#e8f5e9'; // green
      return '#ffffff'; // default white
    },

    formatTime(datetime) {
      const local = new Date(datetime + 'Z');
      return local.toLocaleTimeString('en-PH', {
        timeZone: 'Asia/Manila',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
      });
    },

    openUpdateModal(item, mode = 'update') {
  this.modalMode = mode;

  // Deep copy
  this.selectedOrder = JSON.parse(JSON.stringify(item || {}));

  // Defaults
  this.selectedOrder.showLoss = false;
  this.selectedOrder.recipe = this.selectedOrder.recipe || [];

  // 🔥 If Push Mode
  if (this.modalMode === 'push') {
    this.selectedOrder.status = 'served';
    this.selectedOrder.order_no = null; // force select
  } else {
    this.selectedOrder.status = null; // allow placeholder
  }

  this.$nextTick(() => {
    const modalEl = document.getElementById('updateModal');

    let modal = bootstrap.Modal.getInstance(modalEl);

    if (!modal) {
      modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
      });
    }

    modal.show();
  });
},
pushItem(item) {
  this.openUpdateModal(item, 'push');
},


resetUpdateModal() {
  this.selectedOrder = null;
  this.modalMode = null;
},

    sortTable(key) {
    if (this.sortKey === key) {
      this.sortAsc = !this.sortAsc; // toggle ascending/descending
    } else {
      this.sortKey = key;
      this.sortAsc = true; // default ascending
    }
  },
  getSortIcon(key) {
    if (this.sortKey !== key) return 'fa fa-sort text-muted';
    return this.sortAsc ? 'fa fa-sort-up text-primary' : 'fa fa-sort-down text-primary';
  },

    // fetchOrders() {
    //   axios.get(`/kitchen/served`)
    //     .then(res => {
    //       this.orderItems = res.data.orderItems;
    //     })
    //     .catch(err => console.error("❌ Failed to reload orders:", err));
    // },

    async submitUpdate() {
  // 🔒 Show loader immediately
  Swal.fire({
    title: 'Updating order...',
    html: 'Please wait',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  try {
    const now = new Date();
    const timeSubmitted =
      now.getFullYear() + '-' +
      String(now.getMonth() + 1).padStart(2, '0') + '-' +
      String(now.getDate()).padStart(2, '0') + ' ' +
      now.toLocaleTimeString('en-US', { hour12: false });

    // ✅ Prepare deductions
    const deductions = [];
    if (['served', 'walked'].includes(this.selectedOrder.status)) {
      const recipes = this.selectedOrder.recipe || [];

      recipes.forEach(ingredient => {
        const usedQty = ingredient.quantity || 0;
        const lossQty = ingredient.loss_qty || 0;

        if (usedQty > 0) {
          deductions.push({
            component_id: ingredient.component_id,
            order_detail_id: this.selectedOrder.order_detail_id,
            quantity_deducted: usedQty,
            deduction_type: 'served',
            notes: `Used for order (${this.selectedOrder.status}).`,
          });
        }

        if (lossQty > 0) {
          const mappedType = ['wastage', 'spoilage', 'theft'].includes(
            (ingredient.loss_type || '').toLowerCase()
          )
            ? ingredient.loss_type.toLowerCase()
            : 'wastage';

          deductions.push({
            component_id: ingredient.component_id,
            order_detail_id: this.selectedOrder.order_detail_id,
            quantity_deducted: lossQty,
            deduction_type: mappedType,
            notes: `Wasted due to ${mappedType}.`,
          });
        }
      });
    }

    const payload = {
      order_detail_id: this.selectedOrder.order_detail_id,
      cook_id: this.selectedOrder.cook_id,
      time_submitted: timeSubmitted,
      status: this.selectedOrder.status,
      recipe: (this.selectedOrder.recipe || []).map(r => ({
        component_name: r.component_name,
        quantity: r.quantity ?? 0,
        loss_type: r.loss_type && r.loss_type !== '' ? r.loss_type : 'served',
        loss_qty: r.loss_qty ?? 0,
      })),
      deductions,
    };

    // 🚀 API call
    const response = await axios.post(`/order-items/update-or-create`, payload);

    if (!response.data.success) {
      Swal.fire('Warning', response.data.message || 'Something went wrong.', 'warning');
      return;
    }

    // ✅ Success
Swal.fire({
  icon: 'success',
  title: 'Updated!',
  text: 'Order item updated successfully',
  timer: 1800,
  showConfirmButton: false
});

const updatedDetail = response.data.data.order_detail;
const updatedOrderStatus = updatedDetail?.status;

// 🔄 Update local list
const index = this.orderItems.findIndex(
  item => item.order_detail_id === updatedDetail.id
);

if (index !== -1) {
  this.orderItems[index].status = updatedDetail.status;
  this.orderItems[index].cook_id = this.selectedOrder.cook_id;
  this.orderItems[index].time_submitted = timeSubmitted;
}

// 🔁 REFRESH / REMOVE
if (['served', 'walked'].includes(updatedOrderStatus)) {
  this.fetchItems();
}

if (updatedDetail.status !== 'serving') {
  this.orderItems = this.orderItems.filter(
    i => i.order_detail_id !== updatedDetail.id
  );
}

/* ✅ ADD THIS BLOCK HERE */
if (this.selectedOrder?.recipe) {
  this.selectedOrder.recipe.forEach(r => {
    r.loss_type = '';
    r.loss_qty = 0;
  });
}

/* THEN CLOSE MODAL */
const modal = bootstrap.Modal.getInstance(
  document.getElementById("updateModal")
);
if (modal) modal.hide();

  } catch (error) {
    console.error("❌ Update failed:", error.response || error);

    let message = 'Failed to update order item.';
    if (error.response?.data?.message) {
      message = error.response.data.message;
    }

    Swal.fire('Error', message, 'error');
  }

  },
  submitPush() {
  const modal = bootstrap.Modal.getInstance(document.getElementById("updateModal"));

  if (!this.selectedOrder.order_id) {
    // SweetAlert for validation
    Swal.fire({
      icon: 'warning',
      title: 'Oops!',
      text: 'Please select an Order No',
    });
    return;
  }

  axios.post('/kitchen/push-item', {
    order_detail_id: this.selectedOrder.order_detail_id,
    new_order_id: this.selectedOrder.new_order_id,
    status: 'served'
  })
  .then(res => {
    console.log('Push success');

    modal.hide();
    this.fetchItems(); // refresh list

    // SweetAlert success
    Swal.fire({
      icon: 'success',
      title: 'Order Pushed!',
      text: 'The order has been successfully updated.',
      timer: 1500,
      showConfirmButton: false
    });
  })
  .catch(err => {
    console.error(err);

    // SweetAlert error
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Something went wrong while pushing the order.'
    });
  });
},

  submitUpdateStatus() {
  if (this.modalMode === 'push') {
    this.submitPush();
  } else {
    this.submitUpdate();
  }
}
}
});
</script>

@endsection