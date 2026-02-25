@extends('layouts.app')
@section('content')

<div class="main-content">
    <div>
        <div class="breadcrumb">
            <h1 class="mr-3">Accounting Categories</h1>
            <ul>
                <li><a href="">Accounting Settings</a></li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>

    <div class="container">

        {{-- MODE TABS (replaces dropdown) --}}
  {{-- MODE DROPDOWN --}}
<div class="row mb-4">
    <div class="col-md-4 mx-auto">
        <select id="mode" class="form-control" onchange="switchMode(this.value)">
            <option value="payable">Accounts Payables</option>
            <option value="receivable">Accounts Receivables</option>
        </select>
    </div>
</div>

        {{-- CATEGORY + SUB CATEGORY LIST --}}
        <div class="row">

            {{-- CATEGORY LIST --}}
            <div class="col-md-6 text-center">
                <label class="font-weight-bold">Category</label>

                <ul id="categoryList" class="list-group mx-auto" style="max-width:380px;">

                    {{-- PAYABLE CATEGORIES --}}
                    @foreach ($categoryPayableOptions as $option)
                    <li class="list-group-item category-item payable-item d-none"
                        data-id="{{ $option->id }}"
                        data-category="{{ $option->category_payable }}"
                        onclick="selectCategory('{{ $option->category_payable }}')">

                        <span class="category-label">
                            @if($option->account_code_payable)
                                {{ $option->account_code_payable }} – {{ ucfirst($option->category_payable) }}
                            @else
                                {{ ucfirst($option->category_payable) }}
                            @endif
                        </span>

                        <button class="btn btn-sm btn-danger float-right remove-category-btn"
                                style="display:none;"
                                onclick="event.stopPropagation(); removeCategory({{ $option->id }});">
                            -
                        </button>
                    </li>
                    @endforeach

                    {{-- RECEIVABLE CATEGORIES --}}
                    @foreach ($categoryReceivableOptions as $option)
                    <li class="list-group-item category-item receivable-item d-none"
                        data-id="{{ $option->id }}"
                        data-category="{{ $option->category_receivable }}"
                        onclick="selectCategory('{{ $option->category_receivable }}')">

                        <span class="category-label">
                            @if($option->account_code_receivable)
                                {{ $option->account_code_receivable }} – {{ ucfirst($option->category_receivable) }}
                            @else
                                {{ ucfirst($option->category_receivable) }}
                            @endif
                        </span>

                        <button class="btn btn-sm btn-danger float-right remove-category-btn"
                                style="display:none;"
                                onclick="event.stopPropagation(); removeCategory({{ $option->id }});">
                            -
                        </button>
                    </li>
                    @endforeach

                </ul>

                <button class="btn btn-outline-success btn-sm mt-3" onclick="toggleCategoryForm()">
                    <i class="i-Add"></i> Add Category
                </button>
            </div>

            {{-- SUB CATEGORY LIST --}}
            <div class="col-md-6 text-center">
                <label class="font-weight-bold">Sub Category</label>

                <ul id="typeList" class="list-group mx-auto" style="max-width:380px;">

                    {{-- PAYABLE TYPES --}}
                    @foreach ($typesByCategoryPayable as $category => $types)
                        @foreach ($types as $item)
                        <li class="list-group-item type-item payable-type d-none"
                            data-category="{{ $category }}"
                            data-id="{{ $item->id }}">

                            {{ $item->account_code_payable ? $item->account_code_payable . ' – ' : '' }}{{ ucfirst($item->type_payable) }}

                            <button class="btn btn-sm btn-danger float-right"
                                    onclick="event.stopPropagation(); removeType({{ $item->id }});">
                                -
                            </button>
                        </li>
                        @endforeach
                    @endforeach

                    {{-- RECEIVABLE TYPES --}}
                    @foreach ($typesByCategoryReceivable as $category => $types)
                        @foreach ($types as $item)
                        <li class="list-group-item type-item receivable-type d-none"
                            data-category="{{ $category }}"
                            data-id="{{ $item->id }}">

                            {{ $item->account_code_receivable ? $item->account_code_receivable . ' – ' : '' }}{{ ucfirst($item->type_receivable) }}

                            <button class="btn btn-sm btn-danger float-right"
                                    onclick="event.stopPropagation(); removeType({{ $item->id }});">
                                -
                            </button>
                        </li>
                        @endforeach
                    @endforeach

                </ul>

                <button class="btn btn-outline-success btn-sm mt-3" onclick="toggleTypeForm()">
                    <i class="i-Add"></i> Add Type
                </button>
            </div>

        </div>

        {{-- ADD CATEGORY FORM --}}
        <div id="newCategoryForm"
             class="border rounded p-4 mt-4 bg-white shadow-sm"
             style="display:none; max-width:550px; margin:auto;">

            <h4 class="text-center mb-3">Add Category</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Category Name *</label>
                        <input type="text"
                               id="new_category_name"
                               class="form-control"
                               placeholder="Enter name">
                        <div class="invalid-feedback" id="err_new_category_name"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Account Code *</label>
                        <input type="text"
                               id="new_category_code"
                               class="form-control"
                               placeholder="Enter code (e.g. 1000)">
                        <div class="invalid-feedback" id="err_new_category_code"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button type="button" onclick="saveNewCategory()" class="btn btn-success px-4 mr-3">Save</button>
                <button type="button" onclick="toggleCategoryForm()" class="btn btn-danger px-4">Cancel</button>
            </div>
        </div>

        {{-- ADD TYPE (SUB CATEGORY) FORM --}}
        <div id="newTypeForm"
             class="border rounded p-4 mt-4 bg-white shadow-sm"
             style="display:none; max-width:550px; margin:auto;">

            <h4 class="text-center mb-3">Add Type</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Type Name *</label>
                        <input type="text"
                               id="new_type_name"
                               class="form-control"
                               placeholder="Enter type name">
                        <div class="invalid-feedback" id="err_new_type_name"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Account Code *</label>
                        <input type="text"
                               id="new_type_code"
                               class="form-control"
                               placeholder="Enter code (e.g. 100)">
                        <div class="invalid-feedback" id="err_new_type_code"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button type="button" onclick="saveNewType()" class="btn btn-success px-4 mr-3">Save</button>
                <button type="button" onclick="toggleTypeForm()" class="btn btn-danger px-4">Cancel</button>
            </div>
        </div>

    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// ─────────────────────────────────────────────
