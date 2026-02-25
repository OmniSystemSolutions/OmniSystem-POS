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
                        data-category="{{ $option->category }}"
                        onclick="selectCategory('{{ $option->category }}')">

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

                <ul id="typeList" class="list-group mx-auto" style="max-width:380px;">
                    @foreach ($typesByCategory as $category => $types)
                        @foreach ($types as $item)
                        <li class="list-group-item type-item d-none"
                            data-category="{{ $category }}"
                            data-id="{{ $item->id }}">

                            {{ $item->account_code ? $item->account_code . ' – ' : '' }}{{ ucfirst($item->type) }}

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

        {{-- ADD TYPE FORM --}}
        <div id="newTypeForm"
             class="border rounded p-4 mt-4 bg-white shadow-sm"
             style="display:none; max-width:550px; margin:auto;">

            <h4 class="text-center mb-3">Add Type</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Type Name *</label>
                        <input type="text" id="new_type_name" class="form-control" placeholder="Enter type name">
                        <div class="invalid-feedback" id="err_new_type_name"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Account Code *</label>
                        <input type="text" id="new_type_code" class="form-control" placeholder="e.g. 100">
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
// SELECT CATEGORY → SHOW ITS TYPES
// ─────────────────────────────────────────────
function selectCategory(category) {
    document.querySelectorAll('.category-item').forEach(i => {
        const isActive = i.dataset.category === category;
        i.classList.toggle('active', isActive);

        const btn = i.querySelector('.remove-category-btn');
        if (btn) btn.style.display = isActive ? 'inline-block' : 'none';
    });

    updateTypeList(category);
}

function updateTypeList(category) {
    document.querySelectorAll('.type-item').forEach(i => {
        i.classList.toggle('d-none', i.dataset.category !== category);
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

function toggleTypeForm() {
    const activeCategory = document.querySelector('.category-item.active');
    if (!activeCategory) {
        Swal.fire('Select a Category', 'Please click a category before adding a sub category.', 'warning');
        return;
    }

    const form = document.getElementById('newTypeForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    document.getElementById('new_type_name').value = '';
    document.getElementById('new_type_code').value = '';
    clearError('new_type_name');
    clearError('new_type_code');
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

        // Append to DOM
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'category-item');
        li.dataset.id       = data.data.id;
        li.dataset.category = data.data.name;
        li.innerHTML = `
            <span class="category-label">${data.data.label}</span>
            <button class="btn btn-sm btn-danger float-right remove-category-btn"
                    style="display:none;"
                    onclick="event.stopPropagation(); removeCategory(${data.data.id});">-</button>
        `;
        li.onclick = () => selectCategory(data.data.name);
        document.getElementById('categoryList').appendChild(li);

        // Auto-select the new category
        selectCategory(data.data.name);

        toggleCategoryForm();
        Swal.fire('Success', `${name} added successfully!`, 'success');

    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
    }
}

// ─────────────────────────────────────────────
// SAVE TYPE
// ─────────────────────────────────────────────
async function saveNewType() {
    const name     = document.getElementById('new_type_name').value.trim();
    const code     = document.getElementById('new_type_code').value.trim();
    const active   = document.querySelector('.category-item.active');
    const category = active ? active.dataset.category : null;

    clearError('new_type_name');
    clearError('new_type_code');

    let valid = true;
    if (!name) { setError('new_type_name', 'Type name is required.');    valid = false; }
    if (!code) { setError('new_type_code', 'Account code is required.'); valid = false; }
    if (!category) {
        Swal.fire('Select a Category', 'Please select a category first.', 'warning');
        return;
    }
    if (!valid) return;

    try {
        const res  = await fetchPost("{{ route('accounting-categories.type.add') }}", {
            category, name, account_code: code
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
            return;
        }

        // Append to DOM
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'type-item');
        li.dataset.category = category;
        li.dataset.id       = data.data.id;
        li.innerHTML = `
            ${data.data.label}
            <button class="btn btn-sm btn-danger float-right"
                    onclick="event.stopPropagation(); removeType(${data.data.id});">-</button>
        `;
        document.getElementById('typeList').appendChild(li);

        updateTypeList(category);
        toggleTypeForm();
        Swal.fire('Success', `${name} added successfully!`, 'success');

    } catch (err) {
        Swal.fire('Error', 'Something went wrong.', 'error');
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
        const url  = "{{ route('accounting-categories.destroy', ':id') }}".replace(':id', id);
        const res  = await fetchDelete(url);
        const data = await res.json().catch(() => null);

        if (!res.ok || !data?.success) {
            Swal.fire('Error', data?.message || 'Failed to remove.', 'error');
            return;
        }

        document.querySelectorAll(`.category-item[data-id="${id}"]`).forEach(el => el.remove());
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
        const url = "{{ route('accounting-categories.type.destroy', ':id') }}".replace(':id', id);
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
// INIT — auto-select first category on load
// ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const first = document.querySelector('.category-item');
    if (first) selectCategory(first.dataset.category);
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