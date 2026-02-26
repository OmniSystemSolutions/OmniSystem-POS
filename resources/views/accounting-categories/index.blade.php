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

        {{-- CATEGORY + SUB CATEGORY LIST --}}
        <div class="row">

            {{-- CATEGORY LIST --}}
            <div class="col-md-6 text-center">
                <label class="font-weight-bold">Category</label>

                <ul id="categoryList" class="list-group mx-auto" style="max-width:380px;">
                    @foreach ($categoryOptions as $option)
                    <li class="list-group-item category-item"
                        data-id="{{ $option->id }}"
                        data-category-id="{{ $option->id }}"
                        onclick="selectCategory({{ $option->id }})">

                        <span class="category-label">
                            @if($option->account_code)
                                {{ $option->account_code }} – {{ ucfirst($option->category) }}
                            @else
                                {{ ucfirst($option->category) }}
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

                <ul id="subCategoryList" class="list-group mx-auto" style="max-width:380px;">
                    {{-- Loop categories then their sub categories --}}
                    @foreach ($categoryOptions as $option)
                        @foreach ($option->activeSubCategories as $sub)
                        <li class="list-group-item sub-item d-none"
                            data-category-id="{{ $option->id }}"
                            data-id="{{ $sub->id }}">

                            @if($sub->account_code)
                                {{ $sub->account_code }} – {{ ucfirst($sub->sub_category) }}
                            @else
                                {{ ucfirst($sub->sub_category) }}
                            @endif

                            <button class="btn btn-sm btn-danger float-right"
                                    onclick="event.stopPropagation(); removeSubCategory({{ $sub->id }});">
                                -
                            </button>
                        </li>
                        @endforeach
                    @endforeach
                </ul>

                <button class="btn btn-outline-success btn-sm mt-3" onclick="toggleSubCategoryForm()">
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
                        <input type="text" id="new_category_name" class="form-control" placeholder="Enter name">
                        <div class="invalid-feedback" id="err_new_category_name"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Account Code *</label>
                        <input type="text" id="new_category_code" class="form-control" placeholder="e.g. 1000">
                        <div class="invalid-feedback" id="err_new_category_code"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button type="button" onclick="saveNewCategory()" class="btn btn-success px-4 mr-3">Save</button>
                <button type="button" onclick="toggleCategoryForm()" class="btn btn-danger px-4">Cancel</button>
            </div>
        </div>

        {{-- ADD SUB CATEGORY FORM --}}
        <div id="newSubCategoryForm"
             class="border rounded p-4 mt-4 bg-white shadow-sm"
             style="display:none; max-width:550px; margin:auto;">

            <h4 class="text-center mb-3">Add Type</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Type Name *</label>
                        <input type="text" id="new_sub_name" class="form-control" placeholder="Enter type name">
                        <div class="invalid-feedback" id="err_new_sub_name"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Account Code *</label>
                        <input type="text" id="new_sub_code" class="form-control" placeholder="e.g. 100">
                        <div class="invalid-feedback" id="err_new_sub_code"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button type="button" onclick="saveNewSubCategory()" class="btn btn-success px-4 mr-3">Save</button>
                <button type="button" onclick="toggleSubCategoryForm()" class="btn btn-danger px-4">Cancel</button>
            </div>
        </div>

    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let selectedCategoryId = null;

// ─────────────────────────────────────────────
// SELECT CATEGORY → SHOW ITS SUB CATEGORIES
// ─────────────────────────────────────────────
function selectCategory(categoryId) {
    selectedCategoryId = categoryId;

    document.querySelectorAll('.category-item').forEach(i => {
        const isActive = parseInt(i.dataset.categoryId) === categoryId;
        i.classList.toggle('active', isActive);

        const btn = i.querySelector('.remove-category-btn');
        if (btn) btn.style.display = isActive ? 'inline-block' : 'none';
    });

    updateSubCategoryList(categoryId);
}

function updateSubCategoryList(categoryId) {
    document.querySelectorAll('.sub-item').forEach(i => {
        i.classList.toggle('d-none', parseInt(i.dataset.categoryId) !== categoryId);
    });
}