// STATE
// ─────────────────────────────────────────────
let currentMode = 'payable';

// ─────────────────────────────────────────────
// MODE SWITCH (replaces dropdown)
// ─────────────────────────────────────────────
function switchMode(mode) {
    currentMode = mode;
    updateCategoryList();

    document.getElementById('newCategoryForm').style.display = 'none';
    document.getElementById('newTypeForm').style.display = 'none';
}

// INIT — read from dropdown on load
document.addEventListener('DOMContentLoaded', () => {
    switchMode(document.getElementById('mode').value);
});

// ─────────────────────────────────────────────
// CATEGORY LIST
// ─────────────────────────────────────────────
function updateCategoryList() {
    const items = document.querySelectorAll('.category-item');

    items.forEach(i => {
        const visible = currentMode === 'payable'
            ? i.classList.contains('payable-item')
            : i.classList.contains('receivable-item');
        i.classList.toggle('d-none', !visible);
    });

    // Auto-select first visible category
    const first = Array.from(items).find(i => !i.classList.contains('d-none'));
    if (first) {
        selectCategory(first.dataset.category);
    } else {
        // No categories yet — clear type list
        updateTypeList(null);
    }
}

// ─────────────────────────────────────────────
// SELECT CATEGORY → SHOW ITS TYPES
// ─────────────────────────────────────────────
function selectCategory(category) {
    document.querySelectorAll('.category-item').forEach(i => {
        const isActive = i.dataset.category === category
            && !i.classList.contains('d-none'); // only active-mode items

        i.classList.toggle('active', isActive);

        const btn = i.querySelector('.remove-category-btn');
        if (btn) btn.style.display = isActive ? 'inline-block' : 'none';
    });

    updateTypeList(category);
}

