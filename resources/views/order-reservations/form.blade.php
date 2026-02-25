@extends('layouts.app')
@section('content')
<div class="main-content">
<style>
  .container {
    display: flex;
    gap: 20px;
}
/* Hide scrollbars by default */
.categories::-webkit-scrollbar,
.products::-webkit-scrollbar {
  width: 0;
  transition: width 0.5s;
}
.categories:hover::-webkit-scrollbar,
.products:hover::-webkit-scrollbar {
  width: 6px;
}
.categories::-webkit-scrollbar-thumb,
.products::-webkit-scrollbar-thumb {
  background: #bbb;
  border-radius: 3px;
}
.categories::-webkit-scrollbar-track,
.products::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Categories sidebar */
.categories {
    display: flex;
    flex-direction: column;
    width: 150px;
    max-height: 700px;
    overflow-y: auto;
    padding: 10px;
    gap: 10px;
    scrollbar-width: thin;
    flex-shrink: 0;
}
.categories button {
    flex: 0 0 auto;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    background: #ff630f;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s, color 0.3s;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.categories button:hover,
.categories button.active {
    color: #fff;
}

/* Products grid */
.products {
  flex: 1;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-top: 20px;
  max-height: 700px;
  overflow-y: auto;
  padding: 10px;
  box-sizing: border-box;
}

/* Product card */
.product-card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  overflow: hidden;
  height: 220px;
}
.product-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.product-card img {
  width: 100%;
  height: 120px;
  object-fit: cover;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.product-body {
    padding: 15px;
    text-align: center;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.product-body h4 {
    margin: 10px 0 5px;
    font-size: 18px;
    font-weight: bold;
}
.product-body p {
    font-size: 14px;
    color: #555;
    flex-grow: 1;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
table, th, td {
    border: 1px solid #ddd;
}
th, td {
    padding: 8px;
    text-align: center;
}
.fade-enter-active, .fade-leave-active {
  transition: all 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
.form-control:disabled, .form-control[readonly] {
    font-size: 14px !important;
}
.waiter-select .vs__search::placeholder {
  font-size: 14px !important;
}
</style>

<div id="app">
  <h2>@{{ isEdit ? 'Edit Reservation' : 'Create Orders and Reservations' }}</h2>

  <form @submit.prevent="submitReservation">
    <div style="display:flex; gap:10px;">

      <!-- LEFT PANEL: Reservation Header + Order Details -->
      <div class="order-header mb-3" style="flex:1;">
        <div class="card">
          <div class="card-body">
            <div class="row g-3">

              <!-- Reference No -->
              <div class="col-md-6">
                <label class="fw-bold">Reference #:<span class="text-danger">*</span></label>
                <input
                  type="text"
                  class="form-control form-control-sm"
                  :value="referenceNo"
                  readonly
                  style="background:#e5e7eb;"
                />
              </div>

              <!-- Date and Time of Request -->
              <div class="col-md-6">
                <label class="fw-bold">Date and Time of Request:</label>
                <div class="input-group input-group-sm">
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    :value="dateTimeOfRequest"
                    readonly
                    style="background:#e5e7eb;"
                  />
                  <button type="button" class="btn btn-outline-secondary btn-sm" @click="clearDateTime">
                    Clear
                  </button>
                </div>
              </div>

              <!-- Customer Name -->
              <div class="col-md-6">
                <label class="fw-bold">Customer Name:<span v-if="!selectedCustomer" class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                  <v-select
                    style="flex:1;"
                    :options="customers"
                    v-model="selectedCustomer"
                    label="customer_name"
                    :reduce="c => c.id"
                    placeholder="Select Customer"
                    @input="onCustomerChange"
                    ref="customerSelect"
                  ></v-select>
                  <a
                    href="{{ route('customers.create', ['from' => 'reservation', 'redirect_back' => url()->current()]) }}"
                    class="btn btn-primary btn-sm ms-1"
                    title="Add Customer"
                    target="_blank"
                  >
                    <i class="i-Add"></i>
                  </a>
                </div>
              </div>

              <!-- Contact Number (autofill) -->
              <div class="col-md-6">
                <label class="fw-bold">Contact Number:</label>
                <input
                  type="text"
                  class="form-control form-control-sm"
                  v-model="contactNumber"
                  readonly
                  style="background:#e5e7eb;"
                  placeholder="Auto-filled from customer"
                />
              </div>

              <!-- Type of Reservation -->
              <div class="col-md-6">
                <label class="fw-bold">Type of Reservation:<span v-if="!reservationType" class="text-danger">*</span></label>
                <select
                  class="form-control form-control-sm"
                  v-model="reservationType"
                  :style="{ backgroundColor: reservationType ? '#e5e7eb' : '#fff' }"
                  required
                >
                  <option value="">Select Type</option>
                  <option value="Table Reservation">Table Reservation</option>
                  <option value="Private Dining">Private Dining</option>
                  <option value="Event Reservation">Event Reservation</option>
                  <option value="Catering Reservations">Catering Reservations</option>
                </select>
              </div>

              <!-- Date of Reservation -->
              <div class="col-md-4">
                <label class="fw-bold">Date of Reservation:<span v-if="!reservationDate" class="text-danger">*</span></label>
                <input
                  type="date"
                  class="form-control form-control-sm"
                  v-model="reservationDate"
                  :style="{ backgroundColor: reservationDate ? '#e5e7eb' : '#fff' }"
                  required
                />
              </div>

              <!-- Time of Reservation -->
              <div class="col-md-4">
                <label class="fw-bold">Time of Reservation:<span v-if="!reservationTime" class="text-danger">*</span></label>
                <input
                  type="time"
                  class="form-control form-control-sm"
                  v-model="reservationTime"
                  :style="{ backgroundColor: reservationTime ? '#e5e7eb' : '#fff' }"
                  required
                />
              </div>

              <!-- Number of Guests -->
              <div class="col-md-4">
                <label class="fw-bold">Number of Guest:</label>
                <input
                  type="number"
                  min="1"
                  class="form-control form-control-sm"
                  v-model.number="numberOfGuest"
                  :style="{ backgroundColor: numberOfGuest ? '#e5e7eb' : '#fff' }"
                />
              </div>

              <!-- Downpayment Section -->
              <div class="col-12">
                <label class="fw-bold">Downpayment</label>
                <div class="row g-2">
                  <!-- Amount -->
                  <div class="col-md-4">
                    <label class="text-muted" style="font-size:12px;">Amount</label>
                    <input
                      type="number"
                      min="0"
                      step="0.01"
                      class="form-control form-control-sm"
                      v-model.number="downpaymentAmount"
                      :style="{ backgroundColor: downpaymentAmount ? '#e5e7eb' : '#fff' }"
                    />
                  </div>
                  <!-- Payment Method -->
                  <div class="col-md-4">
                    <label class="text-muted" style="font-size:12px;">Payment Method</label>
                    <v-select
                      :options="paymentMethods"
                      v-model="paymentMethodId"
                      label="name"
                      :reduce="p => p.id"
                      placeholder="Select Method"
                    ></v-select>
                  </div>
                  <!-- Payment Destination -->
                  <div class="col-md-4">
                    <label class="text-muted" style="font-size:12px;">Payment Destination</label>
                    <v-select
                      :options="paymentDestinations"
                      v-model="cashEquivalentId"
                      label="name"
                      :reduce="c => c.id"
                      placeholder="Select Destination"
                    ></v-select>
                  </div>
                </div>
              </div>

              <!-- Note -->
              <div class="col-12">
                <label class="fw-bold">Note:</label>
                <textarea
                  class="form-control form-control-sm"
                  v-model="note"
                  rows="2"
                  placeholder="Special requests or notes..."
                ></textarea>
              </div>

            </div>
          </div>
        </div>

        <!-- Order Details Table -->
        <h2 class="mt-4">Order Details</h2>
        <div class="card">
          <nav class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a href="#" class="nav-link active">Menu</a>
              </li>
            </ul>
          </nav>
          <div class="card">
            <div class="card-body">
              <div class="vgt-wrap">
                <div class="vgt-inner-wrap">
                  <div class="vgt-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table id="order-details-table" class="table-hover tableOne vgt-table custom-vgt-table">
                      <thead>
                        <tr>
                          <th class="vgt-left-align text-left"><span>SKU</span></th>
                          <th class="vgt-left-align text-left"><span>Product</span></th>
                          <th class="vgt-left-align text-right"><span>Qty</span></th>
                          <th class="vgt-left-align text-right"><span>Amount</span></th>
                          <th class="vgt-left-align text-right"><span>Total</span></th>
                          <th class="vgt-left-align text-right"><span>Discount</span></th>
                          <th class="vgt-left-align text-right"><span>Note</span></th>
                          <th class="vgt-left-align text-right"><span>Status</span></th>
                          <th class="vgt-left-align text-right"><span>Option</span></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in orderDetails" :key="item.key">

                          <td>@{{ item.sku }}</td>
                          <td>@{{ item.name }}</td>

                          <input type="hidden" :name="`order_details[${index}][product_id]`" :value="item.type === 'product' ? item.id : null">
                          <input type="hidden" :name="`order_details[${index}][component_id]`" :value="item.type === 'component' ? item.id : null">

                          <td>
                            <div class="input-group input-group-sm" style="width: 120px;">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-primary" @click="item.qty = Math.max(1, item.qty - 1)">-</button>
                              </div>
                              <input
                                type="number"
                                step="0.01"
                                min="1"
                                class="form-control form-control-sm text-center"
                                v-model.number="item.qty"
                                :name="`order_details[${index}][quantity]`"
                              >
                              <div class="input-group-append">
                                <button type="button" class="btn btn-primary" @click="item.qty++">+</button>
                              </div>
                            </div>
                          </td>

                          <td>@{{ item.price.toFixed(2) }}</td>
                          <input type="hidden" :name="`order_details[${index}][price]`" :value="item.price">

                          <td>@{{ (item.qty * item.price).toFixed(2) }}</td>

                          <!-- Discount -->
                          <td>
                            <input
                              type="number"
                              min="0"
                              step="0.01"
                              class="form-control form-control-sm text-center"
                              style="width:80px;"
                              v-model.number="item.discount"
                              :name="`order_details[${index}][discount]`"
                              placeholder="0"
                            >
                          </td>

                          <!-- Note per item -->
                          <td>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              style="width:120px;"
                              v-model="item.notes"
                              :name="`order_details[${index}][notes]`"
                              placeholder="Note..."
                            >
                          </td>

                          <td>@{{ item.status }}</td>

                          <td class="text-center">
                            <button
                              type="button"
                              class="btn btn-sm btn-danger"
                              @click="removeItem(index)"
                            >
                              <i class="fa fa-trash"></i> Remove
                            </button>
                          </td>
                        </tr>

                        <tr v-if="orderDetails.length === 0">
                          <td colspan="9" class="vgt-center-align vgt-text-disabled">
                            No order details available
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <!-- Footer -->
                  <div class="vgt-wrap__footer vgt-clearfix">
                    <div class="footer__row-count vgt-pull-left">
                      <span>Total Items: @{{ orderDetails.length }}</span>
                    </div>
                    <div class="footer__navigation vgt-pull-right">
                      <span class="font-weight-bold">
                        Grand Total: @{{ grandTotal }}
                      </span>
                    </div>
                  </div>

                  <button type="submit" class="primary-btn btn btn-primary mt-3">
                    @{{ isEdit ? 'Update' : 'Submit' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end Order Details card -->
      </div><!-- end LEFT PANEL -->

      <!-- RIGHT PANEL: Product Search & Grid -->
      <div class="card h-100" style="flex:1;">
        <div class="card-body">

          <!-- Search -->
          <div class="autocomplete product-search-box" style="position: relative; width: 100%; max-width: 400px;">
            <input
              v-model="searchQuery"
              placeholder="Scan/Search Product by Code Or Name"
              class="autocomplete-input"
              style="width: 100%; padding-right: 35px;"
            >
            <button
              v-if="searchQuery"
              @click="clearSearch"
              type="button"
              class="btn search-product-clear-btn btn-link"
              style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); padding: 0; border: none;"
            >
              <i class="i-Close"></i>
            </button>
          </div>

          <div class="container" style="margin-left: 0;">

            <!-- Categories -->
            <div
              class="categories"
              v-if="categories && categories.length > 0 && !searchQuery.trim()"
              style="padding-left: 0;"
            >
              <div
                v-for="category in categories"
                :key="category.id"
                v-if="category.subcategories && category.subcategories.some(sub => sub.products?.length > 0 || sub.components?.length > 0)"
                class="mb-2"
              >
                <button
                  class="btn w-100 text-start"
                  :class="{ 'btn-primary': selectedCategory?.id === category.id }"
                  @click.prevent="toggleCategory(category)"
                >
                  @{{ category.name }}
                </button>

                <transition name="fade">
                  <div v-if="expandedCategory === category.id" class="ps-4 mt-2">
                    <div class="subcategory-menu p-2">
                      <div class="d-flex flex-column">
                        <button
                          v-for="sub in category.subcategories"
                          :key="sub.id"
                          v-if="sub.products?.length > 0 || sub.components?.length > 0"
                          class="btn btn-outline-secondary btn-sm text-start mb-1"
                          :class="{ 'btn-secondary': selectedSubcategory?.id === sub.id }"
                          @click.prevent="selectSubcategory(sub)"
                        >
                          @{{ sub.name }}
                        </button>
                      </div>
                    </div>
                  </div>
                </transition>
              </div>
            </div>

            <!-- Products Grid -->
            <div class="products">
              <div
                class="product-card"
                v-for="p in filteredProducts"
                :key="p.type + '-' + p.id"
                @click="addToOrder(p)"
                style="cursor: pointer;"
              >
                <img :src="p.image" :alt="p.name">
                <div class="product-body">
                  <p style="font-weight:800">@{{ p.name }}</p>
                  <p>@{{ p.description }}</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div><!-- end RIGHT PANEL -->

    </div>
  </form>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="addCustomerModalLabel">
          <i class="i-Add me-2"></i> Add New Customer
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        {{-- ── Source badge: always tagged as "From Reservation" ── --}}
        <div class="alert alert-info d-flex align-items-center gap-2 py-2 mb-3" style="font-size:13px;">
          <i class="i-Calendar-4 me-1"></i>
          <div>
            <strong>Source:</strong>
            <span class="badge bg-primary ms-1">Order &amp; Reservations</span>
            — this customer is being added directly from the reservation form.
          </div>
        </div>

        {{-- hidden flag sent to backend --}}
        <input type="hidden" id="newCustomerSource" value="order_reservation">

        <div class="row g-3">

          {{-- Customer Name --}}
          <div class="col-md-6">
            <label class="fw-bold form-label">
              Customer Name <span class="text-danger">*</span>
            </label>
            <input type="text" id="newCustomerName" class="form-control form-control-sm"
                   placeholder="Enter full name" autocomplete="off">
            <div id="err_newCustomerName" class="invalid-feedback"></div>
          </div>

          {{-- Mobile No --}}
          <div class="col-md-6">
            <label class="fw-bold form-label">Mobile No.</label>
            <input type="text" id="newCustomerMobile" class="form-control form-control-sm"
                   placeholder="09xxxxxxxxx">
          </div>

          {{-- Email --}}
          <div class="col-md-6">
            <label class="fw-bold form-label">Email</label>
            <input type="email" id="newCustomerEmail" class="form-control form-control-sm"
                   placeholder="email@example.com">
          </div>

          {{-- Company Name --}}
          <div class="col-md-6">
            <label class="fw-bold form-label">Company Name</label>
            <input type="text" id="newCustomerCompany" class="form-control form-control-sm"
                   placeholder="Optional">
          </div>

          {{-- Address --}}
          <div class="col-md-12">
            <label class="fw-bold form-label">Address</label>
            <input type="text" id="newCustomerAddress" class="form-control form-control-sm"
                   placeholder="Street, Barangay, City">
          </div>

          {{-- Customer Type radio --}}
          <div class="col-md-12">
            <label class="fw-bold form-label d-block">Customer Type</label>
            <div class="d-flex flex-wrap gap-3">
              @foreach([
                'regular_customer'  => 'Regular',
                'vip_customer'      => 'VIP',
                'walk_in_customer'  => 'Walk-in',
                'senior_customer'   => 'Senior',
              ] as $value => $label)
              <div class="form-check">
                <input class="form-check-input" type="radio"
                       name="newCustomerType" id="type_{{ $value }}"
                       value="{{ $value }}"
                       {{ $value === 'regular_customer' ? 'checked' : '' }}>
                <label class="form-check-label" for="type_{{ $value }}">
                  {{ $label }}
                </label>
              </div>
              @endforeach
            </div>
          </div>

        </div>{{-- end row --}}
      </div>{{-- end modal-body --}}

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-primary btn-sm" id="saveCustomerBtn"
                onclick="saveNewCustomer()">
          <i class="i-Yes me-1"></i> Save Customer
        </button>
      </div>

    </div>
  </div>
</div>

<script>
Vue.component('v-select', VueSelect.VueSelect);

new Vue({
  el: "#app",
  data: {
    // Reservation Header
    referenceNo:       @json($nextReferenceNo ?? 'RSV-0000001'),
    dateTimeOfRequest: new Date().toLocaleString(),
    selectedCustomer:  null,
    contactNumber:     '',
    reservationType:   null,
    reservationDate:   null,
    reservationTime:   null,
    numberOfGuest:     null,
    downpaymentAmount: 0,
    paymentMethodId:    null,   // ID from payments table
    cashEquivalentId:   null,   // ID from cash_equivalents table
    note:              '',

    // Lookup data from backend
    customers:           @json($customers ?? []),
    paymentMethods:      @json($paymentMethods ?? []),       // objects: { id, name }
    paymentDestinations: @json($paymentDestinations ?? []),  // objects: { id, name }

    // Products / Categories (reused from order entry)
    categories:         @json($categories ?? []),
    products:           @json($products ?? []),
    selectedCategory:   null,
    selectedSubcategory: null,
    expandedCategory:   null,
    searchQuery:        '',

    // Order Details
    orderDetails: [],

    // Mode
    isEdit: {{ isset($reservation) ? 'true' : 'false' }},
    reservation: @json($reservation ?? null),
  },

  mounted() {
    if (this.isEdit && this.reservation) {
      this.referenceNo       = this.reservation.reference_number;
      this.dateTimeOfRequest = new Date(this.reservation.created_at).toLocaleString();
      this.selectedCustomer  = this.reservation.customer_id;
      this.contactNumber     = this.reservation.customer?.mobile_no ?? '';
      this.reservationType   = this.reservation.type_of_reservation;
      // 2705 slice to "YYYY-MM-DD" — full ISO string breaks <input type="date">
      this.reservationDate = this.reservation.reservation_date
        ? String(this.reservation.reservation_date).substring(0, 10)
        : null;
      // 2705 slice to "HH:MM" — "09:00:00" breaks <input type="time">
      this.reservationTime = this.reservation.reservation_time
        ? String(this.reservation.reservation_time).substring(0, 5)
        : null;
      this.numberOfGuest     = this.reservation.number_of_guest;
      this.downpaymentAmount  = parseFloat(this.reservation.downpayment_amount ?? 0);
      this.paymentMethodId    = this.reservation.payment_method_id ?? null;
      this.cashEquivalentId   = this.reservation.cash_equivalent_id ?? null;
      this.note               = this.reservation.special_request ?? '';

      // Prefill order details
      if (this.reservation.details) {
        this.orderDetails = this.reservation.details.map(d => ({
          key:      (d.product_id ? 'product' : 'component') + '-' + (d.product_id ?? d.component_id),
          id:       d.product_id ?? d.component_id,
          type:     d.product_id ? 'product' : 'component',
          sku:      d.product?.code ?? d.component?.code,
          name:     d.product?.name ?? d.component?.name,
          price:    parseFloat(d.price),
          qty:      d.quantity,
          discount: parseFloat(d.discount ?? 0),
          notes:    d.notes ?? '',
          status:   d.status ?? 'serving',
        }));
      }
    }
  },

  computed: {
    grandTotal() {
      return this.orderDetails
        .reduce((sum, item) => {
          const subtotal  = item.qty * item.price;
          const discount  = parseFloat(item.discount ?? 0);
          return sum + (subtotal - discount);
        }, 0)
        .toFixed(2);
    },

    filteredProducts() {
      if (this.searchQuery.trim() !== '') {
        const q = this.searchQuery.toLowerCase();
        return this.products.filter(p =>
          p.name.toLowerCase().includes(q) ||
          p.sku.toLowerCase().includes(q) ||
          (p.description || '').toLowerCase().includes(q)
        ).sort((a, b) => a.name.localeCompare(b.name));
      }

      let items = [...this.products];
      if (this.selectedSubcategory) {
        items = items.filter(p => p.subcategory_id === this.selectedSubcategory.id);
      } else if (this.selectedCategory) {
        items = items.filter(p => p.category_id === this.selectedCategory.id);
      }
      return items.sort((a, b) => a.name.localeCompare(b.name));
    },
  },

  methods: {
    clearDateTime() {
      this.dateTimeOfRequest = '';
    },

    onCustomerChange(customerId) {
      const found = this.customers.find(c => c.id === customerId);
      this.contactNumber = found ? (found.mobile_no ?? '') : '';
    },

    toggleCategory(category) {
      this.expandedCategory   = this.expandedCategory === category.id ? null : category.id;
      this.selectedCategory   = category;
      this.selectedSubcategory = null;
    },

    selectSubcategory(sub) {
      this.selectedSubcategory = sub;
    },

    clearSearch() {
      this.searchQuery = '';
    },

    addToOrder(product) {
      // Validate required fields first
      if (!this.selectedCustomer) {
        this.$nextTick(() => {
          const sel = this.$refs.customerSelect;
          if (sel) sel.$el.querySelector('input')?.focus();
        });
        return;
      }
      if (!this.reservationDate) {
        this.$nextTick(() => document.querySelector('[v-model="reservationDate"]')?.focus());
        return;
      }

      const key = product.type + '-' + product.id;
      const existing = this.orderDetails.find(i => i.key === key);

      if (existing) {
        existing.qty++;
      } else {
        this.orderDetails.push({
          key:      key,
          id:       product.id,
          type:     product.type,
          sku:      product.sku,
          name:     product.name,
          qty:      1,
          price:    parseFloat(product.price),
          discount: 0,
          notes:    '',
          status:   'serving',
        });
      }
    },

    removeItem(index) {
      this.orderDetails.splice(index, 1);
    },

    submitReservation() {
      const now = new Date();
      const timeSubmitted = now.getFullYear() + '-' +
        String(now.getMonth() + 1).padStart(2, '0') + '-' +
        String(now.getDate()).padStart(2, '0') + ' ' +
        now.toLocaleTimeString('en-US', { hour12: false });

      const payload = {
        customer_id:         this.selectedCustomer,
        type_of_reservation: this.reservationType,
        reservation_date:    this.reservationDate,
        reservation_time:    this.reservationTime,
        number_of_guest:     this.numberOfGuest,
        downpayment_amount:  this.downpaymentAmount,
        payment_method_id:   this.paymentMethodId,
        cash_equivalent_id:  this.cashEquivalentId,
        special_request:     this.note,
        time_submitted:      timeSubmitted,
        gross_amount:        parseFloat(this.grandTotal),
        status:              'pending',
        order_details: this.orderDetails.map(item => ({
          product_id:   item.type === 'product'   ? item.id : null,
          component_id: item.type === 'component' ? item.id : null,
          quantity:     item.qty,
          price:        item.price,
          discount:     item.discount ?? 0,
          notes:        item.notes ?? '',
          status:       item.status ?? 'serving',
        })),
      };

      const url = this.isEdit
        ? `/order-reservations/${this.reservation.id}`
        : '/order-reservations';

      const method = this.isEdit ? 'put' : 'post';

      Swal.fire({ title: 'Saving...', didOpen: () => Swal.showLoading(), allowOutsideClick: false });

      axios[method](url, payload)
        .then(res => {
          setTimeout(() => {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: res.data.message,
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.href = res.data.redirect ?? '/order-reservations';
            });
          }, 800);
        })
        .catch(err => {
          console.error('Error:', err.response?.data || err);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error saving reservation. Check console for details.',
            confirmButtonText: 'OK'
          });
        });
    },
  },

  watch: {
    selectedCustomer(newVal) {
      this.onCustomerChange(newVal);
    },
  },
});

// ── Quick Add Customer from Order & Reservation form ──────────────────────
function saveNewCustomer() {
  const nameEl   = document.getElementById('newCustomerName');
  const errEl    = document.getElementById('err_newCustomerName');
  const btn      = document.getElementById('saveCustomerBtn');

  const name        = nameEl.value.trim();
  const mobile      = document.getElementById('newCustomerMobile').value.trim();
  const email       = document.getElementById('newCustomerEmail').value.trim();
  const company     = document.getElementById('newCustomerCompany').value.trim();
  const address     = document.getElementById('newCustomerAddress').value.trim();
  const source      = document.getElementById('newCustomerSource').value;
  const typeRadio   = document.querySelector('input[name="newCustomerType"]:checked');
  const customerType = typeRadio ? typeRadio.value : 'regular_customer';

  // ── Validate required name ──
  if (!name) {
    nameEl.classList.add('is-invalid');
    errEl.textContent = 'Customer name is required.';
    nameEl.focus();
    return;
  }
  nameEl.classList.remove('is-invalid');

  // ── Loading state ──
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

  axios.post('/customers', {
    customer_name:  name,
    mobile_no:      mobile,
    email:          email,
    company_name:   company,
    address:        address,
    customer_type:  customerType,
    source:         source,   // "order_reservation" flag
  }, {
    headers: { 'X-CSRF-TOKEN': csrfToken }
  })
  .then(res => {
    const vm = document.getElementById('app').__vue__;
    vm.customers.push(res.data.customer);
    vm.selectedCustomer = res.data.customer.id;
    vm.contactNumber    = res.data.customer.mobile_no ?? '';

    // ── Reset form fields ──
    ['newCustomerName','newCustomerMobile','newCustomerEmail',
     'newCustomerCompany','newCustomerAddress'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
    // reset radio to default
    const defaultRadio = document.getElementById('type_regular_customer');
    if (defaultRadio) defaultRadio.checked = true;

    // ── Close modal ──
    const modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
    modal?.hide();

    // ── Success toast ──
    Swal.fire({
      icon: 'success',
      title: 'Customer Added!',
      html: `<strong>${res.data.customer.customer_name}</strong> has been saved and selected.`,
      timer: 2000,
      timerProgressBar: true,
      showConfirmButton: false,
    });
  })
  .catch(err => {
    console.error('Save customer error:', err.response?.data || err);
    const msg = err.response?.data?.message
      ?? err.response?.data?.errors?.customer_name?.[0]
      ?? 'Failed to save customer.';
    Swal.fire({ icon: 'error', title: 'Error', text: msg });
  })
  .finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<i class="i-Yes me-1"></i> Save Customer';
  });
}
</script>
@endsection