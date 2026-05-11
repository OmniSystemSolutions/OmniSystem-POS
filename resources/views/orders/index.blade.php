@extends('layouts.app')
@section('content')
<style>
#ordersApp { font-size: 14px; }
th, td { padding: 10px 12px; vertical-align: middle !important; font-size: 14px; }
thead  { background-color: #e9ecf3; font-weight: bold; }
tr     { transition: background-color 0.2s; }
tr:hover { background-color: #f0f4ff !important; }
.fw-semibold { font-weight: 600; }

/* ── Custom action dropdown ───────────────────────────────────── */
.act-wrap {
  position: relative;
  display: inline-block;
}

.act-trigger {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  border: none;
  background: transparent;
  cursor: pointer;
  transition: background 0.15s;
  gap: 3px;
}
.act-trigger:hover { background: #f0f4ff; }

.act-dot {
  width: 4px;
  height: 4px;
  border-radius: 50%;
  background: #555;
  display: block;
  transition: background 0.15s;
}
.act-trigger:hover .act-dot { background: #1a56db; }

.act-menu {
  min-width: 180px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.13), 0 2px 8px rgba(0,0,0,0.07);
  border: 1px solid #e8eaf0;
  padding: 6px 0;
  z-index: 9999;
  transform-origin: top right;
  transition: opacity 0.15s ease, transform 0.15s ease;
}
.act-menu.act-menu--enter {
  opacity: 0;
  transform: scale(0.93) translateY(-6px);
}
.act-menu.act-menu--active {
  opacity: 1;
  transform: scale(1) translateY(0);
}
/* Flip upward when near bottom of viewport */
.act-menu.act-menu--above {
  transform-origin: bottom right;
}
.act-menu.act-menu--above.act-menu--enter {
  transform: scale(0.93) translateY(6px);
}
/* Action column */
th.col-action, td.col-action {
  width: 52px;
  text-align: center;
  padding-left: 6px;
  padding-right: 6px;
}

.act-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 16px;
  font-size: 14px;
  font-weight: 500;
  color: #374151;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.12s, color 0.12s;
  white-space: nowrap;
}
.act-item:hover {
  background: #f0f4ff;
  color: #1a56db;
  text-decoration: none;
}
.act-item i {
  font-size: 14px;
  width: 18px;
  text-align: center;
  flex-shrink: 0;
  opacity: 0.7;
}
.act-item:hover i { opacity: 1; }

.act-item--danger { color: #dc2626; }
.act-item--danger:hover { background: #fff5f5; color: #dc2626; }

.act-divider {
  height: 1px;
  background: #f0f0f5;
  margin: 4px 0;
}
</style>

<div class="main-content" id="ordersApp">

  <!-- Breadcrumb -->
  <div>
    <div class="breadcrumb">
      <h1 class="mr-3">Orders</h1>
      <ul><li><a href="">POS</a></li></ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
  </div>

  {{-- ── Order Type Modal ─────────────────────────────────────────── --}}
  <div class="modal fade" id="orderTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Select Order Type</h5>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label>Order Type</label>
            <select class="form-control" v-model="orderType">
              <option value="Dine-In">Dine-In</option>
              <option value="Take-Out">Take-Out</option>
              <option value="Delivery">Delivery</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" @click="submitOrderType">Continue</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Bill Out Modal ───────────────────────────────────────────── --}}
  <div class="modal fade" id="billOutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" v-if="selectedOrder">
        <div class="modal-header">
          <h5 class="modal-title">Bill Out — Order #@{{ selectedOrder.id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Info strip -->
          <div class="row mb-3 g-2">
            <div class="col-md-3"><label class="form-label fw-bold">Order No</label><input class="form-control" :value="selectedOrder.id" readonly></div>
            <div class="col-md-3"><label class="form-label fw-bold">No of Pax</label><input class="form-control" :value="selectedOrder.number_pax" readonly></div>
            <div class="col-md-3"><label class="form-label fw-bold">Table No</label><input class="form-control" :value="selectedOrder.table_no" readonly></div>
            <div class="col-md-3"><label class="form-label fw-bold">Cashier</label><input class="form-control" :value="selectedOrder.cashier_name || currentUserName" readonly></div>
          </div>
          <hr>
          <h6 class="fw-bold text-center">GROSS CHARGE</h6>
          <div class="row mb-3">
            <div class="col-md-4 offset-md-4">
              <input class="form-control text-center fw-bold" :value="'₱' + orderGross.toFixed(2)" readonly>
            </div>
          </div>

          <!-- Discount selector -->
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label fw-bold">Discount</label>
              <v-select
                multiple
                :options="discounts"
                label="name"
                :reduce="d => d.id"
                v-model="bo.selectedDiscountIds"
                placeholder="Select discounts..."
                @input="onDiscountChange"
              ></v-select>
            </div>
          </div>

          <!-- Persons management (per selected discount) -->
          <div v-if="bo.selectedDiscountIds.length" class="border rounded p-3 mb-3" style="background:#f9f9f9;">
            <div v-for="dId in bo.selectedDiscountIds" :key="dId" class="mb-3">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <strong>@{{ discountName(dId) }} (@{{ discountValue(dId) }}%)</strong>
                <button type="button" class="btn btn-sm btn-outline-primary"
                  @click="addPerson(dId)">+ Add Person</button>
              </div>
              <div v-if="bo.persons[dId] && bo.persons[dId].length">
                <div v-for="(p, pi) in bo.persons[dId]" :key="pi" class="row g-2 mb-2">
                  <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" v-model="p.name" placeholder="Person Name">
                  </div>
                  <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm" v-model="p.id_number" placeholder="ID Number">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger w-100" @click="removePerson(dId, pi)">✕</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Other charges -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Other Charges</label>
              <input type="number" class="form-control" v-model.number="bo.otherCharges" @input="bo.calculated = false">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Charges Description</label>
              <input type="text" class="form-control" v-model="bo.chargesDescription">
            </div>
          </div>

          <div class="text-center mb-3">
            <button type="button" class="btn btn-success" @click="calculateBillOut" :disabled="!boCanCalculate">
              Calculate Charges and Discounts
            </button>
          </div>

          <!-- Results (shown after calculate) -->
          <div v-if="bo.calculated">
            <hr>
            <h6 class="fw-bold text-center">CHARGES AND DISCOUNTS</h6>
            <div class="row g-2">
              <div class="col-md-4">
                <label class="form-label">SR/PWD Bill</label>
                <input class="form-control" :value="bo.srPwdBill.toFixed(2)" readonly>
              </div>
              <div class="col-md-4">
                <label class="form-label">Reg Bill</label>
                <input class="form-control" :value="bo.regBill.toFixed(2)" readonly>
              </div>
              <div class="col-md-4">
                <label class="form-label">20% Discount</label>
                <input class="form-control" :value="bo.discount20.toFixed(2)" readonly>
              </div>
              <div class="col-md-4">
                <label class="form-label">Vatable</label>
                <input class="form-control" :value="bo.vatable.toFixed(2)" readonly>
              </div>
              <div class="col-md-4">
                <label class="form-label">VAT 12%</label>
                <input class="form-control" :value="bo.vat12.toFixed(2)" readonly>
              </div>
              <div class="col-md-4">
                <label class="form-label">Net Bill</label>
                <input class="form-control" :value="bo.netBill.toFixed(2)" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label">Other Discount</label>
                <input class="form-control" :value="bo.otherDiscount.toFixed(2)" readonly>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold text-success">TOTAL CHARGE</label>
                <input class="form-control fw-bold text-success" :value="bo.totalCharge.toFixed(2)" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info" :disabled="!bo.calculated" @click="openBillOutPreview">
            Preview Receipt
          </button>
          <button type="button" class="btn btn-primary" :disabled="!bo.calculated" @click="submitBillOut">
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Bill Out Preview Modal ───────────────────────────────────── --}}
  <div class="modal fade" id="billOutPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
      <div class="modal-content" v-if="selectedOrder">
        <div class="modal-header"><h5 class="modal-title">Bill-Out Slip</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-0">
          <div style="max-width:400px;margin:0 auto;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1.4;padding:16px;">
            <div class="text-center mb-2">
              <img src="/images/logo-default.png" width="60" height="60" alt="Logo">
              <div class="d-flex flex-column small mt-1">
                <span class="fw-bold">@{{ branch.name }}</span>
                <span>@{{ branch.address }}</span>
                <span v-if="branch.permit_number">Permit #: @{{ branch.permit_number }}</span>
              </div>
              <h6 class="fw-bold mt-2 mb-1">BILL-OUT SLIP</h6>
              <div>OR #: @{{ String(selectedOrder.id).padStart(8,'0') }}</div>
              <div>TBL: @{{ selectedOrder.table_no }} &nbsp;|&nbsp; Pax: @{{ selectedOrder.number_pax }}</div>
            </div>
            <table style="width:100%;font-size:14px;border-collapse:collapse;">
              <thead><tr>
                <th style="text-align:left;width:10%;">QTY</th>
                <th style="text-align:left;width:60%;">DESCRIPTION</th>
                <th style="text-align:right;width:30%;">AMOUNT</th>
              </tr></thead>
              <tbody>
                <tr v-for="d in selectedOrder.details" :key="d.id">
                  <td>@{{ d.quantity }}x</td>
                  <td>
                    <div>@{{ d.item_name }}</div>
                    <div style="font-size:11px;color:#666;">@₱@{{ d.price.toFixed(2) }}</div>
                  </td>
                  <td style="text-align:right;">₱@{{ (d.quantity * d.price).toFixed(2) }}</td>
                </tr>
              </tbody>
            </table>
            <hr style="margin:8px 0;border-top:1px dashed #999;">
            <div style="display:flex;justify-content:space-between;font-weight:bold;">
              <span>GROSS CHARGE</span><span>₱@{{ orderGross.toFixed(2) }}</span>
            </div>
            <div v-if="bo.calculated">
              <div style="display:flex;justify-content:space-between;">
                <span>SR/PWD Bill</span><span>₱@{{ bo.srPwdBill.toFixed(2) }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;">
                <span>Reg Bill</span><span>₱@{{ bo.regBill.toFixed(2) }}</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-weight:bold;font-size:15px;margin-top:6px;">
                <span>TOTAL CHARGE</span><span>₱@{{ bo.totalCharge.toFixed(2) }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Payment Modal ────────────────────────────────────────────── --}}
  <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" v-if="selectedOrder">
        <div class="modal-header">
          <h5 class="modal-title">Payment — Order #@{{ selectedOrder.id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <!-- Info strip -->
          <div class="row mb-3 g-2">
            <div class="col-md-3"><label class="form-label fw-bold">Order No</label><input class="form-control" :value="selectedOrder.id" readonly></div>
            <div class="col-md-3"><label class="form-label fw-bold">No of Pax</label><input class="form-control" :value="selectedOrder.number_pax" readonly></div>
            <div class="col-md-3"><label class="form-label fw-bold">Table</label><input class="form-control" :value="selectedOrder.table_no" readonly></div>
            <div class="col-md-3"><label class="form-label fw-bold">Total Charge</label>
              <input class="form-control fw-bold text-success" :value="'₱' + (selectedOrder.total_charge || 0).toFixed(2)" readonly>
            </div>
          </div>
          <!-- Payment rows -->
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Mode of Payment</strong>
            <button type="button" class="btn btn-sm btn-warning" @click="addPaymentRow">Add</button>
          </div>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead><tr>
                <th>Payment Method</th>
                <th>Payment Destination</th>
                <th>Reference #</th>
                <th class="text-end">Amount Paid</th>
                <th>Action</th>
              </tr></thead>
              <tbody>
                <tr v-for="(row, idx) in paymentRows" :key="idx">
                  <td>
                    <select class="form-select form-select-sm" v-model="row.payment_method_id" @change="onPaymentMethodChange(idx)">
                      <option value=""></option>
                      <option v-for="m in paymentMethods" :key="m.id" :value="m.id">@{{ m.name }}</option>
                    </select>
                  </td>
                  <td>
                    <select class="form-select form-select-sm" v-model="row.cash_equivalent_id">
                      <option value=""></option>
                      <option v-for="c in filteredCashEquivalents(idx)" :key="c.id" :value="c.id">
                        @{{ c.name }} | @{{ c.account_number || '' }}
                      </option>
                    </select>
                  </td>
                  <td>
                    <input v-if="row.showRef" type="text" class="form-control form-control-sm"
                      v-model="row.reference_no" placeholder="Ref. No.">
                    <span v-else class="text-muted small">—</span>
                  </td>
                  <td>
                    <input type="number" step="0.01" class="form-control form-control-sm text-end"
                      v-model.number="row.amount" @input="recalcPayments">
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-danger" @click="removePaymentRow(idx)">Remove</button>
                  </td>
                </tr>
                <tr v-if="paymentRows.length === 0">
                  <td colspan="5" class="text-center text-muted">No payment rows. Click Add.</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-end"><strong>Total Payment Rendered</strong></td>
                  <td class="text-end fw-bold">@{{ paymentTotalRendered.toFixed(2) }}</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-end"><strong>Change</strong></td>
                  <td class="text-end fw-bold">@{{ paymentChange.toFixed(2) }}</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer justify-content-between flex-wrap gap-2">
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="submitPayment">Submit</button>
          </div>
          <button type="button" class="btn btn-warning" @click="revertToBillOut">Revert to Bill-Out</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Main Card ────────────────────────────────────────────────── --}}
  <div class="wrapper">
    <div class="card mt-4">
      <nav class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item" v-for="tab in tabs" :key="tab.value">
            <a href="#" class="nav-link" :class="{ active: statusFilter === tab.value }"
               @click.prevent="setStatus(tab.value)">@{{ tab.label }}</a>
          </li>
        </ul>
        <div class="d-flex align-items-center gap-2">
          <input v-model="searchQuery" type="text" placeholder="Search…"
            class="form-control form-control-sm" style="width:190px;">
          <button type="button" class="btn btn-primary btn-sm"
            data-bs-toggle="modal" data-bs-target="#orderTypeModal">
            <i class="i-Add"></i> Add
          </button>
        </div>
      </nav>

      <!-- Serving view toggle -->
      <div v-if="statusFilter === 'serving'" class="d-flex justify-content-end gap-2 px-3 pt-3">
        <div class="btn-group">
          <button type="button" class="btn btn-sm"
            :class="viewMode === 'tabular' ? 'btn-primary' : 'btn-outline-secondary'"
            @click="viewMode = 'tabular'"><i class="i-Table2"></i> Tabular</button>
          <button type="button" class="btn btn-sm"
            :class="viewMode === 'layout' ? 'btn-primary' : 'btn-outline-secondary'"
            @click="switchToLayout"><i class="i-Map2"></i> Layout</button>
        </div>
      </div>

      <!-- Layout view (canvas) -->
      <div id="layout-view" v-show="statusFilter === 'serving' && viewMode === 'layout'" style="padding:15px 20px;">
        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
          <select id="layoutSelect" class="form-select form-select-sm" style="width:220px;" onchange="loadSelectedLayout()">
            <option value="">-- Select a layout --</option>
          </select>
          <div class="ms-3 d-flex gap-3">
            <span><span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#f44336;margin-right:4px;"></span>Occupied</span>
            <span><span style="display:inline-block;width:12px;height:12px;border-radius:50%;background:#42a5f5;margin-right:4px;"></span>Available</span>
          </div>
        </div>
        <div id="layout-floors" class="d-flex gap-2 mb-2 flex-wrap"></div>
        <div style="overflow:auto;border:1px solid #ddd;border-radius:8px;background:#f5f5f5;">
          <div id="layout-canvas"></div>
        </div>
      </div>

      <div class="card-body">
        <!-- Loading -->
        <div v-if="loading" class="text-center py-4 text-muted">
          <span class="spinner-border spinner-border-sm me-2"></span> Loading…
        </div>

        <div v-show="!loading && (statusFilter !== 'serving' || viewMode !== 'layout')" style="max-height:480px;overflow-y:auto;">
          <table class="table-hover vgt-table custom-vgt-table" style="width:100%;border-collapse:collapse;">
            <thead>
              <tr>
                <th></th>
                <th>Order No.</th>
                <th>Order Type</th>
                <th>Waiter</th>
                <th>Table</th>
                <th>Pax</th>
                <th>Status</th>
                <th>Amount</th>
                <th class="col-action">Action</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="order in filteredOrders" :key="order.id">
                <tr>
                  <td>
                    <input type="checkbox" :checked="expandedOrderId === order.id"
                      @change="toggleDetails(order.id)">
                  </td>
                  <td class="fw-bold text-primary">
                    #@{{ order.id }}
                    <span v-if="order.reservation_id"
                      class="badge badge-warning d-block" style="font-size:10px;white-space:nowrap;">
                      <i class="i-Calendar"></i> From Reservation
                      <span v-if="order.reservation_ref">· @{{ order.reservation_ref }}</span>
                    </span>
                  </td>
                  <td>@{{ order.order_type }}</td>
                  <td>@{{ order.user_name }}</td>
                  <td>@{{ order.table_no }}</td>
                  <td>@{{ order.number_pax }}</td>
                  <td><span class="badge" :class="statusBadge(order.status)">@{{ capitalize(order.status) }}</span></td>
                  <td class="fw-semibold" :class="{ 'text-success': order.status === 'billout' }">
                    ₱@{{ displayAmount(order).toFixed(2) }}
                  </td>
                  <td class="col-action">
                    <div class="act-wrap" @click.stop>
                      <button class="act-trigger" @click="toggleDropdown(order.id, $event)">
                        <span class="act-dot"></span>
                        <span class="act-dot"></span>
                        <span class="act-dot"></span>
                      </button>
                      <div v-if="openDropdownId === order.id"
                        class="act-menu"
                        :style="dropdownStyle"
                        :class="[dropdownAbove ? 'act-menu--above' : '', dropdownReady ? 'act-menu--active' : 'act-menu--enter']">
                        <!-- Edit -->
                        <a v-if="statusFilter !== 'payments'"
                          class="act-item" :href="'/orders/' + order.id + '/edit'">
                          <i class="i-Edit"></i> Edit
                        </a>
                        <!-- Bill Out -->
                        <a v-if="statusFilter === 'serving'"
                          class="act-item" href="#"
                          @click.prevent="closeDropdown(); openBillOut(order)">
                          <i class="i-Receipt"></i> Bill Out
                        </a>
                        <!-- Payment -->
                        <template v-if="statusFilter === 'billout'">
                          <a class="act-item" href="#"
                            @click.prevent="closeDropdown(); openPayment(order)">
                            <i class="i-Money-2"></i> Payment
                          </a>
                          <div class="act-divider"></div>
                          <a class="act-item" href="#"
                            @click.prevent="closeDropdown(); openBillOutSlip(order)">
                            <i class="i-Receipt-3"></i> Print Bill Out
                          </a>
                        </template>
                        <!-- View Receipt -->
                        <a v-if="statusFilter === 'payments'"
                          class="act-item" href="#"
                          @click.prevent="closeDropdown(); viewReceipt(order)">
                          <i class="i-Receipt"></i> View Receipt
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
                <!-- Expand row: order details -->
                <tr v-show="expandedOrderId === order.id">
                  <td colspan="9">
                    <div style="max-height:200px;overflow-y:auto;padding:10px;border:1px solid #ddd;background:#f9f9f9;">
                      <table style="width:100%;border-collapse:collapse;">
                        <thead style="border-bottom:1px solid #ccc;background:#e9e9e9;">
                          <tr><th>SKU</th><th>Product</th><th>Qty</th><th>Amount</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                          <tr v-for="d in order.details" :key="d.id">
                            <td>@{{ d.code }}</td>
                            <td>@{{ d.item_name }}</td>
                            <td>@{{ d.quantity }}</td>
                            <td>₱@{{ d.price.toFixed(2) }}</td>
                            <td>@{{ d.status }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
              </template>
              <tr v-if="!loading && filteredOrders.length === 0">
                <td colspan="9" class="text-center text-muted py-3">No orders found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>{{-- /ordersApp --}}

<script>
Vue.component('v-select', VueSelect.VueSelect);

window.__vueApp = new Vue({
  el: '#ordersApp',

  data: {
    loading: false,
    statusFilter: 'serving',
    viewMode: 'tabular',
    tabs: [
      { label: 'Serving',  value: 'serving'  },
      { label: 'Bill Out', value: 'billout'  },
      { label: 'Payment',  value: 'payments' },
    ],
    orders: [],
    discounts: [],
    paymentMethods: [],
    cashEquivalents: [],
    branch: {},
    currentUserId: null,
    currentUserName: '{{ auth()->user()->name ?? "" }}',
    searchQuery: '',
    expandedOrderId: null,
    selectedOrder: null,
    modalMode: null,
    orderType: 'Dine-In',
    openDropdownId: null,
    dropdownReady: false,
    dropdownAbove: false,
    dropdownStyle: {},

    // Bill Out state
    bo: {
      selectedDiscountIds: [],
      discountCounts: {},
      persons: {},
      otherCharges: 0,
      chargesDescription: '',
      showPersons: false,
      calculated: false,
      srPwdBill: 0, regBill: 0, vatable: 0, vat12: 0,
      netBill: 0, discount20: 0, otherDiscount: 0,
      totalCharge: 0, vatExempt12: 0,
    },

    // Payment state
    paymentRows: [],
  },

  computed: {
    filteredOrders() {
      const q = this.searchQuery.toLowerCase();
      if (!q) return this.orders;
      return this.orders.filter(o =>
        String(o.id).includes(q) ||
        (o.user_name || '').toLowerCase().includes(q) ||
        String(o.table_no).includes(q) ||
        (o.order_type || '').toLowerCase().includes(q)
      );
    },

    orderGross() {
      if (!this.selectedOrder) return 0;
      return this.selectedOrder.details.reduce(
        (s, d) => s + d.price * d.quantity - (d.discount || 0), 0
      );
    },

    paymentTotalRendered() {
      return this.paymentRows.reduce((s, r) => s + (parseFloat(r.amount) || 0), 0);
    },

    paymentChange() {
      const charge = parseFloat(this.selectedOrder?.total_charge || 0);
      return Math.max(0, this.paymentTotalRendered - charge);
    },

    boCanCalculate() {
      if (!this.bo.selectedDiscountIds.length) return true;
      return this.bo.selectedDiscountIds.every(id => {
        const persons = this.bo.persons[id] || [];
        return persons.length > 0 && persons.every(p => (p.name || '').trim() && (p.id_number || '').trim());
      });
    },
  },

  watch: {
    statusFilter() { this.fetchOrders(); },

    boCanCalculate(val) {
      if (val && this.bo.selectedDiscountIds.length > 0) {
        this.bo.selectedDiscountIds.forEach(id => {
          const count = (this.bo.persons[id] || []).filter(p => (p.name || '').trim() && (p.id_number || '').trim()).length;
          this.$set(this.bo.discountCounts, id, count);
        });
        this.calculateBillOut();
      } else if (!val) {
        this.bo.calculated = false;
      }
    },
  },

  mounted() {
    this.fetchOrders();
    document.addEventListener('click', () => this.closeDropdown());
  },

  methods: {
    // ── Dropdown ─────────────────────────────────────────────────────
    toggleDropdown(id, e) {
      if (this.openDropdownId === id) { this.closeDropdown(); return; }
      const btn  = e.currentTarget;
      const rect = btn.getBoundingClientRect();
      const above = (window.innerHeight - rect.bottom) < 160;
      this.openDropdownId = id;
      this.dropdownReady  = false;
      this.dropdownAbove  = above;
      this.dropdownStyle  = above
        ? { position: 'fixed', bottom: (window.innerHeight - rect.top + 4) + 'px', top: 'auto', right: (window.innerWidth - rect.right) + 'px' }
        : { position: 'fixed', top: (rect.bottom + 4) + 'px', right: (window.innerWidth - rect.right) + 'px' };
      this.$nextTick(() => { requestAnimationFrame(() => { this.dropdownReady = true; }); });
    },
    closeDropdown() { this.openDropdownId = null; this.dropdownReady = false; this.dropdownAbove = false; this.dropdownStyle = {}; },

    // ── Data ──────────────────────────────────────────────────────────
    fetchOrders() {
      this.loading = true;
      axios.get('/orders/fetch', { params: { status: this.statusFilter } })
        .then(res => {
          this.orders          = res.data.orders;
          this.discounts       = res.data.discounts;
          this.paymentMethods  = res.data.paymentMethods;
          this.cashEquivalents = res.data.cashEquivalents;
          this.branch          = res.data.branch;
          this.currentUserId   = res.data.currentUserId;
          window.appBranch     = res.data.branch;
          window.paymentMethodsMap = {};
          this.paymentMethods.forEach(m => { window.paymentMethodsMap[m.id] = m.name; });
          if (this.statusFilter === 'serving') {
            window._servingOrders = this.orders;
            this.$nextTick(() => {
              if (typeof window._refreshLayoutOccupancy === 'function') window._refreshLayoutOccupancy();
            });
          }
        })
        .catch(err => console.error('Fetch error:', err))
        .finally(() => { this.loading = false; });
    },

    setStatus(status) { this.statusFilter = status; },

    // ── Order Type Modal ──────────────────────────────────────────────
    submitOrderType() {
      const modal = bootstrap.Modal.getInstance(document.getElementById('orderTypeModal'));
      modal.hide();
      let url = `{{ url('order/create') }}?type=${encodeURIComponent(this.orderType)}`;
      if (window._pendingTableNo != null) {
        url += `&table_no=${encodeURIComponent(window._pendingTableNo)}`;
        window._pendingTableNo = null;
      }
      window.location.href = url;
    },

    // ── Helpers ───────────────────────────────────────────────────────
    capitalize(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; },

    statusBadge(s) {
      return {
        'badge-success': s === 'served',
        'badge-warning': s === 'billout',
        'badge-info':    s === 'serving',
        'badge-primary': s === 'payments',
        'badge-danger':  s === 'cancelled',
      };
    },

    displayAmount(order) {
      if (order.status === 'billout') return order.total_charge || 0;
      return order.details.reduce((s, d) => s + d.price * d.quantity, 0);
    },

    toggleDetails(id) {
      this.expandedOrderId = this.expandedOrderId === id ? null : id;
    },

    discountName(id) {
      const d = this.discounts.find(d => d.id === id);
      return d ? d.name : '';
    },

    discountValue(id) {
      const d = this.discounts.find(d => d.id === id);
      return d ? d.value : 0;
    },

    isSrPwd(id) {
      const name = this.discountName(id).toLowerCase();
      return name.includes('senior') || name.includes('pwd');
    },

    // ── Bill Out ──────────────────────────────────────────────────────
    openBillOut(order) {
      this.selectedOrder = JSON.parse(JSON.stringify(order));
      this.modalMode     = 'billout';

      // Pre-populate from existing discount entries
      const existingIds = [...new Set(order.discount_entries.map(de => de.discount_id))];
      const counts = {};
      existingIds.forEach(id => {
        counts[id] = order.discount_entries.filter(de => de.discount_id === id).length;
      });
      const persons = {};
      existingIds.forEach(id => {
        persons[id] = order.discount_entries
          .filter(de => de.discount_id === id)
          .map(de => ({ name: de.person_name || '', id_number: de.person_id_number || '' }));
      });

      this.bo = {
        selectedDiscountIds: existingIds,
        discountCounts: counts,
        persons,
        otherCharges:      0,
        chargesDescription: order.charges_description || '',
        showPersons:        existingIds.length > 0,
        calculated:         !!order.total_charge,
        srPwdBill:   order.sr_pwd_bill     || 0,
        regBill:     order.regular_bill    || 0,
        vatable:     order.vatable         || 0,
        vat12:       order.vat_12          || 0,
        netBill:     order.net_amount      || 0,
        discount20:  order.sr_pwd_discount || 0,
        otherDiscount: order.other_discounts || 0,
        totalCharge: order.total_charge    || 0,
        vatExempt12: order.vat_exempt_12   || 0,
      };

      this.$nextTick(() => {
        this._showModal('billOutModal');
      });
    },

    onDiscountChange() {
      this.bo.calculated = false;
      this.bo.selectedDiscountIds.forEach(id => {
        if (!this.bo.persons[id] || !this.bo.persons[id].length) {
          this.$set(this.bo.persons, id, [{ name: '', id_number: '' }]);
        }
      });
    },

    addPerson(discountId) {
      if (!this.bo.persons[discountId]) {
        this.$set(this.bo.persons, discountId, []);
      }
      this.bo.persons[discountId].push({ name: '', id_number: '' });
    },

    removePerson(discountId, idx) {
      this.bo.persons[discountId].splice(idx, 1);
    },

    calculateBillOut() {
      const vatRate    = 0.12;
      const gross      = this.orderGross;
      const pax        = Math.max(1, parseInt(this.selectedOrder.number_pax) || 1);
      const ids        = this.bo.selectedDiscountIds;

      let qualifiedCount  = 0;
      let discountPercent = 0;
      let otherDiscount   = 0;

      ids.forEach(id => {
        const d     = this.discounts.find(d => d.id === id);
        if (!d) return;
        const count = parseInt(this.bo.discountCounts[id]) || 0;
        const val   = parseFloat(d.value) || 0;

        if (this.isSrPwd(id)) {
          if (count > 0) { qualifiedCount += count; discountPercent = val; }
        } else {
          const c    = count > 0 ? count : 1;
          otherDiscount += (gross * (val / 100)) * c;
        }
      });

      qualifiedCount = Math.min(qualifiedCount, pax);
      const perPax       = gross / pax;
      const srPwdBill    = perPax * qualifiedCount;
      const regBill      = perPax * (pax - qualifiedCount);
      const vatable      = regBill / (1 + vatRate);
      const vat12        = regBill - vatable;
      const srPwdVatable = srPwdBill / (1 + vatRate);
      const discount20   = srPwdVatable * (discountPercent / 100);
      const netBill      = srPwdVatable - discount20;
      const totalCharge  = (gross - otherDiscount)
                         - ((srPwdBill / (1 + vatRate)) * vatRate)
                         - ((srPwdBill / (1 + vatRate)) * (discountPercent / 100));
      const vatExempt12  = srPwdBill - srPwdVatable;

      this.bo.srPwdBill    = srPwdBill;
      this.bo.regBill      = regBill;
      this.bo.vatable      = vatable;
      this.bo.vat12        = vat12;
      this.bo.netBill      = netBill;
      this.bo.discount20   = discount20;
      this.bo.otherDiscount = otherDiscount;
      this.bo.totalCharge  = totalCharge;
      this.bo.vatExempt12  = vatExempt12;
      this.bo.calculated   = true;
    },

    openBillOutPreview() {
      this._showModal('billOutPreviewModal');
    },

    openBillOutSlip(order) {
      this.selectedOrder = JSON.parse(JSON.stringify(order));
      this.bo.calculated = true;
      this.bo.srPwdBill    = order.sr_pwd_bill || 0;
      this.bo.regBill      = order.regular_bill || 0;
      this.bo.totalCharge  = order.total_charge || 0;
      this.$nextTick(() => this._showModal('billOutPreviewModal'));
    },

    submitBillOut() {
      if (!this.bo.calculated) return;

      const persons = [];
      this.bo.selectedDiscountIds.forEach(id => {
        (this.bo.persons[id] || []).forEach(p => {
          if (p.name) persons.push({ discount_id: id, name: p.name, id_number: p.id_number || '' });
        });
      });

      const payload = new FormData();
      payload.append('_token', document.querySelector('meta[name="csrf-token"]').content);
      payload.append('grossCharge', this.orderGross.toFixed(2));
      payload.append('srPwdBill',   this.bo.srPwdBill.toFixed(2));
      payload.append('regBill',     this.bo.regBill.toFixed(2));
      payload.append('discount20',  this.bo.discount20.toFixed(2));
      payload.append('netBill',     this.bo.netBill.toFixed(2));
      payload.append('vatable',     this.bo.vatable.toFixed(2));
      payload.append('vat12',       this.bo.vat12.toFixed(2));
      payload.append('totalCharge', this.bo.totalCharge.toFixed(2));
      payload.append('otherDiscount', this.bo.otherDiscount.toFixed(2));
      payload.append('vat_exempt_12', this.bo.vatExempt12.toFixed(2));
      payload.append('charges_description', this.bo.chargesDescription || '');
      if (persons.length) payload.append('persons', JSON.stringify(persons));

      Swal.fire({ title: 'Processing…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

      axios.post(`/orders/${this.selectedOrder.id}/billout`, payload)
        .then(res => {
          if (res.data.success) {
            Swal.fire({ icon: 'success', title: 'Bill Out saved!', timer: 1500, showConfirmButton: false });
            this._hideModal('billOutModal');
            this.fetchOrders();
          } else {
            Swal.fire('Error', res.data.message || 'Failed.', 'error');
          }
        })
        .catch(err => Swal.fire('Error', err.response?.data?.message || 'Server error.', 'error'));
    },

    // ── Payment ───────────────────────────────────────────────────────
    openPayment(order) {
      this.selectedOrder = JSON.parse(JSON.stringify(order));
      this.modalMode     = 'payment';
      this.paymentRows   = [];
      this.$nextTick(() => this._showModal('paymentModal'));
    },

    filteredCashEquivalents(idx) {
      const row    = this.paymentRows[idx];
      const pmId   = row?.payment_method_id;
      const pmName = (window.paymentMethodsMap?.[pmId] || '').toLowerCase();
      if (!pmId) return this.cashEquivalents;
      if (pmName === 'cash') {
        return this.cashEquivalents.filter(c => c.created_by === this.currentUserId);
      }
      return this.cashEquivalents;
    },

    addPaymentRow() {
      this.paymentRows.push({
        payment_method_id: '',
        cash_equivalent_id: '',
        reference_no: '',
        amount: 0,
        showRef: false,
      });
    },

    removePaymentRow(idx) { this.paymentRows.splice(idx, 1); },

    onPaymentMethodChange(idx) {
      const row    = this.paymentRows[idx];
      const pmName = (window.paymentMethodsMap?.[row.payment_method_id] || '').toLowerCase();
      row.showRef  = pmName !== 'cash';
      row.cash_equivalent_id = '';
    },

    recalcPayments() { /* computed handles it */ },

    submitPayment() {
      const payments = this.paymentRows
        .filter(r => r.payment_method_id && r.cash_equivalent_id && parseFloat(r.amount) > 0)
        .map(r => ({
          payment_method_id:  r.payment_method_id,
          cash_equivalent_id: r.cash_equivalent_id,
          reference_no:       r.reference_no || '',
          amount_paid:        parseFloat(r.amount),
        }));

      if (!payments.length) {
        Swal.fire('Warning', 'Please add at least one valid payment row.', 'warning');
        return;
      }

      const charge = parseFloat(this.selectedOrder.total_charge || 0);
      if (this.paymentTotalRendered < charge) {
        Swal.fire('Warning', `Insufficient payment. Short by ₱${(charge - this.paymentTotalRendered).toFixed(2)}`, 'warning');
        return;
      }

      Swal.fire({ title: 'Processing…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

      const payload = new FormData();
      payload.append('payments',               JSON.stringify(payments));
      payload.append('total_payment_rendered', this.paymentTotalRendered);
      payload.append('change_amount',          this.paymentChange);

      axios.post(`/orders/${this.selectedOrder.id}/payment`, payload, {
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
      })
      .then(res => {
        if (res.data.success) {
          this._hideModal('paymentModal');
          Swal.close();
          if (res.data.order && window.openInvoiceModalFromResponse) {
            window.openInvoiceModalFromResponse(res.data.order);
          }
          this.fetchOrders();
        } else {
          Swal.fire('Error', res.data.message || 'Failed.', 'error');
        }
      })
      .catch(err => Swal.fire('Error', err.response?.data?.message || 'Server error.', 'error'));
    },

    revertToBillOut() {
      Swal.fire({
        title: 'Revert to Bill-Out?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, revert',
      }).then(r => {
        if (!r.isConfirmed) return;
        axios.post(`/orders/${this.selectedOrder.id}/billout`,
          new URLSearchParams({ _token: document.querySelector('meta[name="csrf-token"]').content, revert: 1 })
        )
        .then(() => { this._hideModal('paymentModal'); this.fetchOrders(); })
        .catch(() => Swal.fire('Error', 'Could not revert.', 'error'));
      });
    },

    viewReceipt(order) {
      if (window.openInvoiceModalFromResponse) {
        window.openInvoiceModalFromResponse({
          ...order,
          payment_details: order.payment_details,
          discount_entries: order.discount_entries,
          details: order.details,
        });
      }
    },

    // ── Layout view ───────────────────────────────────────────────────
    switchToLayout() {
      this.viewMode = 'layout';
      if (typeof window._loadLayoutList === 'function') {
        window._loadLayoutList();
      } else if (typeof _loadLayoutList === 'function') {
        _loadLayoutList();
      }
    },

    // ── Modal helpers ─────────────────────────────────────────────────
    _showModal(id) {
      const el = document.getElementById(id);
      if (!el) return;
      (bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el, { backdrop: 'static' })).show();
    },
    _hideModal(id) {
      const el = document.getElementById(id);
      if (el) bootstrap.Modal.getInstance(el)?.hide();
    },
  },
});
</script>

{{-- Invoice modal builder (kept as-is, called from Vue viewReceipt / submitPayment) --}}
<script>
window.openInvoiceModalFromResponse = function(orderData) {
  if (!orderData || !orderData.id) return;
  const orderId = orderData.id;
  const modalId = 'invoiceModal' + orderId;
  let existing  = document.getElementById(modalId);
  if (existing) existing.remove();

  const branch = window.appBranch || {};
  const paymentsArr = orderData.payment_details || orderData.paymentDetails || [];
  const paymentsMap = {};
  let totalPaid = 0;
  paymentsArr.forEach(pd => {
    const name = pd.payment?.name || pd.payment_name || 'Unknown';
    const amt  = Number(pd.amount_paid || pd.amount || 0);
    totalPaid += amt;
    paymentsMap[name] = (paymentsMap[name] || 0) + amt;
  });

  const gross = Number(orderData.gross_amount || 0) ||
    (orderData.details || []).reduce((s, d) => s + Number(d.price || 0) * Number(d.quantity || 0), 0);

  let paymentsHtml = '';
  if (Object.keys(paymentsMap).length) {
    paymentsHtml = `<hr style="border-top:2px dashed #333;margin:15px 0">
      <div style="font-weight:bold;text-align:center;margin-bottom:10px">PAYMENT BREAKDOWN</div>`;
    Object.keys(paymentsMap).forEach(method => {
      paymentsHtml += `<div style="display:flex;justify-content:space-between;padding:2px 0">
        <div>${method}</div><div>₱${paymentsMap[method].toFixed(2)}</div></div>`;
    });
    const rendered = Number(orderData.total_payment_rendered ?? totalPaid);
    const change   = Number(orderData.change_amount ?? 0);
    paymentsHtml += `<hr style="margin:8px 0;border-top:1px dashed #999">
      <div style="display:flex;justify-content:space-between;font-weight:bold;padding:4px 0">
        <div>Total Rendered</div><div>₱${rendered.toFixed(2)}</div></div>
      <div style="display:flex;justify-content:space-between;font-weight:bold;padding:4px 0">
        <div>Change</div><div>₱${change.toFixed(2)}</div></div>`;
  }

  const items = (orderData.details || []).map(d =>
    `<tr>
      <td>${d.quantity}x</td>
      <td><div>${d.item_name || d.name || ''}</div><div style="font-size:11px;color:#666;">@₱${Number(d.price||0).toFixed(2)}</div></td>
      <td style="text-align:right;">₱${(Number(d.quantity||0)*Number(d.price||0)).toFixed(2)}</td>
    </tr>`
  ).join('');

  const html = `
  <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div style="max-width:400px;margin:0 auto;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1.4;padding:16px;">
            <div class="text-center">
              <img src="/images/logo-default.png" width="60" height="60" alt="">
              <div class="d-flex flex-column small">
                <span class="fw-bold">${branch.name||''}</span>
                <span>${branch.address||''}</span>
                ${branch.permit_number ? `<span>Permit #: ${branch.permit_number}</span>` : ''}
              </div>
              <h6 class="fw-bold mt-2 mb-1">OFFICIAL RECEIPT</h6>
              <div>OR #: ${String(orderData.id).padStart(8,'0')}</div>
              <div>TBL: ${orderData.table_no||'—'} | Pax: ${orderData.number_pax||'—'}</div>
            </div>
            <table style="width:100%;font-size:14px;border-collapse:collapse;margin-top:10px;">
              <thead><tr>
                <th style="text-align:left;width:10%">QTY</th>
                <th style="text-align:left;width:60%">DESCRIPTION</th>
                <th style="text-align:right;width:30%">AMOUNT</th>
              </tr></thead>
              <tbody>${items}</tbody>
            </table>
            <hr style="margin:8px 0;border-top:1px dashed #999">
            <div style="display:flex;justify-content:space-between;">
              <span>Gross</span><span>₱${gross.toFixed(2)}</span></div>
            <div style="display:flex;justify-content:space-between;font-weight:bold;font-size:15px;">
              <span>TOTAL</span><span>₱${Number(orderData.total_charge||gross).toFixed(2)}</span></div>
            ${paymentsHtml}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
        </div>
      </div>
    </div>
  </div>`;

  document.body.insertAdjacentHTML('beforeend', html);
  const modalEl = document.getElementById(modalId);
  modalEl.addEventListener('hidden.bs.modal', function () { modalEl.remove(); });
  new bootstrap.Modal(modalEl).show();
};
</script>

{{-- Serving-tab layout canvas --}}
<script>
var _servingOrders = [];

function _buildOrdersMap() {
  const map = {};
  (_servingOrders || []).forEach(o => { if (o.table_no) map[o.table_no] = o; });
  return map;
}

function _onOccupiedClick(order) {
  if (!order || !document.getElementById('layoutOrderDetailModal')) return;
  const header = document.getElementById('lodm-header');
  const details = document.getElementById('lodm-details');
  const gross = (order.details || []).reduce((s, d) => s + Number(d.price || 0) * Number(d.quantity || 0), 0);
  if (header) header.innerHTML = `
    <div class="col-md-3"><strong>Order #${order.id}</strong></div>
    <div class="col-md-3"><span class="text-muted">Table</span> ${order.table_no || 'N/A'}</div>
    <div class="col-md-3"><span class="text-muted">Waiter</span> ${order.user_name || 'N/A'}</div>
    <div class="col-md-3"><span class="text-muted">Pax</span> ${order.number_pax || 'N/A'}</div>
    <div class="col-md-3 mt-2"><span class="text-muted">Type</span> ${order.order_type || 'N/A'}</div>
    <div class="col-md-3 mt-2"><span class="text-muted">Amount</span> <strong>₱${gross.toFixed(2)}</strong></div>`;
  const rows = (order.details || []).map(d => `
    <tr>
      <td style="padding:8px 10px;">${d.code || ''}</td>
      <td style="padding:8px 10px;">${d.item_name || ''}</td>
      <td style="padding:8px 10px;">${d.quantity}</td>
      <td style="padding:8px 10px;">₱${Number(d.price || 0).toFixed(2)}</td>
      <td style="padding:8px 10px;"><span class="badge badge-info">${d.status || ''}</span></td>
    </tr>`).join('');
  if (details) details.innerHTML = rows.length ? `
    <div style="max-height:260px;overflow-y:auto;border:1px solid #ddd;border-radius:6px;">
      <table style="width:100%;border-collapse:collapse;font-size:14px;">
        <thead style="border-bottom:1px solid #ccc;background:#e9e9e9;position:sticky;top:0;">
          <tr><th style="padding:8px 10px;">SKU</th><th style="padding:8px 10px;">Product</th><th style="padding:8px 10px;">Qty</th><th style="padding:8px 10px;">Amount</th><th style="padding:8px 10px;">Status</th></tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    </div>` : '<p class="text-muted mb-0">No items found.</p>';
  const editBtn = document.getElementById('lodm-edit-btn');
  if (editBtn) editBtn.href = '/orders/' + order.id + '/edit';
  const billBtn = document.getElementById('lodm-billout-btn');
  if (billBtn) billBtn.onclick = () => {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('layoutOrderDetailModal')).hide();
    if (window.__vueApp) window.__vueApp.openBillOut(order);
  };
  bootstrap.Modal.getOrCreateInstance(document.getElementById('layoutOrderDetailModal')).show();
}

async function _loadLayoutList() {
  const select = document.getElementById('layoutSelect');
  if (!select || select.dataset.loaded) return;
  try {
    const res = await fetch('{{ route("table-layouts.list") }}');
    const data = await res.json();
    select.dataset.loaded = '1';
    (Array.isArray(data) ? data : []).forEach(l => {
      const opt = document.createElement('option');
      opt.value = l.id; opt.textContent = l.name;
      select.appendChild(opt);
    });
    if (Array.isArray(data) && data.length) {
      select.value = data[0].id;
      loadSelectedLayout();
    }
  } catch (e) { console.error(e); }
}
window._loadLayoutList = _loadLayoutList;

async function loadSelectedLayout() {
  const id = document.getElementById('layoutSelect')?.value;
  if (!id) return;
  try {
    const res = await fetch(`{{ url('settings/table-layouts') }}/${id}`);
    const data = await res.json();
    _renderLayout(data.data || data);
  } catch (e) { console.error(e); }
}

let _currentLayoutData = null;
function _renderLayout(data) {
  _currentLayoutData = data;
  const floors = (data && data.floors) ? data.floors : {};
  const ids = Object.keys(floors).sort();
  const floorsEl = document.getElementById('layout-floors');
  if (floorsEl) {
    floorsEl.innerHTML = '';
    floorsEl.style.display = ids.length > 1 ? '' : 'none';
    ids.forEach(fid => {
      const btn = document.createElement('button');
      btn.type = 'button'; btn.textContent = 'Floor ' + fid;
      btn.dataset.floor = fid;
      btn.style.cssText = 'padding:5px 16px;border-radius:6px;border:1px solid #ccc;font-size:14px;cursor:pointer;background:#fff;color:#333;margin-right:8px;';
      btn.addEventListener('click', () => _switchFloor(fid));
      floorsEl.appendChild(btn);
    });
  }
  if (ids[0]) _switchFloor(ids[0]);
}

var _currentFloorId = null;
window._refreshLayoutOccupancy = function() {
  if (_currentFloorId !== null) _switchFloor(_currentFloorId);
};

function _switchFloor(floorId) {
  _currentFloorId = String(floorId);
  document.querySelectorAll('#layout-floors button').forEach(btn => {
    btn.style.background  = btn.dataset.floor === String(floorId) ? '#ff630f' : '#fff';
    btn.style.color       = btn.dataset.floor === String(floorId) ? '#fff'    : '#333';
    btn.style.borderColor = btn.dataset.floor === String(floorId) ? '#ff630f' : '#ccc';
  });
  const canvas = document.getElementById('layout-canvas');
  const floors = (_currentLayoutData && _currentLayoutData.floors) ? _currentLayoutData.floors : {};
  const items  = floors[String(floorId)] || [];
  if (typeof renderFloorItems === 'function') {
    renderFloorItems(canvas, items, _buildOrdersMap(), _onOccupiedClick, _onAvailableClick);
  }
}

function _onAvailableClick(tableNo) {
  window._pendingTableNo = tableNo;
  new bootstrap.Modal(document.getElementById('orderTypeModal')).show();
}

document.getElementById('orderTypeModal').addEventListener('hidden.bs.modal', function () {
  window._pendingTableNo = null;
});
</script>

{{-- Layout order detail modal (serving tab) --}}
<div class="modal fade" id="layoutOrderDetailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3 g-2" id="lodm-header"></div>
        <div id="lodm-details"></div>
      </div>
      <div class="modal-footer">
        <button id="lodm-billout-btn" type="button" class="btn btn-warning btn-sm">Bill Out</button>
        <a id="lodm-edit-btn" href="#" class="btn btn-primary btn-sm">Edit Order</a>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@include('settings.table_layouts._canvas_viewer')
@endsection