// ─────────────────────────────────────────────
// TOGGLE FORMS
// ─────────────────────────────────────────────
function toggleCategoryForm() {
    const form = document.getElementById('newCategoryForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    document.getElementById('new_category_name').value = '';
    document.getElementById('new_category_code').value = '';
    clearError('new_category_name');
    clearError('new_category_code');
}

function toggleSubCategoryForm() {
    if (!selectedCategoryId) {
        Swal.fire('Select a Category', 'Please click a category before adding a sub category.', 'warning');
        return;
    }
    const form = document.getElementById('newSubCategoryForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    document.getElementById('new_sub_name').value = '';
    document.getElementById('new_sub_code').value = '';
    clearError('new_sub_name');
    clearError('new_sub_code');
}

// ─────────────────────────────────────────────
// SAVE CATEGORY
// ─────────────────────────────────────────────
async function saveNewCategory() {
    const name = document.getElementById('new_category_name').value.trim();
    const code = document.getElementById('new_category_code').value.trim();

    clearError('new_category_name');
    clearError('new_category_code');

    let valid = true;
    if (!name) { setError('new_category_name', 'Category name is required.'); valid = false; }
    if (!code) { setError('new_category_code', 'Account code is required.');  valid = false; }
    if (!valid) return;

    try {
        const res  = await fetchPost("{{ route('accounting-categories.category.add') }}", {
            name, account_code: code
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
            return;
        }

        // Append to category list
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'category-item');
        li.dataset.id         = data.data.id;
        li.dataset.categoryId = data.data.id;
        li.innerHTML = `
            <span class="category-label">${data.data.label}</span>
            <button class="btn btn-sm btn-danger float-right remove-category-btn"
                    style="display:none;"
                    onclick="event.stopPropagation(); removeCategory(${data.data.id});">-</button>
        `;
        li.onclick = () => selectCategory(data.data.id);
        document.getElementById('categoryList').appendChild(li);

        selectCategory(data.data.id);
        toggleCategoryForm();
        Swal.fire('Success', `${name} added successfully!`, 'success');

    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// SAVE SUB CATEGORY
// ─────────────────────────────────────────────
async function saveNewSubCategory() {
    const name = document.getElementById('new_sub_name').value.trim();
    const code = document.getElementById('new_sub_code').value.trim();

    clearError('new_sub_name');
    clearError('new_sub_code');

    let valid = true;
    if (!name) { setError('new_sub_name', 'Type name is required.');    valid = false; }
    if (!code) { setError('new_sub_code', 'Account code is required.'); valid = false; }
    if (!selectedCategoryId) {
        Swal.fire('Select a Category', 'Please select a category first.', 'warning');
        return;
    }
    if (!valid) return;

    try {
        const res  = await fetchPost("{{ route('accounting-categories.sub-category.add') }}", {
            accounting_category_id: selectedCategoryId,
            name,
            account_code: code
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
            return;
        }

        // Append to sub category list
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'sub-item');
        li.dataset.categoryId = selectedCategoryId;
        li.dataset.id         = data.data.id;
        li.innerHTML = `
            ${data.data.label}
            <button class="btn btn-sm btn-danger float-right"
                    onclick="event.stopPropagation(); removeSubCategory(${data.data.id});">-</button>
        `;
        document.getElementById('subCategoryList').appendChild(li);

        updateSubCategoryList(selectedCategoryId);
        toggleSubCategoryForm();
        Swal.fire('Success', `${name} added successfully!`, 'success');

    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// REMOVE CATEGORY
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
        const url  = "{{ route('accounting-categories.destroy', ':id') }}".replace(':id', id);
        const res  = await fetchDelete(url);
        const data = await res.json().catch(() => null);

        if (!res.ok || !data?.success) {
            Swal.fire('Error', data?.message || 'Failed to remove.', 'error');
            return;
        }

        // Remove category row
        document.querySelectorAll(`.category-item[data-id="${id}"]`).forEach(el => el.remove());
        // Remove all its sub category rows
        document.querySelectorAll(`.sub-item[data-category-id="${id}"]`).forEach(el => el.remove());

        selectedCategoryId = null;
        Swal.fire('Deleted', 'Category removed.', 'success');

    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// REMOVE SUB CATEGORY
// ─────────────────────────────────────────────
async function removeSubCategory(id) {
    const result = await Swal.fire({
        title: 'Remove Sub Category?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
    });
    if (!result.isConfirmed) return;

    try {
        const url  = "{{ route('accounting-categories.sub-category.destroy', ':id') }}".replace(':id', id);
        const res  = await fetchDelete(url);
        const data = await res.json().catch(() => null);

        if (!res.ok || !data?.success) {
            Swal.fire('Error', data?.message || 'Could not remove.', 'error');
            return;
        }

        document.querySelector(`.sub-item[data-id="${id}"]`)?.remove();
        Swal.fire('Deleted', 'Sub category removed.', 'success');

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
// INIT — auto-select first category on load
// ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const first = document.querySelector('.category-item');
    if (first) selectCategory(parseInt(first.dataset.categoryId));
});
</script>

<style>
.category-item {
    cursor: pointer;
    transition: background-color 0.15s;
    min-height: 42px;
}
.category-item:hover {
    background-color: #f8f9fa;
}
.category-item.active {
    background-color: #fff !important;
    border: 2px solid #e74c3c !important;
    font-weight: normal !important;
    color: #333 !important;
}
.category-item .category-label {
    display: inline-block;
    line-height: 1.5;
}
</style>

@endsection