function updateTypeList(category) {
    const items = document.querySelectorAll('.type-item');

    items.forEach(i => {
        const correctMode = currentMode === 'payable'
            ? i.classList.contains('payable-type')
            : i.classList.contains('receivable-type');

        const visible = correctMode && i.dataset.category === category;
        i.classList.toggle('d-none', !visible);
    });
}

// ─────────────────────────────────────────────
// TOGGLE FORMS
// ─────────────────────────────────────────────
function toggleCategoryForm() {
    const form = document.getElementById('newCategoryForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';

    // Reset fields
    document.getElementById('new_category_name').value = '';
    document.getElementById('new_category_code').value = '';
    clearError('new_category_name');
    clearError('new_category_code');
}

function toggleTypeForm() {
    const activeCategory = document.querySelector('.category-item.active');

    if (!activeCategory) {
        Swal.fire('Select a Category', 'Please click a category before adding a sub category.', 'warning');
        return;
    }

    const form = document.getElementById('newTypeForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';

    // Reset fields
    document.getElementById('new_type_name').value = '';
    document.getElementById('new_type_code').value = '';
    clearError('new_type_name');
    clearError('new_type_code');
}

// ─────────────────────────────────────────────
// SAVE CATEGORY
// ─────────────────────────────────────────────
async function saveNewCategory() {
    const nameInput = document.getElementById('new_category_name');
    const codeInput = document.getElementById('new_category_code');
    const name = nameInput.value.trim();
    const code = codeInput.value.trim();

    clearError('new_category_name');
    clearError('new_category_code');

    let valid = true;

    if (!name) {
        setError('new_category_name', 'Category name is required.');
        valid = false;
    }
    if (!code) {
        setError('new_category_code', 'Account code is required.');
        valid = false;
    }
    if (!valid) return;

    try {
        const url = currentMode === 'payable'
            ? "{{ route('accounting-categories.accounting-category.add-payable') }}"
            : "{{ route('accounting-categories.accounting-category.add-receivable') }}";

        const payload = currentMode === 'payable'
            ? { category_payable: name, account_code: code }
            : { name: name, account_code: code };

        const res = await fetchPost(url, payload);
        const data = await res.json();

        if (!res.ok || !data.success) {
            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
            return;
        }

        // ── Append to DOM instantly ──
        const list = document.getElementById('categoryList');
        const li   = document.createElement('li');

        li.classList.add('list-group-item', 'category-item',
            currentMode === 'payable' ? 'payable-item' : 'receivable-item');

        li.dataset.id       = data.data.id;
        li.dataset.category = data.data.name;
        li.innerHTML = `
            <span class="category-label">${data.data.label}</span>
            <button class="btn btn-sm btn-danger float-right remove-category-btn"
                    style="display:none;"
                    onclick="event.stopPropagation(); removeCategory(${data.data.id});">-</button>
        `;
        li.onclick = () => selectCategory(data.data.name);

        list.appendChild(li);

        toggleCategoryForm();
        updateCategoryList();
        Swal.fire('Success', `${name} added successfully!`, 'success');

    } catch (err) {
        Swal.fire('Error', err.message || 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// SAVE TYPE (SUB CATEGORY)
// ─────────────────────────────────────────────
async function saveNewType() {
    const nameInput = document.getElementById('new_type_name');
    const codeInput = document.getElementById('new_type_code');
    const name      = nameInput.value.trim();
    const code      = codeInput.value.trim();

    const activeCategory = document.querySelector('.category-item.active');
    const category       = activeCategory ? activeCategory.dataset.category : null;

    clearError('new_type_name');
    clearError('new_type_code');

    let valid = true;

    if (!name) {
        setError('new_type_name', 'Type name is required.');
        valid = false;
    }
    if (!code) {
        setError('new_type_code', 'Account code is required.');
        valid = false;
    }
    if (!category) {
        Swal.fire('Select a Category', 'Please select a category first.', 'warning');
        return;
    }
    if (!valid) return;

    try {
        const url = currentMode === 'payable'
            ? "{{ route('accounting-categories.accounting-type.add-payable') }}"
            : "{{ route('accounting-categories.accounting-type.add-receivable') }}";

        const res  = await fetchPost(url, { category, name, account_code: code });
        const data = await res.json();

        if (!res.ok || !data.success) {
            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
            return;
        }

        // ── Append to DOM instantly ──
        const list = document.getElementById('typeList');
        const li   = document.createElement('li');

        li.classList.add('list-group-item', 'type-item',
            currentMode === 'payable' ? 'payable-type' : 'receivable-type');

        li.dataset.category = category;
        li.dataset.id       = data.data.id;
        li.innerHTML = `
            ${data.data.label}
            <button class="btn btn-sm btn-danger float-right"
                    onclick="event.stopPropagation(); removeType(${data.data.id});">-</button>
        `;

        list.appendChild(li);

        toggleTypeForm();
        updateTypeList(category);
        Swal.fire('Success', `${name} added successfully!`, 'success');

    } catch (err) {
        Swal.fire('Error', err.message || 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// REMOVE
// ─────────────────────────────────────────────
async function removeCategory(id) {
    const result = await Swal.fire({
        title: 'Remove Category?',
        text: 'This will also delete all sub categories under it.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
    });

    if (!result.isConfirmed) return;

    try {
        const url = "{{ route('accounting-categories.destroy', ':id') }}"
            .replace(':id', id);

        const res  = await fetchDelete(url);
        const data = await res.json().catch(() => null);

        if (!res.ok || !data?.success) {
            Swal.fire('Error', data?.message || 'Failed to remove.', 'error');
            return;
        }

        // Remove from DOM
        document.querySelectorAll(`.category-item[data-id="${id}"]`)
            .forEach(el => el.remove());

        // Clear type list
        updateTypeList(null);

        Swal.fire('Deleted', 'Category removed.', 'success');

    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
    }
}

async function removeType(id) {
    const result = await Swal.fire({
        title: 'Remove Sub Category?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
    });

    if (!result.isConfirmed) return;

    try {
        const url = "{{ route('accounting-categories.accounting-type.destroy', ':id') }}"
            .replace(':id', id);

        const res = await fetchDelete(url);

        if (res.ok) {
            document.querySelector(`.type-item[data-id="${id}"]`)?.remove();
            Swal.fire('Deleted', 'Sub category removed.', 'success');
        } else {
            Swal.fire('Error', 'Could not remove.', 'error');
        }
    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────
function fetchPost(url, payload) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    });
}

function fetchDelete(url) {
    return fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    });
}

function setError(fieldId, message) {
    const input = document.getElementById(fieldId);
    const err   = document.getElementById('err_' + fieldId);
    if (input) input.classList.add('is-invalid');
    if (err)   err.innerText = message;
}

function clearError(fieldId) {
    const input = document.getElementById(fieldId);
    const err   = document.getElementById('err_' + fieldId);
    if (input) input.classList.remove('is-invalid');
    if (err)   err.innerText = '';
}

// ─────────────────────────────────────────────
// INIT
// ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    switchMode('payable');
});
</script>

<style>
.category-item {
    cursor: pointer;
    transition: background-color 0.15s;
    position: relative;        /* add this */
    min-height: 42px;          /* add this */
}
.category-item:hover {
    background-color: #f8f9fa;
}
.category-item.active {
    background-color: #fff !important;   /* was transparent — change to white */
    border: 2px solid #e74c3c !important;
    font-weight: normal !important;
    color: #333 !important;              /* add this */
}
.category-item .category-label {
    display: inline-block;     /* add this */
    line-height: 1.5;          /* add this */
}
</style>

@endsection