@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">

        @php
            $isEdit = isset($role);
        @endphp

        <form method="POST"
              action="{{ $isEdit 
                        ? route('permissions.update', $role->id) 
                        : route('permissions.store') }}">

            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <label>Permission *</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter Permission Name"
                           value="{{ old('name', $isEdit ? $role->name : '') }}"
                           required>
                </div>

                <div class="col-md-12 mt-3">
                    <label>Permission Description</label>
                    <textarea name="description"
                              class="form-control"
                              placeholder="Enter Permission Description">{{ old('description', $isEdit ? $role->description : '') }}</textarea>
                </div>
            </div>

            <hr>
            <label>Permissions *</label>

            @foreach($permissions->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       id="perm_{{ $permission->id }}"
                                       class="custom-control-input"
                                       {{ $isEdit && $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}>

                                <label class="custom-control-label"
                                       for="perm_{{ $permission->id }}">
                                    <strong>{{ ucfirst(str_replace('view ', '', $permission->name)) }}</strong>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <button type="button" id="submitBtn" class="btn btn-primary mt-3">
                <i class="i-Yes me-2 font-weight-bold"></i>
                {{ $isEdit ? 'Update' : 'Submit' }}
            </button>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('submitBtn').addEventListener('click', function () {

    Swal.fire({
        title: '{{ $isEdit ? "Update Role?" : "Create Role?" }}',
        text: "Please confirm before proceeding.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!'
    }).then((result) => {
        if (result.isConfirmed) {
            // ✅ Show success alert
            Swal.fire({
                title: 'Success!',
                text: '{{ $isEdit ? "Role updated successfully." : "Role created successfully." }}',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Submit the form after success alert
                this.closest('form').submit();
            });
        }
    });

});
</script>
@endsection

