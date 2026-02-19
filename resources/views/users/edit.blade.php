@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-3">Edit Employee</h1>
        <ul>
            <li><a href="{{ route('users.index') }}">People</a></li>
            <li>Employees</li>
            <li>Edit</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs" id="userEditTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="access-tab" data-toggle="tab" href="#access" role="tab" aria-controls="access" aria-selected="false">Access Credentials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="work-tab" data-toggle="tab" href="#work" role="tab" aria-controls="work" aria-selected="false">Work Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="educ-tab" data-toggle="tab" href="#educ" role="tab" aria-controls="educ" aria-selected="false">Educational Background</a>
                </li>
            </ul>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="tab-content" id="userEditTabContent">
                    <!-- Basic Information -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="biometric_number">Biometric Number</label>
                                            <input type="text" name="biometric_number" id="biometric_number" class="form-control" value="{{ old('biometric_number', $user->biometric_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="id_number">ID Number</label>
                                            <input type="text" name="id_number" id="id_number" class="form-control" value="{{ old('id_number', $user->id_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="middle_name">Middle Name</label>
                                            <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ old('middle_name', $user->middle_name) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tin">TIN #</label>
                                            <input type="text" name="tin" id="tin" class="form-control" value="{{ old('tin', $user->tin) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gender_id">Gender</label>
                                            <select name="gender_id" id="gender_id" class="form-control">
                                                <option value="">-- Select Gender --</option>
                                                <option value="Male" {{ old('gender_id', $user->gender_id) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender_id', $user->gender_id) == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender_id', $user->gender_id) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="blood_type_id">Blood Type</label>
                                            <select name="blood_type_id" id="blood_type_id" class="form-control">
                                                <option value="">-- Select Blood Type --</option>
                                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                                                    <option value="{{ $type }}" {{ old('blood_type_id', $user->blood_type_id) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mobile_number">Mobile #</label>
                                            <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', $user->mobile_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phil_health_number">PhilHealth #</label>
                                            <input type="text" name="phil_health_number" id="phil_health_number" class="form-control" value="{{ old('phil_health_number', $user->phil_health_number) }}">
                                        </div>
                                    </div>
                                    <!-- PAG-IBIG and Primary Branch are rendered together in the next column -->
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pag_ibig_number">PAG-IBIG #</label>
                                                    <input type="text" name="pag_ibig_number" id="pag_ibig_number" class="form-control" value="{{ old('pag_ibig_number', $user->pag_ibig_number) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
        <label class="fw-bold">Primary Branch</label>
        <select name="branches[]" class="form-control">
            <option value="">-- Select Primary Branch --</option>
            @foreach($branches as $b)
                <?php
                    // Determine which value to compare against
                    $selectedBranchId = old('branches.0'); // after failed validation
                    if (empty($selectedBranchId)) {
                        // On initial edit load: prefer branch_id, then first pivot branch
                        $selectedBranchId = $user?->branch_id ?? $user?->branches?->first()?->id ?? '';
                    }
                ?>
                <option value="{{ $b->id }}"
                        {{ $selectedBranchId == $b->id ? 'selected' : '' }}>
                    {{ $b->name }}
                </option>
            @endforeach
        </select>
        @error('branches.0')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
        @error('branches.*')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="civil_status_id">Civil Status</label>
                                            <select name="civil_status_id" id="civil_status_id" class="form-control">
                                                <option value="">-- Select Civil Status --</option>
                                                @foreach(['Single','Married','Widowed','Separated','Divorced'] as $status)
                                                    <option value="{{ $status }}" {{ old('civil_status_id', $user->civil_status_id) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" id="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Spouse details -->
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h6 class="mb-3">Spouse Details</h6>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="spouse[name]" class="form-control" placeholder="Full Name" value="{{ old('spouse.name', $spouse->name ?? '') }}">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="date" name="spouse[date_of_birth]" class="form-control" value="{{ old('spouse.date_of_birth', $spouse->date_of_birth ?? '') }}">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="number" name="spouse[age]" class="form-control" placeholder="Age" value="{{ old('spouse.age', $spouse->age ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dependents -->
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h6 class="mb-3">Dependents (Optional)</h6>
                                        <div id="dependents-list">
                                            @if(old('dependents'))
                                                @foreach(old('dependents') as $index => $dep)
                                                    <div class="dependent-row row mb-2">
                                                        <div class="col-md-3"><input type="text" name="dependents[{{ $index }}][name]" class="form-control" value="{{ $dep['name'] ?? '' }}" placeholder="Name"></div>
                                                        <div class="col-md-2"><input type="date" name="dependents[{{ $index }}][birthdate]" class="form-control" value="{{ $dep['birthdate'] ?? '' }}"></div>
                                                        <div class="col-md-1"><input type="number" name="dependents[{{ $index }}][age]" class="form-control" value="{{ $dep['age'] ?? '' }}" placeholder="Age"></div>
                                                        <div class="col-md-3">
                                                            <select name="dependents[{{ $index }}][gender]" class="form-control">
                                                                <option value="">-- Select Gender --</option>
                                                                <option value="Male" {{ ($dep['gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                                <option value="Female" {{ ($dep['gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                                <option value="Other" {{ ($dep['gender'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select name="dependents[{{ $index }}][relationship]" class="form-control">
                                                                <option value="">-- Relationship --</option>
                                                                <option value="Son" {{ ($dep['relationship'] ?? '') == 'Son' ? 'selected' : '' }}>Son</option>
                                                                <option value="Daughter" {{ ($dep['relationship'] ?? '') == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                                                <option value="Parent" {{ ($dep['relationship'] ?? '') == 'Parent' ? 'selected' : '' }}>Parent</option>
                                                                <option value="Spouse" {{ ($dep['relationship'] ?? '') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                                                <option value="Other" {{ ($dep['relationship'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-dependent">-</button></div>
                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach($dependents as $index => $dep)
                                                    <div class="dependent-row row mb-2">
                                                        <div class="col-md-3"><input type="text" name="dependents[{{ $index }}][name]" class="form-control" value="{{ $dep->name }}" placeholder="Name"></div>
                                                        <div class="col-md-2"><input type="date" name="dependents[{{ $index }}][birthdate]" class="form-control" value="{{ $dep->birthdate }}"></div>
                                                        <div class="col-md-1"><input type="number" name="dependents[{{ $index }}][age]" class="form-control" value="{{ $dep->age }}" placeholder="Age"></div>
                                                        <div class="col-md-3">
                                                            <select name="dependents[{{ $index }}][gender]" class="form-control">
                                                                <option value="">-- Select Gender --</option>
                                                                <option value="Male" {{ $dep->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                                <option value="Female" {{ $dep->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                                <option value="Other" {{ $dep->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <select name="dependents[{{ $index }}][relationship]" class="form-control">
                                                                <option value="">-- Relationship --</option>
                                                                <option value="Son" {{ $dep->relationship == 'Son' ? 'selected' : '' }}>Son</option>
                                                                <option value="Daughter" {{ $dep->relationship == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                                                <option value="Parent" {{ $dep->relationship == 'Parent' ? 'selected' : '' }}>Parent</option>
                                                                <option value="Spouse" {{ $dep->relationship == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                                                <option value="Other" {{ $dep->relationship == 'Other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-dependent">-</button></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" id="add-dependent" class="btn btn-sm btn-outline-primary">Add dependent</button>
                                    </div>
                                </div>

                                <!-- Emergency contact -->
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h6 class="mb-3">Contact Information In Case of Emergency</h6>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="contact_person[name]" class="form-control" placeholder="Full Name" value="{{ old('contact_person.name', $contactPerson->name ?? '') }}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="contact_person[contact_number]" class="form-control" placeholder="Contact Number" value="{{ old('contact_person.contact_number', $contactPerson->contact_number ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="contact_person[address]" class="form-control" placeholder="Address" value="{{ old('contact_person.address', $contactPerson->address ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label>Photo</label>
                                    @if($user->image)
                                        <img src="{{ Storage::url($user->image) }}" alt="Current photo" class="img-thumbnail mb-2" style="max-width: 190px;">
                                    @endif
                                    <label for="image" id="drop-area" class="upload-box text-center p-3 border rounded d-block" style="cursor:pointer;">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-muted"></i>
                                        <p class="text-muted">Drag & Drop an image<br><strong>or click to select</strong></p>
                                        <input type="file" id="image" name="image" class="d-none" accept="image/*">
                                        <div id="preview-container" class="mt-3"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Access Credentials -->
                    <div class="tab-pane fade" id="access" role="tabpanel" aria-labelledby="access-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="allow_db_user" id="allow_db_user" class="form-check-input" value="1" {{ old('allow_db_user', $user->password ? true : false) ? 'checked' : '' }}>
                                    <label for="allow_db_user" class="form-check-label">Allow employee to be Database User</label>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password">New Password (leave blank to keep current)</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6>Branch Roles</h6>
                                <div id="branch-permissions-list">
                                    @if(old('branch_permissions'))
                                        @foreach(old('branch_permissions') as $i => $bp)
                                            <div class="branch-permission-row form-row align-items-center mb-2">
                                                <div class="col-md-5">
                                                    <select name="branch_permissions[{{ $i }}][branch_id]" class="form-control">
                                                        <option value="">Select branch</option>
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch->id }}" {{ ($bp['branch_id'] ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="branch_permissions[{{ $i }}][permissions][]" class="form-control" multiple>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}" {{ in_array($role->id, $bp['permissions'] ?? []) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-branch">-</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($user->branches as $i => $branch)
                                            <div class="branch-permission-row form-row align-items-center mb-2">
                                                <div class="col-md-5">
                                                    <select name="branch_permissions[{{ $i }}][branch_id]" class="form-control">
                                                        <option value="">Select branch</option>
                                                        @foreach($branches as $b)
                                                            <option value="{{ $b->id }}" {{ $branch->id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="branch_permissions[{{ $i }}][permissions][]" class="form-control" multiple>
                                                        @foreach($roles as $role)
                                                            {{-- mark selected if this role is in the user's roles for this branch --}}
                                                            <option value="{{ $role->id }}" {{ (isset($userBranchPermissions[$branch->id]) && in_array($role->id, $userBranchPermissions[$branch->id])) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-branch">-</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" id="add-branch-permission" class="btn btn-sm btn-outline-primary">Add branch</button>
                            </div>
                        </div>
                    </div>

                    <!-- Work Information -->
                    <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                        <div class="card">
                            <div class="card-body">
                                <h6>Work Informations</h6>
                                <div class="table-responsive mb-3">
                                    <table class="table table-bordered" id="workinfo-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Employment Type</th>
                                                <th>Position</th>
                                                <th>Department</th>
                                                <th>Supervisor</th>
                                                <th>Monthly Rate</th>
                                                <th>Daily Rate</th>
                                                <th>Hourly Rate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('employee_work_informations'))
                                                @foreach(old('employee_work_informations') as $wi)
                                                    <tr data-wi-index="{{ $loop->index }}">
                                                        <td>{{ $wi['hire_date'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][hire_date]" value="{{ $wi['hire_date'] }}"></td>
                                                        <td>{{ $wi['employment_status_id'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][employment_status_id]" value="{{ $wi['employment_status_id'] }}"></td>

                                                        <td>{{ $wi['designation_id'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][designation_id]" value="{{ $wi['designation_id'] }}"></td>
                                                        <td>{{ $wi['department_id'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][department_id]" value="{{ $wi['department_id'] }}"></td>
                                                        <td>{{ $wi['direct_supervisor'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][direct_supervisor]" value="{{ $wi['direct_supervisor'] }}"></td>
                                                        <td>{{ $wi['monthly_rate'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][monthly_rate]" value="{{ $wi['monthly_rate'] }}"></td>
                                                        <td>{{ $wi['daily_rate'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][daily_rate]" value="{{ $wi['daily_rate'] }}"></td>
                                                        <td>{{ $wi['hourly_rate'] ?? '' }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][hourly_rate]" value="{{ $wi['hourly_rate'] }}"></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-workinfo-row">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-danger remove-workinfo-row">Remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                @foreach($workInformations as $wi)
                                                    <tr data-wi-index="{{ $loop->index }}">
                                                        <td>{{ $wi->hire_date }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][hire_date]" value="{{ $wi->hire_date }}"></td>
                                                        <td>
                                                            {{ match($wi->employment_status_id) {
                                                                1 => 'Probationary Period',
                                                                2 => 'Regular',
                                                                3 => 'Promotion',
                                                                4 => 'Contractual',
                                                                5 => 'Resigned',
                                                                default => $wi->employment_status_id ?: '—'
                                                            } }}
                                                            <input type="hidden" name="employee_work_informations[{{ $loop->index }}][employment_status_id]" value="{{ $wi->employment_status_id }}">
                                                        </td>
                                                        <td>
                                                            {{ optional($designations->find($wi->designation_id))->name ?? $wi->designation_id ?? '—' }}
                                                            <input type="hidden" name="employee_work_informations[{{ $loop->index }}][designation_id]" value="{{ $wi->designation_id }}">
                                                        </td>

                                                        <td>
                                                            {{ optional($departments->find($wi->department_id))->name ?? $wi->department_id ?? '—' }}
                                                            <input type="hidden" name="employee_work_informations[{{ $loop->index }}][department_id]" value="{{ $wi->department_id }}">
                                                        </td>
                                                        <td>{{ $wi->direct_supervisor }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][direct_supervisor]" value="{{ $wi->direct_supervisor }}"></td>
                                                        <td>{{ $wi->monthly_rate }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][monthly_rate]" value="{{ $wi->monthly_rate }}"></td>
                                                        <td>{{ $wi->daily_rate }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][daily_rate]" value="{{ $wi->daily_rate }}"></td>
                                                        <td>{{ $wi->hourly_rate }}<input type="hidden" name="employee_work_informations[{{ $loop->index }}][hourly_rate]" value="{{ $wi->hourly_rate }}"></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-workinfo-row">Edit</button>
                                                            <button type="button" class="btn btn-sm btn-danger remove-workinfo-row">Remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" id="open-workinfo-form" class="btn btn-sm btn-outline-primary mb-3">Add Work Info</button>

                                <!-- Work info form (copied from create) -->
                                <div id="workinfo-form" style="display:none;" class="mb-3">
                                    <div class="row">
                                        <div class="col-md-3 form-group"><label>Date</label><input type="date" id="wi_hire_date" class="form-control"></div>
                                        <div class="col-md-2 form-group">
                                            <label>Employment Type</label>
                                            <select id="wi_status" class="form-control">
                                                <option value="">Select Employment Type</option>
                                                <option value="1">Probationary Period</option>
                                                <option value="2">Regular</option>
                                                <option value="3">Promotion</option>
                                                <option value="4">Contractual</option>
                                                <option value="5">Resigned</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group"><label>Position</label>
                                            <select id="wi_designation" class="form-control">
                                                <option value="">Select Position</option>
                                                @foreach($designations as $des)
                                                    <option value="{{ $des->id }}" {{ (old('wi_designation') == $des->id) || (isset($workInformations) && $workInformations->firstWhere('designation_id',$des->id)) ? 'selected' : '' }}>{{ $des->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group"><label>Department</label>
                                            <select id="wi_department" class="form-control">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $d)
                                                    <option value="{{ $d->id }}" {{ (old('wi_department') == $d->id) || (isset($workInformations) && $workInformations->firstWhere('department_id',$d->id)) ? 'selected' : '' }}>{{ $d->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                          {{-- <div class="col-md-3 form-group">
    <label>Supervisor</label>
    <select id="wi_supervisor" name="wi_supervisor" class="form-control">
        <option value="">No Supervisor / Not Applicable</option>
        @foreach($potentialSupervisors as $supervisor)
            <option value="{{ $supervisor->username }}"
                    {{ old('wi_supervisor', $workInformations->first()?->direct_supervisor ?? '') === $supervisor->username ? 'selected' : '' }}>
                {{ $supervisor->name ?? $supervisor->username }}
                <small class="text-muted">
                    ({{ $supervisor->username }} •
                    @if($latest = $supervisor->employeeWorkInformations->first())
                        {{ $latest->designation?->name ?? '—' }}
                    @else
                        (no position)
                    @endif
                    )
                </small>
            </option>
        @endforeach
    </select>
</div> --}}

<div class="col-md-3 form-group">
    <label>Supervisor</label>
    <select id="wi_supervisor" name="wi_supervisor" class="form-control">
        <option value="">Select Supervisor</option>
        
        @foreach($potentialSupervisors as $supervisor)
            @php
                $latestDesignation = $supervisor->employeeWorkInformations->first()?->designation?->name ?? '';
            @endphp
            
            <option value="{{ $supervisor->username }}"
                    data-designation="{{ strtolower($latestDesignation) }}"
                    {{ old('wi_supervisor', $workInformations->first()?->direct_supervisor ?? '') === $supervisor->username ? 'selected' : '' }}>
                {{ $supervisor->name ?? $supervisor->username }}
                <small class="text-muted">
                    ({{ $supervisor->username }} • {{ $latestDesignation ?: '—' }})
                </small>
            </option>
        @endforeach
    </select>
</div>

                                        <div class="col-md-3 form-group"><label>Monthly Rate</label><input type="number" step="0.01" id="wi_monthly_rate" class="form-control"></div>
                                        <div class="col-md-3 form-group"><label>Daily Rate</label><input type="number" step="0.01" id="wi_daily_rate" class="form-control"></div>
                                        <div class="col-md-3 form-group"><label>Hourly Rate</label><input type="number" step="0.01" id="wi_hourly_rate" class="form-control"></div>
                                    </div>
                                    <div>
                                        <button type="button" id="save-workinfo" class="btn btn-primary btn-sm">Save</button>
                                        <button type="button" id="cancel-workinfo" class="btn btn-secondary btn-sm">Cancel</button>
                                    </div>
                                </div>

                                <hr>

                                <h6>Salary Method</h6>
                                <div class="row mb-3">
                                    <div class="col-md-2 form-group">
                                        <label>Salary Method</label>
                                        <select name="salary_method[method_id]" class="form-control">
                                            <option value="">Select Method</option>
                                            @foreach($salaryMethods as $key => $label)
                                                <option value="{{ $key }}" {{ old('salary_method.method_id', $user->salaryMethod->method_id ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Salary Period</label>
                                        <select name="salary_method[period_id]" class="form-control">
                                            <option value="bi-monthly" {{ old('salary_method.period_id', $user->salaryMethod->period_id ?? '') == 'bi-monthly' ? 'selected' : '' }}>Bi-Monthly</option>
                                            <option value="monthly" {{ old('salary_method.period_id', $user->salaryMethod->period_id ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="weekly" {{ old('salary_method.period_id', $user->salaryMethod->period_id ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="daily" {{ old('salary_method.period_id', $user->salaryMethod->period_id ?? '') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Account Name / Number</label>
                                        <input type="text" name="salary_method[account]" class="form-control" value="{{ old('salary_method.account', $user->salaryMethod->account ?? '') }}">
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <label class="fw-bold">Shift Template (Optional)</label>
                                        <select id="shift_select" class="form-control mb-2">
                                            <option value="">No template / Custom only</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                        data-shift='@json($shift)'
                                                        {{ old('salary_method.shift_id', $user->salaryMethod->shift_id ?? null) == $shift->id ? 'selected' : '' }}>
                                                    {{ $shift->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="salary_method[shift_id]" id="assigned_shift_id" value="{{ old('salary_method.shift_id', $user->salaryMethod->shift_id ?? null) }}">

                                        <small class="text-muted">Select a template to customize times and view schedule.</small>
                                    </div>
                                </div>

                                <!-- Custom Shift Modal -->
                                <div class="modal fade" id="shiftModal" tabindex="-1" role="dialog" aria-labelledby="shiftModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold" id="shiftModalLabel">
                                                    <span id="modal-shift-name">Custom Shift Settings</span>
                                                </h5>
                                                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- NOTE: visible Custom Shift Schedule inputs removed. Hidden inputs inserted below will be populated by JS when saving the modal. -->
                                                <input type="hidden" name="salary_method[custom_time_start]" id="custom_time_start_input" value="{{ old('salary_method.custom_time_start', $user->salaryMethod->custom_time_start ?? '') }}">
                                                <input type="hidden" name="salary_method[custom_time_end]" id="custom_time_end_input" value="{{ old('salary_method.custom_time_end', $user->salaryMethod->custom_time_end ?? '') }}">
                                                <input type="hidden" name="salary_method[custom_break_start]" id="custom_break_start_input" value="{{ old('salary_method.custom_break_start', $user->salaryMethod->custom_break_start ?? '') }}">
                                                <input type="hidden" name="salary_method[custom_break_end]" id="custom_break_end_input" value="{{ old('salary_method.custom_break_end', $user->salaryMethod->custom_break_end ?? '') }}">

                                                <!-- Preset date range for template schedule -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label>Preset Schedule Start</label>
                                                        <input type="date" id="preset_start" name="salary_method[preset_start]" class="form-control" value="{{ old('salary_method.preset_start') }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Preset Schedule End</label>
                                                        <input type="date" id="preset_end" name="salary_method[preset_end]" class="form-control" value="{{ old('salary_method.preset_end') }}">
                                                    </div>
                                                </div>

                                                <!-- Generated per-date schedule preview -->
                                                <div id="preset-dates-list" class="mb-3">
                                                    <!-- JS will render date cards here -->
                                                </div>

                                                <div class="card mt-4">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-4">Current Shift Preview</h6>
                                                        <div class="row mb-4">
                                                            <div class="col-md-3"><strong>Start:</strong> <span id="pv-start" class="text-primary fw-bold">-</span></div>
                                                            <div class="col-md-3"><strong>End:</strong> <span id="pv-end" class="text-primary fw-bold">-</span></div>
                                                            <div class="col-md-3"><strong>Break Start:</strong> <span id="pv-break-start" class="text-primary fw-bold">-</span></div>
                                                            <div class="col-md-3"><strong>Break End:</strong> <span id="pv-break-end" class="text-primary fw-bold">-</span></div>
                                                        </div>

                                                        <h6 class="fw-bold mb-3">Weekly / Preset Selection</h6>
                                                        <!-- Weekly table removed — per-date selections will be used. -->
                                                        <!-- Hidden array inputs for server, populated by JS on Save -->
                                                        <input type="hidden" name="salary_method[custom_work_days]" id="custom_work_days_input" value="{{ old('salary_method.custom_work_days', json_encode($user->salaryMethod->custom_work_days ?? [])) }}">
                                                        <input type="hidden" name="salary_method[custom_rest_days]" id="custom_rest_days_input" value="{{ old('salary_method.custom_rest_days', json_encode($user->salaryMethod->custom_rest_days ?? [])) }}">
                                                        <input type="hidden" name="salary_method[custom_open_time]" id="custom_open_time_input" value="{{ old('salary_method.custom_open_time', json_encode($user->salaryMethod->custom_open_time ?? [])) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" id="apply-preset-btn" class="btn btn-primary mr-2">Apply</button>
                                                <button type="button" id="save-shift-modal-btn" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mt-3">Allowances</h6>
                                <div id="allowances-list">
                                    @foreach($allowances as $i => $al)
                                    <div class="form-row align-items-center mb-2 allowance-row">
                                        <div class="col-md-5">
                                            <div class="form-check">
                                                <input class="form-check-input allowance-checkbox" type="checkbox" name="allowances[{{ $i }}][allowance_id]" value="{{ $al->id }}" id="allowance_{{ $al->id }}" {{ (isset($user) && $user->allowances->contains($al->id)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="allowance_{{ $al->id }}">{{ $al->name }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="input-group">
                                                <input type="number" name="allowances[{{ $i }}][amount]" class="form-control allowance-amount text-center" placeholder="Enter Amount Here" step="100" min="0" value="{{ old("allowances.$i.amount", optional($user->allowances->firstWhere('id',$al->id))->pivot->amount ?? '') }}" {{ !(isset($user) && $user->allowances->contains($al->id)) ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <h6 class="mt-5 mb-3">Leaves</h6>

                    <!-- Header -->
                    <div class="row fw-bold small text-secondary mb-2">
                        <div class="col-md-5 ps-1">Leave Type</div>
                        <div class="col-md-2 text-center">Leave Credits</div>
                        <div class="col-md-2 text-center">Used Leaves</div>
                        <div class="col-md-2 text-center">Leave Balance</div>
                        <div class="col-md-1 text-center">Action</div>
                    </div>

                    <div id="leaves-list">
                        @foreach($leaves as $i => $lv)
                        <div class="leave-row row align-items-center py-2 border-bottom" data-leave-id="{{ $lv->id }}">

                            <!-- Leave Type -->
                            <div class="col-md-5">
                                <div class="form-check">
                                    <input class="form-check-input leave-checkbox" type="checkbox"
                                            name="leaves[{{ $i }}][leave_id]" value="{{ $lv->id }}" id="leave_{{ $lv->id }}"
                                            {{ old("leaves.$i.assigned_days") ? 'checked' : '' }}>
                                    <label class="form-check-label" for="leave_{{ $lv->id }}">{{ $lv->name }}</label>
                                </div>
                            </div>

                            <!-- Credits -->
                            <div class="col-md-2 text-center text-muted">
                                @php
                                    $pivot = $user->leaves->firstWhere('id', $lv->id)?->pivot;
                                    $assignedDays = old("leaves.$i.assigned_days", $pivot?->assigned_days ?? 0);
                                    $effectiveDate = $pivot?->effective_date ?? $pivot?->updated_at ?? null;
                                @endphp
                                <span class="leave-credits"
                                    data-assigned-date="{{ $effectiveDate ? \Carbon\Carbon::parse($effectiveDate)->format('m/d/Y') : '' }}">
                                    {{ $assignedDays }}
                                </span>
                            </div>
                            <!-- Used -->
                            <div class="col-md-2 text-center text-muted">
                                <span class="leave-used">0</span>
                            </div>

                            <!-- Balance -->
                            <div class="col-md-2 text-center fw-medium">
                        <span class="leave-balance">
                            {{ old("leaves.$i.assigned_days", $user->leaves->firstWhere('id', $lv->id)?->pivot?->assigned_days ?? 0) }}
                        </span>
                    </div>

                            <!-- Action -->
                            <div class="col-md-1 text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-link text-secondary p-0" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li>
                                            <a class="dropdown-item assign-leave-inline" href="javascript:void(0)"
                                            data-leave-id="{{ $lv->id }}"
                                            data-leave-name="{{ $lv->name }}">
                                                Assign Leave
                                            </a>
                                        </li>
                                                       <li>
    <a class="dropdown-item" href="javascript:void(0)"
       onclick="openLeaveHistory('{{ $lv->id }}', '{{ addslashes($lv->name) }}')">
        Leave History
    </a>
</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <!-- Inline assign form (hidden by default) -->
                    <div id="assign-form-{{ $lv->id }}"
                        class="assign-leave-form row bg-white border border-secondary-subtle p-3 rounded-3 shadow-sm d-none mb-3"
                        data-leave-id="{{ $lv->id }}">

                        <div class="col-12 mb-3">
                            <h6 class="mb-0 fw-semibold text-dark">
                                Assign {{ $lv->name }}
                            </h6>
                        </div>

                        <div class="col-md-5 mb-3">
                            <label class="form-label small fw-medium text-muted mb-1 d-block">
                                Number of days
                            </label>
                        <input type="number"
                        class="form-control form-control-sm"
                        id="assign-days-{{ $lv->id }}"
                        name="assign_days"
                        value="1"
                        min="1"
                        required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-medium text-muted mb-1 d-block">
                                Effective Date (optional)
                            </label>
                            <input type="date"
                                class="form-control form-control-sm"
                                id="assign-date-{{ $lv->id }}"
                                name="leaves[{{ $i }}][effective_date]">   <!-- ← add this name -->
                        </div>

                        <div class="col-md-3 mb-3 d-flex align-items-end gap-2">
                            <button type="button"
                                    class="btn btn-sm btn-primary px-4 save-assign-leave"
                                    data-leave-id="{{ $lv->id }}"
                                    data-index="{{ $i }}">   <!-- pass index for JS -->
                                Save
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary px-4 cancel-assign-leave"
                                    data-leave-id="{{ $lv->id }}">
                                Cancel
                            </button>
                        </div>
                    </div>
                        @endforeach
                    </div>

                    <!-- ===================== LEAVE HISTORY MODAL ===================== -->
<div class="modal fade" id="leaveHistoryModal" tabindex="-1" role="dialog" aria-labelledby="leaveHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">

            <div class="modal-header" style="background:#f8f9fa; border-bottom:2px solid #dee2e6;">
                <h5 class="modal-title fw-bold text-dark" id="leaveHistoryModalLabel">
                    <i class="fas fa-history me-2 text-primary"></i>
                    Leave History &mdash; <span id="lh-leave-name" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body px-4 py-3">

                <!-- Loading spinner -->
                <div id="lh-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2">Loading leave history...</p>
                </div>

                <!-- Content (shown after load) -->
                <div id="lh-content" style="display:none;">

                    <!-- ── Leave Credit ── -->
                    <h6 class="fw-bold text-uppercase text-dark mb-2" style="letter-spacing:.5px;">
                        Leave Credit
                    </h6>
                    <div class="table-responsive mb-1">
                        <table class="table table-sm table-bordered mb-0" id="lh-credit-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Date Assigned</th>
                                    <th class="text-center">Assigned Leaves</th>
                                    <th>Reference #</th>
                                </tr>
                            </thead>
                            <tbody id="lh-credit-body">
                                <!-- JS fills this -->
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    <td class="text-center" id="lh-credit-total">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- ── Leave Usage ── -->
                    <h6 class="fw-bold text-uppercase text-dark mb-2 mt-4" style="letter-spacing:.5px;">
                        Leave Usage
                    </h6>
                    <div class="table-responsive mb-1">
                        <table class="table table-sm table-bordered mb-0" id="lh-usage-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Date of Leave</th>
                                    <th class="text-center">No of Days</th>
                                    <th>Reference #</th>
                                </tr>
                            </thead>
                            <tbody id="lh-usage-body">
                                <!-- JS fills this -->
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    <td class="text-center" id="lh-usage-total">0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- ── Leave Balance ── -->
                    <div class="mt-3 ps-1">
                        <span class="fw-bold text-danger fs-6">Leave Balance &nbsp;&nbsp;
                            <span id="lh-balance" class="fw-bold">0</span>
                        </span>
                    </div>

                </div><!-- /#lh-content -->

                <!-- Empty state -->
                <div id="lh-empty" style="display:none;" class="text-center text-muted py-4">
                    <i class="fas fa-folder-open fa-2x mb-2"></i>
                    <p>No leave history found for this employee.</p>
                </div>

            </div><!-- /.modal-body -->

            <div class="modal-footer" style="background:#f8f9fa;">
                <button type="button" class="btn btn-secondary btn-sm"
                        data-bs-dismiss="modal" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- =================== END LEAVE HISTORY MODAL =================== -->

                </div>
                        </div>
                    </div>

                    <!-- Educational Background -->
                    <div class="tab-pane fade" id="educ" role="tabpanel" aria-labelledby="educ-tab">
                        <div class="card">
                            <div class="card-body">
                                <h6>Educational Background</h6>

                                <!-- Table-like header row -->
                                <div class="row fw-bold mb-2">
                                    <div class="col-md-5">Name of School*</div>
                                    <div class="col-md-2">Level*</div>
                                    <div class="col-md-2">From</div>
                                    <div class="col-md-2">To</div>
                                    <div class="col-md-1"></div> <!-- empty space for remove button -->
                                </div>

                                <div id="educ-bg-list">
                                    @if(old('educational_backgrounds'))
                                        @foreach(old('educational_backgrounds') as $index => $eb)
                                            <div class="educ-row row mb-2">
                                                <div class="col-md-5"><input type="text" name="educational_backgrounds[{{ $index }}][name_of_school]" class="form-control" value="{{ $eb['name_of_school'] ?? '' }}" placeholder="Name of school"></div>
                                                <div class="col-md-2">
                                                    <select name="educational_backgrounds[{{ $index }}][level]" class="form-control">
                                                        <option value="">Select Level</option>
                                                        <option value="Elementary"    {{ ($eb['level'] ?? '') === 'Elementary'    ? 'selected' : '' }}>Elementary</option>
                                                        <option value="High School"   {{ ($eb['level'] ?? '') === 'High School'   ? 'selected' : '' }}>High School</option>
                                                        <option value="Vocational"    {{ ($eb['level'] ?? '') === 'Vocational'    ? 'selected' : '' }}>Vocational</option>
                                                        <option value="College"       {{ ($eb['level'] ?? '') === 'College'       ? 'selected' : '' }}>College</option>
                                                        <option value="Graduate"      {{ ($eb['level'] ?? '') === 'Graduate'      ? 'selected' : '' }}>Graduate</option>
                                                        <option value="Post Graduate" {{ ($eb['level'] ?? '') === 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2"><input type="date" name="educational_backgrounds[{{ $index }}][tenure_start]" class="form-control" value="{{ $eb['tenure_start'] ?? '' }}"></div>
                                                <div class="col-md-2"><input type="date" name="educational_backgrounds[{{ $index }}][tenure_end]" class="form-control" value="{{ $eb['tenure_end'] ?? '' }}"></div>
                                                <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-educ">-</button></div>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach($educationalBackgrounds as $index => $eb)
                                            <div class="educ-row row mb-2">
                                                <div class="col-md-5"><input type="text" name="educational_backgrounds[{{ $index }}][name_of_school]" class="form-control" value="{{ $eb->name_of_school }}" placeholder="Name of school"></div>
                                                <div class="col-md-2">
                                <select name="educational_backgrounds[{{ $index }}][level]" class="form-control">
                                    <option value="">Select Level</option>
                                    <option value="Elementary"    {{ $eb->level === 'Elementary'    ? 'selected' : '' }}>Elementary</option>
                                    <option value="High School"   {{ $eb->level === 'High School'   ? 'selected' : '' }}>High School</option>
                                    <option value="Vocational"    {{ $eb->level === 'Vocational'    ? 'selected' : '' }}>Vocational</option>
                                    <option value="College"       {{ $eb->level === 'College'       ? 'selected' : '' }}>College</option>
                                    <option value="Graduate"      {{ $eb->level === 'Graduate'      ? 'selected' : '' }}>Graduate</option>
                                    <option value="Post Graduate" {{ $eb->level === 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                                </select>
                            </div>
                                                <div class="col-md-2"><input type="date" name="educational_backgrounds[{{ $index }}][tenure_start]" class="form-control" value="{{ $eb->tenure_start }}"></div>
                                                <div class="col-md-2"><input type="date" name="educational_backgrounds[{{ $index }}][tenure_end]" class="form-control" value="{{ $eb->tenure_end }}"></div>
                                                <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-educ">-</button></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" id="add-educ" class="btn btn-sm btn-outline-primary">Add education</button>

                               <!-- Attachments (copied from create) -->
                                <div class="card mt-4 border-orange">
                                    <div class="card-body">
                                        <h6 class="mb-4 text-orange">Attachments</h6>
                                        <div id="attachments-list">
                                            @php
                                                $commonAttachments = [
                                                    'Birth Certificate',
                                                    'Valid ID',
                                                    'Marriage Contract',
                                                    'Health Card',
                                                    'NBI',
                                                    'Resume',
                                                    'Location Sketch',
                                                    '2x2',
                                                    'Police Clearance',
                                                    'police clearance',
                                                    'NBI',
                                                    'GSIS',
                                                    'HMO',
                                                ];
                                            @endphp

                                        @foreach($commonAttachments as $index => $name)
                                            @php
                                                $existing = $user->attachments->firstWhere('name', $name);
                                                $hasFile  = $existing !== null;
                                                $fileName = $existing ? $existing->file_name : '';
                                                $filePath = $hasFile ? Storage::url($existing->file_path) : '';
                                            @endphp

                                            <div class="attachment-row row align-items-center mb-3">
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input attachment-checkbox"
                                                            type="checkbox"
                                                            id="attach_{{ $index }}"
                                                            name="attachment_checked[{{ $index }}]"
                                                            value="{{ $name }}"
                                                            {{ old("attachment_checked.$index") ? 'checked' : '' }}
                                                            {{ $hasFile ? 'checked' : '' }}
                                                        >
                                                        <label class="form-check-label" for="attach_{{ $index }}">{{ $name }}</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input
                                                                type="file"
                                                                class="custom-file-input attachment-file"
                                                                name="attachments[{{ $index }}]"
                                                                id="file_{{ $index }}"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                disabled
                                                            >
                                                            <label class="custom-file-label text-truncate" for="file_{{ $index }}">
                                                                {{ $hasFile ? $fileName : 'Choose file...' }}
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <input type="hidden" name="attachment_names[{{ $index }}]" class="attachment-name" value="{{ $name }}" disabled>
                                                </div>

                                                <div class="col-md-2 text-right">
                                                    <button type="button" class="btn btn-sm btn-danger remove-attachment" {{ !$hasFile ? 'disabled' : '' }}>Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <div>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 

@section('scripts')

<!-- Your existing scripts here -->

    <!-- ADD THIS BLOCK TO TEST/FIX TABS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- <script>
        $(document).ready(function(){
            console.log("jQuery and Bootstrap loaded for tabs");

            // Force activate the Access tab to test
            $('#access-tab').tab('show');

            // Optional: activate tab from URL hash (e.g. #work)
            if (window.location.hash) {
                $('a[href="' + window.location.hash + '"]').tab('show');
            }
        });
    </script> --}}
    
<script>
// Image previews
document.getElementById('image')?.addEventListener('change', function(e){
    const file = e.target.files && e.target.files[0];
    if(!file) return;
    if(!file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = function(ev){
        let img = document.getElementById('create-user-image-preview');
        if(!img){
            img = document.createElement('img');
            img.id = 'create-user-image-preview';
            img.className = 'img-thumbnail mt-2';
            img.style.maxWidth = '190px';
            document.getElementById('image').parentNode.appendChild(img);
        }
        img.src = ev.target.result;
    }
    reader.readAsDataURL(file);
});
document.getElementById('avatar')?.addEventListener('change', function(e){
    const file = e.target.files && e.target.files[0];
    if(!file) return;
    if(!file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = function(ev){
        let img = document.getElementById('create-user-avatar-preview');
        if(!img){
            img = document.createElement('img');
            img.id = 'create-user-avatar-preview';
            img.className = 'img-thumbnail mt-2';
            img.style.maxWidth = '190px';
            document.getElementById('avatar').parentNode.appendChild(img);
        }
        img.src = ev.target.result;
    }
    reader.readAsDataURL(file);
});

// Repeatable educational backgrounds
(() => {
    let educIndex = 1;
    document.getElementById('add-educ')?.addEventListener('click', function(){
        const container = document.getElementById('educ-bg-list');
        const row = document.createElement('div');
        row.className = 'educ-row row mb-2';
        row.innerHTML = `\
            <div class="col-md-5"><input type="text" name="educational_backgrounds[${educIndex}][name_of_school]" class="form-control" placeholder="Name of school"></div>\
            <div class="col-md-2">
            <select name="educational_backgrounds[${educIndex}][level]" class="form-control">
                <option value="">Select Level</option>
                <option value="Elementary">Elementary</option>
                <option value="High School">High School</option>
                <option value="Vocational">Vocational</option>
                <option value="College">College</option>
                <option value="Graduate">Graduate</option>
                <option value="Post Graduate">Post Graduate</option>
            </select>
        </div>
            <div class="col-md-2"><input type="date" name="educational_backgrounds[${educIndex}][tenure_start]" class="form-control"></div>\
            <div class="col-md-2"><input type="date" name="educational_backgrounds[${educIndex}][tenure_end]" class="form-control"></div>\
            <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-educ">-</button></div>`;
        container.appendChild(row);
        educIndex++;
    });
    document.getElementById('educ-bg-list')?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-educ')){
            e.target.closest('.educ-row').remove();
        }
    });
})();

// Allowances add/remove and conditional inputs
(() => {
    let aIndex = 1;
    const addAllowanceBtn = document.getElementById('add-allowance');
    const allowancesContainer = document.getElementById('allowances-list');

    // show/hide amount inputs when select changes
    allowancesContainer?.addEventListener('change', function(e){
        if(e.target && e.target.classList.contains('allowance-select')){
            const sel = e.target;
            const row = sel.closest('.allowance-row');
            if(!row) return;
            const amt = row.querySelector('.allowance-amount');
            const cnt = row.querySelector('.allowance-count');
            if(sel.value){
                if(amt){ amt.style.display=''; amt.disabled = false; }
                if(cnt){ cnt.style.display=''; cnt.disabled = false; }
            } else {
                if(amt){ amt.style.display='none'; amt.disabled = true; amt.value = ''; }
                if(cnt){ cnt.style.display='none'; cnt.disabled = true; cnt.value = ''; }
            }
        }
    });

    addAllowanceBtn?.addEventListener('click', function(){
        const row = document.createElement('div');
        row.className = 'allowance-row d-flex mb-2 align-items-center';
        let options = `\n                                            <option value="">-- Select allowance --</option>`;
        @foreach($allowances as $al)
            options += `\n                                                <option value="{{ $al->id }}">{{ addslashes($al->name) }}</option>`;
        @endforeach
        row.innerHTML = `\n            <select name="allowances[${aIndex}][allowance_id]" class="form-control mr-2 allowance-select" style="width:40%">${options}</select>\n            <input type="number" name="allowances[${aIndex}][amount]" class="form-control mr-2 allowance-amount" placeholder="Amount" style="display:none;" disabled>\n            <input type="number" name="allowances[${aIndex}][monthly_count]" class="form-control mr-2 allowance-count" placeholder="Monthly count" style="display:none;" disabled>\n            <button type="button" class="btn btn-sm btn-outline-danger remove-allowance">Remove</button>`;
        allowancesContainer.appendChild(row);
        aIndex++;
    });

    allowancesContainer?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-allowance')){
            e.target.closest('.allowance-row').remove();
        }
    });

    // initialize existing rows visibility
    document.querySelectorAll('#allowances-list .allowance-row').forEach(function(row){
        const sel = row.querySelector('.allowance-select');
        if(sel){
            sel.dispatchEvent(new Event('change'));
        }
    });
})();

// ── Leave History Modal ──────────────────────────────────────────
function openLeaveHistory(leaveId, leaveName) {
    // Update modal title
    document.getElementById('lh-leave-name').textContent = leaveName;

    // Reset state
    document.getElementById('lh-loading').style.display = '';
    document.getElementById('lh-content').style.display = 'none';
    document.getElementById('lh-empty').style.display   = 'none';

    // Open modal — Bootstrap 4 (jQuery)
    if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
        window.jQuery('#leaveHistoryModal').modal('show');
    } else if (window.bootstrap) {
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('leaveHistoryModal')
        ).show();
    }

    const userId = document.getElementById('lh-user-id')?.value || null;

    function fmtDate(str) {
        if (!str) return '—';
        try { return new Date(str).toLocaleDateString(); } catch (e) { return str; }
    }
    function makeRef(prefix, id, idx) {
        return `${prefix}-${String(id).padStart(2,'0')}-${String(idx+1).padStart(3,'0')}`;
    }

    // AFTER
    if (!userId) {
        document.getElementById('lh-loading').style.display = 'none';

        const leaveRow   = document.querySelector(`.leave-row[data-leave-id="${leaveId}"]`);
        const creditsSpan = leaveRow?.querySelector('.leave-credits');
        const credits    = parseInt(creditsSpan?.textContent) || 0;

        // ← Read the date stored by save-assign-leave
        const assignedDate = creditsSpan?.dataset.assignedDate || '—';

        if (credits > 0) {
            document.getElementById('lh-credit-body').innerHTML = `
                <tr>
                    <td>${assignedDate}</td>
                    <td class="text-center">${credits}</td>
                    <td>${makeRef('LC', leaveId, 0)}</td>
                </tr>`;
            document.getElementById('lh-credit-total').textContent = credits;
            document.getElementById('lh-usage-body').innerHTML = '<tr><td colspan="3" class="text-center text-muted">No usage yet</td></tr>';
            document.getElementById('lh-usage-total').textContent = 0;
            document.getElementById('lh-balance').textContent = credits;
            document.getElementById('lh-content').style.display = '';
        } else {
            document.getElementById('lh-empty').style.display = '';
        }
        return;
    }

    // ── EDIT form: fetch from server ──
    fetch(`/users/${userId}/leave-history/${leaveId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('lh-loading').style.display = 'none';

        const credits = data.credits || [];
        const usages  = data.usages  || [];

        if (!credits.length && !usages.length) {
            document.getElementById('lh-empty').style.display = '';
            return;
        }

        // Credits
        const creditBody = document.getElementById('lh-credit-body');
        creditBody.innerHTML = '';
        let creditTotal = 0;
        credits.forEach((row, i) => {
            creditTotal += Number(row.assigned_days || 0);
            creditBody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${fmtDate(row.effective_date || row.created_at)}</td>
                    <td class="text-center">${row.assigned_days || 0}</td>
                    <td>${row.reference || makeRef('LC', leaveId, i)}</td>
                </tr>`);
        });
        document.getElementById('lh-credit-total').textContent = creditTotal;

        // Usages
        const usageBody = document.getElementById('lh-usage-body');
        usageBody.innerHTML = '';
        let usageTotal = 0;
        usages.forEach((row, i) => {
            usageTotal += Number(row.days_used || 0);
            usageBody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${fmtDate(row.date_of_leave || row.created_at)}</td>
                    <td class="text-center">${row.days_used || 0}</td>
                    <td>${row.reference || makeRef('LU', leaveId, i)}</td>
                </tr>`);
        });

        if (!usages.length) {
            usageBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">No usage records yet</td></tr>';
        }

        document.getElementById('lh-usage-total').textContent = usageTotal;
        document.getElementById('lh-balance').textContent = data.balance ?? (creditTotal - usageTotal);
        document.getElementById('lh-content').style.display = '';
    })
    .catch(() => {
        document.getElementById('lh-loading').style.display = 'none';
        document.getElementById('lh-empty').style.display = '';
    });
}

// NOTE: workinfo add/edit is handled in the IIFE further below which provides
// edit + remove behavior. The earlier simple handler was removed to avoid
// duplicate listeners and index collisions.

document.querySelector('form').addEventListener('submit', function () {
    try { aggregateShiftModalAndPopulateHidden(); } catch (e) { /* ignore */ }

    // Enable all allowance amounts for checked allowances
    document.querySelectorAll('.allowance-checkbox:checked').forEach(cb => {
        const row = cb.closest('.allowance-row');
        const amt = row?.querySelector('.allowance-amount');
        const cnt = row?.querySelector('.allowance-count');
        if (amt) amt.disabled = false;
        if (cnt) cnt.disabled = false;
    });

    // Ensure all leave hidden inputs are enabled
    document.querySelectorAll('input[name^="leaves["]').forEach(inp => {
        inp.disabled = false;
    });
});

(function(){
    const container = document.getElementById('allowances-list');

    // enable / disable inputs on checkbox toggle
    container?.addEventListener('change', function(e){
        if(e.target.classList.contains('allowance-checkbox')){
            const row = e.target.closest('.allowance-row');
            if(!row) return;

            const amount = row.querySelector('.allowance-amount');
            const count  = row.querySelector('.allowance-count');

            if(e.target.checked){
                amount.disabled = false;
                count.disabled  = false;
            } else {
                amount.disabled = true;
                count.disabled  = true;
                amount.value = '';
                count.value  = '';
            }
        }
    });

    // remove row
    container?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-allowance')){
            e.target.closest('.allowance-row')?.remove();
        }
    });
})();

(function(){
    // Leaves toggle enable/disable and remove
    const leavesContainer = document.getElementById('leaves-list');
    leavesContainer?.addEventListener('change', function(e){
        if(e.target && e.target.classList.contains('leave-checkbox')){
            const cb = e.target;
            const row = cb.closest('.leave-row');
            if(!row) return;
            const days = row.querySelector('.leave-days');
            const eff = row.querySelector('.leave-effective');
            if(cb.checked){
                if(days){ days.disabled = false; }
                if(eff){ eff.disabled = false; }
            } else {
                if(days){ days.disabled = true; days.value = ''; }
                if(eff){ eff.disabled = true; eff.value = ''; }
            }
        }
    });
    leavesContainer?.addEventListener('click', function(e){
        if(e.target && e.target.classList.contains('remove-leave')){
            const row = e.target.closest('.leave-row');
            if(row) row.remove();
        }
    });
})();

// Work info add/edit (table + hidden inputs)
(function(){
    // Compute starting index from existing hidden inputs so newly-added rows
    // don't collide with server-rendered indices (which use $loop->index).
    let wiIndex = (function(){
        try {
            const inputs = document.querySelectorAll('#workinfo-table tbody input[name^="employee_work_informations["]');
            let max = -1;
            inputs.forEach(inp => {
                const m = inp.name.match(/^employee_work_informations\[(\d+)\]/);
                if (m && m[1]) {
                    const idx = parseInt(m[1], 10);
                    if (!isNaN(idx) && idx > max) max = idx;
                }
            });
            return max + 1;
        } catch(e) { return 0; }
    })();
    const openBtn = document.getElementById('open-workinfo-form');
    const formPane = document.getElementById('workinfo-form');
    const cancelBtn = document.getElementById('cancel-workinfo');
    const saveBtn = document.getElementById('save-workinfo');
    const tableBody = document.querySelector('#workinfo-table tbody');

    openBtn?.addEventListener('click', function(){
        formPane.style.display = '';
    });
    cancelBtn?.addEventListener('click', function(){
        formPane.style.display = 'none';
        // clear inputs
        ['wi_hire_date','wi_status','wi_regularization','wi_designation','wi_department','wi_supervisor','wi_monthly_rate','wi_daily_rate','wi_hourly_rate'].forEach(id=>{ const el=document.getElementById(id); if(el) el.value=''; });
    });

    // track editing state
    let editingRow = null;
    saveBtn?.addEventListener('click', function(){
        // read values
        const data = {
            hire_date: document.getElementById('wi_hire_date')?.value || '',
            employment_status: document.getElementById('wi_status')?.value || '',
            regularization: document.getElementById('wi_regularization')?.value || '',
            designation_id: document.getElementById('wi_designation')?.value || '',
            designation_text: document.getElementById('wi_designation')?.selectedOptions?.[0]?.text || '',
            department_id: document.getElementById('wi_department')?.value || '',
            department_text: document.getElementById('wi_department')?.selectedOptions?.[0]?.text || '',
            supervisor: document.getElementById('wi_supervisor')?.value || '',
            monthly_rate: document.getElementById('wi_monthly_rate')?.value || '',
            daily_rate: document.getElementById('wi_daily_rate')?.value || '',
            hourly_rate: document.getElementById('wi_hourly_rate')?.value || '',
        };

        // simple validation: require hire_date
        if(!data.hire_date){ alert('Please enter Date'); return; }

        // create or update table row with visible text and hidden inputs
        const renderRow = (index) => {
            return `
            <td>${data.hire_date}<input type="hidden" name="employee_work_informations[${index}][hire_date]" value="${data.hire_date}"></td>
            <td>${data.employment_status}<input type="hidden" name="employee_work_informations[${index}][employment_status_id]" value="${data.employment_status}"></td>
            <td>${data.regularization}<input type="hidden" name="employee_work_informations[${index}][regularization]" value="${data.regularization}"></td>
            <td>${data.designation_text}<input type="hidden" name="employee_work_informations[${index}][designation_id]" value="${data.designation_id}"></td>
            <td>${data.department_text}<input type="hidden" name="employee_work_informations[${index}][department_id]" value="${data.department_id}"></td>
            <td>${data.supervisor}<input type="hidden" name="employee_work_informations[${index}][direct_supervisor]" value="${data.supervisor}"></td>
            <td>${data.monthly_rate}<input type="hidden" name="employee_work_informations[${index}][monthly_rate]" value="${data.monthly_rate}"></td>
            <td>${data.daily_rate}<input type="hidden" name="employee_work_informations[${index}][daily_rate]" value="${data.daily_rate}"></td>
            <td>${data.hourly_rate}<input type="hidden" name="employee_work_informations[${index}][hourly_rate]" value="${data.hourly_rate}"></td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-secondary edit-workinfo-row">Edit</button>
                <button type="button" class="btn btn-sm btn-outline-danger remove-workinfo-row">Remove</button>
            </td>
        `;
        };

        if (editingRow) {
            // replace existing
            const idx = editingRow.getAttribute('data-wi-index');
            editingRow.innerHTML = renderRow(idx);
            editingRow.removeAttribute('data-editing');
            editingRow = null;
        } else {
            const tr = document.createElement('tr');
            tr.innerHTML = renderRow(wiIndex);
            tr.setAttribute('data-wi-index', wiIndex);
            tableBody.appendChild(tr);
            wiIndex++;
        }

        // hide form and clear
        cancelBtn.click();
    });

    // remove row
    document.querySelector('#workinfo-table')?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-workinfo-row')){
            e.target.closest('tr').remove();
        }
        if(e.target.classList.contains('edit-workinfo-row')){
            // populate form with values from the row for editing
            const tr = e.target.closest('tr');
            if(!tr) return;
            const inputs = tr.querySelectorAll('input[type="hidden"]');
            // helper to find hidden input for a given suffix name
            const getVal = (suffix) => {
                for(const inp of inputs){
                    if(inp.name && inp.name.endsWith(suffix)) return inp.value;
                }
                return '';
            };
            document.getElementById('wi_hire_date').value = getVal('[hire_date]') || '';
            document.getElementById('wi_status').value = getVal('[employment_status_id]') || '';
            document.getElementById('wi_regularization').value = getVal('[regularization]') || '';
            const desId = getVal('[designation_id]') || '';
            const depId = getVal('[department_id]') || '';
            if(document.getElementById('wi_designation')) document.getElementById('wi_designation').value = desId;
            if(document.getElementById('wi_department')) document.getElementById('wi_department').value = depId;
            document.getElementById('wi_supervisor').value = getVal('[direct_supervisor]') || '';
            document.getElementById('wi_monthly_rate').value = getVal('[monthly_rate]') || '';
            document.getElementById('wi_daily_rate').value = getVal('[daily_rate]') || '';
            document.getElementById('wi_hourly_rate').value = getVal('[hourly_rate]') || '';
            // set editing marker
            tr.setAttribute('data-editing', '1');
            editingRow = tr;
            // show the form
            document.getElementById('workinfo-form').style.display = '';
        }
    });
})();

// Activate tab from URL hash (e.g. /users/create#access)
(function(){
    function activateTabFromHash(hash){
        if(!hash) return;
        try{
            // prefer selector matching the tab href
            var selector = 'a.nav-link[href="' + hash + '"]';
            var tabLink = document.querySelector(selector);
            if(tabLink){
                // If jQuery + bootstrap tab plugin available (Bootstrap 4)
                if(window.jQuery && typeof window.jQuery.fn.tab === 'function'){
                    window.jQuery(selector).tab('show');
                    return;
                }
                // Bootstrap 5: use the JS API
                if(window.bootstrap && typeof window.bootstrap.Tab === 'function'){
                    var tab = new window.bootstrap.Tab(tabLink);
                    tab.show();
                    return;
                }
                // Fallback: manually activate classes
                // deactivate active links/panes
                document.querySelectorAll('.nav-link').forEach(function(el){ el.classList.remove('active'); el.setAttribute('aria-selected','false'); });
                document.querySelectorAll('.tab-pane').forEach(function(p){ p.classList.remove('show','active'); });
                tabLink.classList.add('active');
                tabLink.setAttribute('aria-selected','true');
                var targetId = tabLink.getAttribute('href');
                var pane = document.querySelector(targetId);
                if(pane){ pane.classList.add('show','active'); }
            }
        }catch(e){ console.error('activateTabFromHash error', e); }
    }

    // on load
    document.addEventListener('DOMContentLoaded', function(){
        activateTabFromHash(window.location.hash);
        // server can request an active tab after validation via session('active_tab')
        try {
            var serverTab = "{{ session('active_tab', '') }}";
            if(serverTab) activateTabFromHash('#' + serverTab);
        } catch(e){}
    });

    // when the hash changes (back/forward or link click)
    window.addEventListener('hashchange', function(){
        activateTabFromHash(window.location.hash);
    });
})();

// Repeatable dependents
(() => {
    let depIndex = 1;
    document.getElementById('add-dependent')?.addEventListener('click', function(){
        const container = document.getElementById('dependents-list');
        const row = document.createElement('div');
        row.className = 'dependent-row row mb-2';
        row.innerHTML = `\
            <div class="col-md-3"><input type="text" name="dependents[${depIndex}][name]" class="form-control" placeholder="Name"></div>\
            <div class="col-md-2"><input type="date" name="dependents[${depIndex}][birthdate]" class="form-control"></div>\
            <div class="col-md-1"><input type="number" name="dependents[${depIndex}][age]" class="form-control" placeholder="Age"></div>\
            <div class="col-md-3">\
                <select name="dependents[${depIndex}][gender]" class="form-control">\
                    <option value="">-- Select Gender --</option>\
                    <option value="Male">Male</option>\
                    <option value="Female">Female</option>\
                    <option value="Other">Other</option>\
                </select>\
            </div>\
            <div class="col-md-2">\
                <select name="dependents[${depIndex}][relationship]" class="form-control">\
                    <option value="">-- Relationship --</option>\
                    <option value="Son">Son</option>\
                    <option value="Daughter">Daughter</option>\
                    <option value="Parent">Parent</option>\
                    <option value="Spouse">Spouse</option>\
                    <option value="Other">Other</option>\
                </select>\
            </div>\
            <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-dependent">-</button></div>`;
        container.appendChild(row);
        depIndex++;
    });
    document.getElementById('dependents-list')?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-dependent')){
            e.target.closest('.dependent-row').remove();
        }
    });
})();

// Repeatable work info
(() => {
    let wIndex = 1;
    document.getElementById('add-workinfo')?.addEventListener('click', function(){
        const container = document.getElementById('workinfo-list');
        const row = document.createElement('div');
        row.className = 'workinfo-row row mb-2';
        row.innerHTML = `\
            <div class="col-md-3"><input type="date" name="employee_work_informations[${wIndex}][hire_date]" class="form-control"></div>\
            <div class="col-md-2"><input type="number" name="employee_work_informations[${wIndex}][employment_status_id]" class="form-control"></div>\
            <div class="col-md-2"><input type="date" name="employee_work_informations[${wIndex}][regularization]" class="form-control"></div>\
            <div class="col-md-2"><input type="number" name="employee_work_informations[${wIndex}][designation_id]" class="form-control"></div>\
            <div class="col-md-2"><input type="number" name="employee_work_informations[${wIndex}][department_id]" class="form-control"></div>\
            <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger remove-workinfo">-</button></div>\
            <div class="col-12 mt-2">\
                <div class="row">\
                    <div class="col-md-4"><input type="number" step="0.01" name="employee_work_informations[${wIndex}][monthly_rate]" class="form-control" placeholder="Monthly rate"></div>\
                    <div class="col-md-4"><input type="number" step="0.01" name="employee_work_informations[${wIndex}][daily_rate]" class="form-control" placeholder="Daily rate"></div>\
                    <div class="col-md-4"><input type="number" step="0.01" name="employee_work_informations[${wIndex}][hourly_rate]" class="form-control" placeholder="Hourly rate"></div>\
                </div>\
            </div>`;
        container.appendChild(row);
        wIndex++;
    });
    document.getElementById('workinfo-list')?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-workinfo')){
            e.target.closest('.workinfo-row').remove();
        }
    });
})();

// Repeatable branch-permissions rows
(() => {
    const container = document.getElementById('branch-permissions-list');
    const addBtn = document.getElementById('add-branch-permission');

    const computeStartingIndex = () => {
        if (!container) return 0;
        const selects = container.querySelectorAll('select[name^="branch_permissions["]');
        let maxIndex = -1;
        selects.forEach(sel => {
            const m = sel.name.match(/^branch_permissions\[(\d+)\]/);
            if (m && m[1]) {
                const idx = parseInt(m[1], 10);
                if (!isNaN(idx) && idx > maxIndex) maxIndex = idx;
            }
        });
        return maxIndex + 1;
    };

    let bpIndex = computeStartingIndex();

    addBtn?.addEventListener('click', function(){
        const row = document.createElement('div');
        row.className = 'branch-permission-row form-row align-items-center mb-2';
        // build branch select options (serialize from server-side values)
        let branchOptions = `\n                                                <option value="">-- Select branch --</option>`;
        @foreach($branches as $branch)
            branchOptions += `\n                                                <option value="{{ $branch->id }}">{{ addslashes($branch->name) }}</option>`;
        @endforeach

        let permOptions = ``;
        @foreach($roles as $role)
            permOptions += `\n                                                    <option value="{{ $role->id }}">{{ addslashes($role->name) }}</option>`;
        @endforeach

        row.innerHTML = `\n                <div class="col-md-5">\n                    <select name="branch_permissions[${bpIndex}][branch_id]" class="form-control">${branchOptions}\n                    </select>\n                </div>\n                <div class="col-md-6">\n                    <select name="branch_permissions[${bpIndex}][permissions][]" class="form-control" multiple>\n                        ${permOptions}\n                    </select>\n                </div>\n                <div class="col-md-1">\n                    <button type="button" class="btn btn-sm btn-outline-danger remove-branch">-</button>\n                </div>`;

        container.appendChild(row);
        bpIndex++;
    });

    container?.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-branch')){
            const row = e.target.closest('.branch-permission-row');
            if(row) row.remove();
        }
    });
})();

// Attachments: checkbox → enable file input + remove button
document.getElementById('attachments-list')?.addEventListener('change', function(e) {
    if (e.target.classList.contains('attachment-checkbox')) {
        const row = e.target.closest('.attachment-row');
        const fileInput = row.querySelector('.attachment-file');
        const removeBtn = row.querySelector('.remove-attachment');
        const nameInput = row.querySelector('.attachment-name');

        if (e.target.checked) {
            fileInput.disabled = false;
            removeBtn.disabled = false;
            nameInput.disabled = false;
        } else {
            fileInput.disabled = true;
            fileInput.value = '';                    // clear file
            row.querySelector('.custom-file-label').textContent = 'Choose file...';
            removeBtn.disabled = true;
            // nameInput.disabled = true;            // usually keep enabled
        }
    // }

        document.querySelectorAll('.attachment-checkbox:checked').forEach(checkbox => {
            const row = checkbox.closest('.attachment-row');
            const fileInput = row.querySelector('.attachment-file');
            const removeBtn = row.querySelector('.remove-attachment');
            if (fileInput) fileInput.disabled = false;
            if (removeBtn) removeBtn.disabled = false;
        });
    }
});

// Update file label when file selected
document.getElementById('attachments-list')?.addEventListener('change', function(e) {
    if (e.target.classList.contains('attachment-file')) {
        const label = e.target.closest('.input-group').querySelector('.custom-file-label');
        if (e.target.files.length > 0) {
            label.textContent = e.target.files[0].name;
        } else {
            label.textContent = 'Choose file...';
        }
    }
});

// Remove button (clears checkbox and file)
// Remove button – also uncheck the checkbox!
document.getElementById('attachments-list')?.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-attachment')) {
        const row = e.target.closest('.attachment-row');
        const checkbox = row.querySelector('.attachment-checkbox');
        if (checkbox) checkbox.checked = false;     // ← important!
        
        const fileInput = row.querySelector('.attachment-file');
        if (fileInput) {
            fileInput.value = '';
            row.querySelector('.custom-file-label').textContent = 'Choose file...';
            fileInput.disabled = true;
        }
        e.target.disabled = true;
    }
});

// Initialize on load (for edit form with old values)
document.querySelectorAll('.attachment-checkbox').forEach(cb => {
    if (cb.checked) {
        const row = cb.closest('.attachment-row');
        row.querySelectorAll('.attachment-file, .remove-attachment').forEach(el => {
            el.disabled = false;
        });
    }
});

window.__initialAssignedShiftId = document.getElementById('assigned_shift_id')?.value || '';

// Force aggregation before ANY form submit (safety net)
document.querySelector('form')?.addEventListener('submit', function(e) {
    // If modal is open → aggregate NOW (prevents lost changes)
    const modalEl = document.getElementById('shiftModal');
    if (modalEl && modalEl.classList.contains('show')) {
        console.log('[Shift] Form submitting while modal open → forcing aggregation');
        aggregateShiftModalAndPopulateHidden();
    }
});

// Shift template dropdown change
document.getElementById('shift_select')?.addEventListener('change', function () {
    const option = this.options[this.selectedIndex];
    const modal = $('#shiftModal');
    const shiftId = option.value;

    document.getElementById('assigned_shift_id').value = shiftId || '';

    if (!shiftId) {
        modal.modal('hide');
        return;
    }

    const shift = JSON.parse(option.dataset.shift || '{}');

    // Update title
    document.getElementById('modal-shift-name').textContent = (shift.name || 'Custom') + ' - Customize';

    // Always load current DB values (no aggressive clear)
    const customTs = document.getElementById('custom_time_start_input')?.value || shift.time_start || '';
    const customTe = document.getElementById('custom_time_end_input')?.value || shift.time_end || '';
    const customBs = document.getElementById('custom_break_start_input')?.value || shift.break_start || '';
    const customBe = document.getElementById('custom_break_end_input')?.value || shift.break_end || '';

    let customWorkDays = document.getElementById('custom_work_days_input')?.value || '[]';
    let customRestDays = document.getElementById('custom_rest_days_input')?.value || '[]';
    let customOpenTime = document.getElementById('custom_open_time_input')?.value || '{}';

    try { customWorkDays = JSON.parse(customWorkDays); } catch(e) { customWorkDays = []; }
    try { customRestDays = JSON.parse(customRestDays); } catch(e) { customRestDays = []; }
    try { customOpenTime = JSON.parse(customOpenTime); } catch(e) { customOpenTime = {}; }

    // Build current model (prefer DB customs, fallback to template)
    window.currentShiftInModal = {
        ...shift,
        time_start: customTs,
        time_end: customTe,
        break_start: customBs,
        break_end: customBe,
        work_days: Array.isArray(customWorkDays) && customWorkDays.length ? customWorkDays : (shift.work_days || []),
        rest_days: Array.isArray(customRestDays) && customRestDays.length ? customRestDays : (shift.rest_days || []),
        open_time: Object.keys(customOpenTime).length ? customOpenTime : (shift.open_time || {}),
    };

    // Update preview
    document.getElementById('pv-start').textContent = (window.currentShiftInModal.time_start || '').slice(0,5) || '-';
    document.getElementById('pv-end').textContent = (window.currentShiftInModal.time_end || '').slice(0,5) || '-';
    document.getElementById('pv-break-start').textContent = (window.currentShiftInModal.break_start || '').slice(0,5) || '-';
    document.getElementById('pv-break-end').textContent = (window.currentShiftInModal.break_end || '').slice(0,5) || '-';

    // Reset preset list only if switching templates
    const container = document.getElementById('preset-dates-list');
    if (container?.dataset?.generatedFor !== shiftId) {
        container.innerHTML = '';
        document.getElementById('preset_start').value = '';
        document.getElementById('preset_end').value = '';
        container.dataset.generatedFor = shiftId;
    }

    // Render if range exists, or wait for user input
    if (document.getElementById('preset_start')?.value && document.getElementById('preset_end')?.value) {
        renderPresetDates(window.currentShiftInModal);
    }

    modal.modal('show');
});

// Aggregate function – called on modal save + form submit
function aggregateShiftModalAndPopulateHidden() {
    console.log('[Shift] Aggregating modal values...');

    const container = document.getElementById('preset-dates-list');
    if (!container) return;

    const cards = container.querySelectorAll('.card');
    const work = [], rest = [], openTimes = {};
    let firstStart = '', firstEnd = '', firstBreakStart = '', firstBreakEnd = '';

    cards.forEach(card => {
        const date = card.querySelector('input[name$="[date]"]')?.value;
        const tstart = card.querySelector('input[name$="[time_start]"]')?.value;
        const tend   = card.querySelector('input[name$="[time_end]"]')?.value;
        const lstart = card.querySelector('input[name$="[lunch_start]"]')?.value;
        const lend   = card.querySelector('input[name$="[lunch_end]"]')?.value;
        const dayType = card.querySelector('input[name$="[day_type]"]:checked')?.value || 'work';

        if (date) {
            if (dayType === 'work') work.push(date);
            else if (dayType === 'rest') rest.push(date);

            openTimes[date] = {
                start: tstart || null,
                end: tend || null,
                lunch_start: lstart || null,
                lunch_end: lend || null,
                day_type: dayType
            };
        }

        // Use first non-empty time as representative
        if (!firstStart && tstart) firstStart = tstart;
        if (!firstEnd && tend) firstEnd = tend;
        if (!firstBreakStart && lstart) firstBreakStart = lstart;
        if (!firstBreakEnd && lend) firstBreakEnd = lend;
    });

    const shift = window.currentShiftInModal || {};

    document.getElementById('custom_time_start_input').value   = firstStart || shift.time_start || '';
    document.getElementById('custom_time_end_input').value     = firstEnd   || shift.time_end   || '';
    document.getElementById('custom_break_start_input').value  = firstBreakStart || shift.break_start || '';
    document.getElementById('custom_break_end_input').value    = firstBreakEnd   || shift.break_end   || '';

    document.getElementById('custom_work_days_input').value    = JSON.stringify(work);
    document.getElementById('custom_rest_days_input').value    = JSON.stringify(rest);
    document.getElementById('custom_open_time_input').value    = JSON.stringify(openTimes);

    // Update preview
    document.getElementById('pv-start').textContent       = firstStart || shift.time_start?.slice(0,5) || '-';
    document.getElementById('pv-end').textContent         = firstEnd   || shift.time_end?.slice(0,5)   || '-';
    document.getElementById('pv-break-start').textContent = firstBreakStart || shift.break_start?.slice(0,5) || '-';
    document.getElementById('pv-break-end').textContent   = firstBreakEnd   || shift.break_end?.slice(0,5)   || '-';

    console.log('[Shift] Aggregation complete → customs saved to hidden inputs');
}

// Modal Save button
document.getElementById('save-shift-modal-btn')?.addEventListener('click', function(){
    aggregateShiftModalAndPopulateHidden();
    window.__initialAssignedShiftId = document.getElementById('assigned_shift_id')?.value || window.__initialAssignedShiftId;
    $('#shiftModal').modal('hide');
});

// Live preview update while editing times
document.getElementById('preset-dates-list')?.addEventListener('input', function(e){
    if (e.target.matches('input[type="time"], input[type="radio"]')) {
        aggregateShiftModalAndPopulateHidden();
    }
});

// Preset date range change → render cards
['preset_start', 'preset_end'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', () => {
        renderPresetDates(window.currentShiftInModal || {});
    });
});

// Apply preset button (manual render)
document.getElementById('apply-preset-btn')?.addEventListener('click', function(){
    renderPresetDates(window.currentShiftInModal || {});
});

// Shift preset date rendering helpers
/**
 * Render per-date schedule cards for the given preset start/end range.
 * Creates inputs named salary_method[preset_dates][i][date|time_start|time_end|lunch_start|lunch_end]
 */
function renderPresetDates(shift){
    const container = document.getElementById('preset-dates-list');
    if(!container) return; 
    container.innerHTML = '';
    const start = document.getElementById('preset_start')?.value;
    const end = document.getElementById('preset_end')?.value;
    if(!start || !end) return;
    const s = new Date(start);
    const e = new Date(end);
    if(s > e) return;

    // format helper
    const fmt = (d) => d.toISOString().slice(0,10);
    const human = (d) => d.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric', weekday: 'long' });

    let idx = 0;
    for(let dt = new Date(s); dt <= e; dt.setDate(dt.getDate()+1)){
        const dateStr = fmt(dt);

        // determine weekday name (e.g. 'Thursday') to default the per-date radio
        const weekday = new Date(dt).toLocaleDateString(undefined, { weekday: 'long' });
        let checkedWork = '';
        let checkedRest = '';
        let checkedOpen = '';
        try {
            if (shift && Array.isArray(shift.work_days) && shift.work_days.includes(weekday)) checkedWork = 'checked';
            else if (shift && Array.isArray(shift.rest_days) && shift.rest_days.includes(weekday)) checkedRest = 'checked';
            else if (shift && Array.isArray(shift.open_time) && shift.open_time.includes(weekday)) checkedOpen = 'checked';
        } catch (e) { /* ignore */ }

        const card = document.createElement('div');
        card.className = 'card mb-2';
        card.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div><strong>${human(new Date(dt))}</strong></div>
                    <div class="text-muted small">${dateStr}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><label>Start</label><input type="time" name="salary_method[preset_dates][${idx}][time_start]" class="form-control" value="${shift.time_start ? shift.time_start.slice(0,5) : ''}"></div>
                    <div class="col-md-3"><label>End</label><input type="time" name="salary_method[preset_dates][${idx}][time_end]" class="form-control" value="${shift.time_end ? shift.time_end.slice(0,5) : ''}"></div>
                    <div class="col-md-3"><label>Lunch Start</label><input type="time" name="salary_method[preset_dates][${idx}][lunch_start]" class="form-control" value="${shift.break_start ? shift.break_start.slice(0,5) : ''}"></div>
                    <div class="col-md-3"><label>Lunch End</label><input type="time" name="salary_method[preset_dates][${idx}][lunch_end]" class="form-control" value="${shift.break_end ? shift.break_end.slice(0,5) : ''}"></div>
                </div>
                <div class="mb-2"><strong>Breaks</strong></div>

                <!-- Per-date customizable type: Work Day / Rest Day / Open Time -->
                <div class="mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="preset_${idx}_work" name="salary_method[preset_dates][${idx}][day_type]" value="work" ${checkedWork}>
                        <label class="form-check-label" for="preset_${idx}_work">Work Day</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="preset_${idx}_rest" name="salary_method[preset_dates][${idx}][day_type]" value="rest" ${checkedRest}>
                        <label class="form-check-label" for="preset_${idx}_rest">Rest Day</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="preset_${idx}_open" name="salary_method[preset_dates][${idx}][day_type]" value="open" ${checkedOpen}>
                        <label class="form-check-label" for="preset_${idx}_open">Open Time</label>
                    </div>
                </div>

                <input type="hidden" name="salary_method[preset_dates][${idx}][date]" value="${dateStr}">
            </div>
        `;
        container.appendChild(card);
        idx++;
    }

    // mark which shift these generated cards belong to so switching templates can clear them
    try {
        const ownerId = (shift && (shift.id || shift.ID)) ? (shift.id || shift.ID).toString() : (document.getElementById('assigned_shift_id')?.value || '');
        container.dataset.generatedFor = ownerId || '';
    } catch(e) { /* ignore */ }
}

// Call render when the preset date inputs change
document.getElementById('preset_start')?.addEventListener('change', function(){ renderPresetDates(window.currentShiftInModal || {}); });
document.getElementById('preset_end')?.addEventListener('change', function(){ renderPresetDates(window.currentShiftInModal || {}); });

// Apply button: explicitly render per-day preset cards when clicked (keeps modal open)
document.getElementById('apply-preset-btn')?.addEventListener('click', function(){
    renderPresetDates(window.currentShiftInModal || {});
});

// Aggregate per-date preset values into the hidden fields expected by the server
function aggregateShiftModalAndPopulateHidden(){
    const container = document.getElementById('preset-dates-list');
    if(!container) return;
    const cards = container.querySelectorAll('.card');
    const work = [], rest = [], openTimes = {};
    let first_time_start = '';
    let first_time_end = '';
    let first_lunch_start = '';
    let first_lunch_end = '';

    cards.forEach(card => {
        const dateInp = card.querySelector('input[name$="[date]"]');
        const date = dateInp ? dateInp.value : null;
        const tstart = card.querySelector('input[name$="[time_start]"]');
        const tend = card.querySelector('input[name$="[time_end]"]');
        const lstart = card.querySelector('input[name$="[lunch_start]"]');
        const lend = card.querySelector('input[name$="[lunch_end]"]');
        // const dayType = card.querySelector('input[type="radio"][name$="[day_type]":checked]') || card.querySelector('input[type="radio"][name$="[day_type]"]:checked');
        const dayTypeInput = card.querySelector('input[type="radio"][name$="[day_type]"]:checked');
        const dayType = dayTypeInput ? dayTypeInput.value : 'work';
        const type = dayType ? dayType.value : 'work';

        if(date){
            // Record the date into the appropriate work/rest arrays
            if(type === 'work') work.push(date);
            else if(type === 'rest') rest.push(date);

            // Always record per-date time details (so server receives the
            // full preset schedule for every date). Include the day_type so
            // consumers can still tell work/rest/open per date.
            openTimes[date] = {
                start: tstart && tstart.value ? tstart.value : null,
                end: tend && tend.value ? tend.value : null,
                lunch_start: lstart && lstart.value ? lstart.value : null,
                lunch_end: lend && lend.value ? lend.value : null,
                day_type: type
            };
        }

        if(!first_time_start && tstart && tstart.value) first_time_start = tstart.value;
        if(!first_time_end && tend && tend.value) first_time_end = tend.value;
        if(!first_lunch_start && lstart && lstart.value) first_lunch_start = lstart.value;
        if(!first_lunch_end && lend && lend.value) first_lunch_end = lend.value;
    });

    const shift = window.currentShiftInModal || {};
    if(!first_time_start && shift.time_start) first_time_start = (shift.time_start||'').slice(0,5);
    if(!first_time_end && shift.time_end) first_time_end = (shift.time_end||'').slice(0,5);
    if(!first_lunch_start && shift.break_start) first_lunch_start = (shift.break_start||'').slice(0,5);
    if(!first_lunch_end && shift.break_end) first_lunch_end = (shift.break_end||'').slice(0,5);

    document.getElementById('custom_time_start_input').value = first_time_start || '';
    document.getElementById('custom_time_end_input').value = first_time_end || '';
    document.getElementById('custom_break_start_input').value = first_lunch_start || '';
    document.getElementById('custom_break_end_input').value = first_lunch_end || '';

    document.getElementById('custom_work_days_input').value = JSON.stringify(work);
    document.getElementById('custom_rest_days_input').value = JSON.stringify(rest);
    // custom_open_time is an object keyed by date → details; controller will json_decode
    document.getElementById('custom_open_time_input').value = JSON.stringify(openTimes);

    // update preview display
    document.getElementById('pv-start').textContent = first_time_start || '-';
    document.getElementById('pv-end').textContent = first_time_end || '-';
    document.getElementById('pv-break-start').textContent = first_lunch_start || '-';
    document.getElementById('pv-break-end').textContent = first_lunch_end || '-';
}

// Save changes button: aggregate values then close modal
document.getElementById('save-shift-modal-btn')?.addEventListener('click', function(){
    aggregateShiftModalAndPopulateHidden();
    // remember that the current assigned_shift now has the saved custom blob
    try {
        window.__initialAssignedShiftId = document.getElementById('assigned_shift_id')?.value || window.__initialAssignedShiftId;
    } catch(e) {}

    // also persist which shift the custom blob belongs to so server can receive it
    try {
        const assigned = document.getElementById('assigned_shift_id')?.value || '';
        if(document.getElementById('custom_for_shift_input')){
            document.getElementById('custom_for_shift_input').value = assigned;
        }
    } catch(e) {}

    try{ $('#shiftModal').modal('hide'); } catch(e){ }
});

// live-update preview + hidden fields while editing per-date times
document.getElementById('preset-dates-list')?.addEventListener('input', function(e){
    if(e.target && e.target.matches('input[type="time"]')){
        aggregateShiftModalAndPopulateHidden();
    }
});

// Live update time preview from custom inputs
document.querySelectorAll('#shiftModal input[type="time"]').forEach(input => {
    input.addEventListener('input', function () {
        const map = {
            'salary_method[custom_time_start]': 'pv-start',
            'salary_method[custom_time_end]': 'pv-end',
            'salary_method[custom_break_start]': 'pv-break-start',
            'salary_method[custom_break_end]': 'pv-break-end',
        };
        const targetId = map[this.name];
        if (targetId) {
            document.getElementById(targetId).textContent = this.value || '-';
        }
    });
});

// Auto-open modal + load existing custom data on edit/validation
$(document).ready(function () {
    const hasShift = {{ old('salary_method.shift_id') ? 'true' : (isset($user) && $user->salaryMethod && $user->salaryMethod->shift_id ? 'true' : 'false') }};

    if (hasShift) {
        $('#shift_select').trigger('change');

        // Trigger input events to update preview from existing custom times
        $('#shiftModal input[type="time"]').each(function() {
            if (this.value) $(this).trigger('input');
        });
    }

});

// Ensure empty input fields get populated from server user object when present.
// This helps when old() returns an empty string and hides existing DB values.
(function(){
    try {
        const serverUser = {!! json_encode($user ?? null) !!};
        if (!serverUser) return;
        const fields = [
            'first_name','last_name','middle_name','name','email','username','mobile_number',
            'biometric_number','id_number','date_of_birth','address','tin','sss_number','phil_health_number',
            'pag_ibig_number','blood_type_id','civil_status_id'
        ];

        fields.forEach(f => {
            try {
                const el = document.querySelector(`[name="${f}"]`);
                if (!el) return;
                // for inputs/selects: if empty (strictly === '') then set server value
                if ((el.value === '' || el.value === null || typeof el.value === 'undefined') && typeof serverUser[f] !== 'undefined' && serverUser[f] !== null) {
                    el.value = serverUser[f];
                }
            } catch(e) { /* ignore per-field errors */ }
        });

        // Special: populate name if empty
        const nameEl = document.querySelector('[name="name"]');
        if (nameEl && (nameEl.value === '' || nameEl.value === null) && serverUser.name) {
            nameEl.value = serverUser.name;
        }
    } catch(e) {
        // ignore JSON/script errors
        console.error('populateFromServer error', e);
    }
})();

document.addEventListener('DOMContentLoaded', () => {
    // Click on "Assign Leave" link in dropdown
    document.querySelectorAll('.assign-leave-inline').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // very important

            const leaveId = this.dataset.leaveId;
            const targetForm = document.getElementById(`assign-form-${leaveId}`);

            if (!targetForm) {
                console.warn(`Form not found for leave ID: ${leaveId}`);
                return;
            }

            // Hide ALL other assign forms first (only one open at a time)
            document.querySelectorAll('.assign-leave-form').forEach(form => {
                form.classList.add('d-none');
            });

            // Show the clicked one
            targetForm.classList.remove('d-none');

            // Focus the days input for better UX
            targetForm.querySelector(`#assign-days-${leaveId}`)?.focus();
        });
    });

    // Save button handler
//    document.addEventListener('click', async e => {
//     if (!e.target.closest('.save-assign-leave')) return;

//     const btn = e.target.closest('.save-assign-leave');
//     const leaveId = btn.dataset.leaveId;
//     const index   = btn.dataset.index;
//     const daysInput = document.getElementById(`assign-days-${leaveId}`);
//     const dateInput = document.getElementById(`assign-date-${leaveId}`);

//     const newDays = parseInt(daysInput?.value.trim() || '0', 10);
//     if (newDays < 1) {
//         alert('Please enter at least 1 day');
//         return;
//     }

//     btn.disabled = true;
//     btn.textContent = 'Saving...';

//     try {
//         const formData = new FormData();
//         formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
//         formData.append('_method', 'PUT');
//         formData.append(`leaves[0][leave_id]`, leaveId);
//         formData.append(`leaves[0][assigned_days]`, newDays);   // or send total if preferred
//         formData.append(`leaves[0][effective_date]`, dateInput.value || '');

//         const response = await fetch(`/users/{{ $user->id }}`, {
//             method: 'POST',
//             body: formData,
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest',
//                 // 'Content-Type': 'application/json'  ← don't set when using FormData
//             }
//         });

//         if (!response.ok) throw new Error('Save failed');

//         // Update visual numbers
//         const mainInput = document.querySelector(`input[name="leaves[${index}][assigned_days]"]`);
//         let current = parseInt(mainInput.value || '0', 10);
//         let total = current + newDays;

//         mainInput.value = total;
//         document.querySelector(`.leave-row[data-leave-id="${leaveId}"] .leave-credits`).textContent = total;

//         const used = parseInt(document.querySelector(`.leave-row[data-leave-id="${leaveId}"] .leave-used`)?.textContent || '0', 10);
//         document.querySelector(`.leave-row[data-leave-id="${leaveId}"] .leave-balance`).textContent = total - used;

//         alert(`Successfully added ${newDays} day(s). New balance: ${total - used}`);
        
//         document.getElementById(`assign-form-${leaveId}`)?.classList.add('d-none');
//         daysInput.value = '1';
//         dateInput.value = '';

//     } catch (err) {
//         alert('Failed to save leave credits.\n' + err.message);
//     } finally {
//         btn.disabled = false;
//         btn.textContent = 'Save';
//     }
// });

document.addEventListener('click', function(e) {
    if (!e.target.classList.contains('save-assign-leave')) return;

    const leaveId   = e.target.dataset.leaveId;
    const index     = e.target.dataset.index;
    const daysInput = document.getElementById(`assign-days-${leaveId}`);
    const dateInput = document.getElementById(`assign-date-${leaveId}`);
    const newDays   = parseInt(daysInput?.value.trim() || '0', 10);

    if (newDays < 1) {
        alert('Please enter at least 1 day.');
        daysInput?.focus();
        return;
    }

    // Get current credits from the span
    const creditsSpan = document.querySelector(`.leave-row[data-leave-id="${leaveId}"] .leave-credits`);
    const current     = parseInt(creditsSpan?.textContent.trim() || '0', 10);
    const updated     = current + newDays;

    // Update visual span
    if (creditsSpan) creditsSpan.textContent = updated;

    // ── CRITICAL: auto-check the checkbox so leave_id is submitted ──
    const checkbox = document.querySelector(`input[name="leaves[${index}][leave_id]"]`);
    if (checkbox) checkbox.checked = true;

    // ── CRITICAL: create or update the hidden assigned_days input ──
    const hiddenName = `leaves[${index}][assigned_days]`;
    let hiddenInput  = document.querySelector(`input[name="${hiddenName}"]`);
    if (!hiddenInput) {
        hiddenInput      = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = hiddenName;
        // Append near the credits span so it's inside the form
        creditsSpan?.parentNode?.appendChild(hiddenInput);
    }
    hiddenInput.value = updated;

    // Update balance display
    const usedEl    = document.querySelector(`.leave-row[data-leave-id="${leaveId}"] .leave-used`);
    const balanceEl = document.querySelector(`.leave-row[data-leave-id="${leaveId}"] .leave-balance`);
    const used      = parseInt(usedEl?.textContent.trim() || '0', 10);
    if (balanceEl) balanceEl.textContent = updated - used;

    // Store date for history modal
    if (dateInput?.value && creditsSpan) {
        creditsSpan.dataset.assignedDate = dateInput.value;
    }

    alert(`Added ${newDays} day(s). New total: ${updated}. Click "Update" to save.`);

    document.getElementById(`assign-form-${leaveId}`)?.classList.add('d-none');
    daysInput.value = '1';
    if (dateInput) dateInput.value = '';
});

});
</script>

<script>
    const assignLeaveButtons = document.querySelectorAll('.assign-leave-inline');
    const assignForms = document.querySelectorAll('.assign-leave-form');

    assignLeaveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const leaveId = this.dataset.leaveId;
            const form = document.getElementById(`assign-form-${leaveId}`);

            // Hide all assign forms
            assignForms.forEach(form => {
                form.classList.add('d-none');
            });

            // Show the specific assign form
            if (form) {
                form.classList.remove('d-none');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const positionSelect = document.getElementById('wi_designation');
        const supervisorSelect = document.getElementById('wi_supervisor');

        if (!positionSelect || !supervisorSelect) return;

        // Store all options once (this captures ALL possible supervisors, even pre-filled ones)
        const allSupervisorOptions = Array.from(supervisorSelect.options);

        function filterSupervisors() {
            const selectedPosition = positionSelect.value.toLowerCase();
            
            // Clear current options except the placeholder
            supervisorSelect.innerHTML = '';
            supervisorSelect.appendChild(allSupervisorOptions[0].cloneNode(true));

            let allowedDesignations = [];

            // Your business rules (customize these strings to match your actual designation names)
            if (selectedPosition === '') {
                allowedDesignations = ['manager', 'supervisor', 'director', 'ceo'];
            } else if (['staff', 'regular', 'employee', 'technician'].includes(selectedPosition)) {
                allowedDesignations = ['manager', 'supervisor', 'director', 'ceo'];
            } else if (selectedPosition === 'supervisor') {
                allowedDesignations = ['manager', 'director', 'ceo']; // only higher-ups
            } else if (selectedPosition === 'manager') {
                allowedDesignations = ['director', 'ceo'];
            } else if (['director', 'ceo', 'president'].includes(selectedPosition)) {
                allowedDesignations = []; // no supervisor needed
            } else {
                // fallback: show everyone
                allowedDesignations = ['manager', 'supervisor', 'director', 'ceo'];
            }

            // Re-add only allowed supervisors
            allSupervisorOptions.forEach(opt => {
                if (opt.value === '') return; // skip placeholder

                const optDesignation = (opt.getAttribute('data-designation') || '').toLowerCase();
                if (allowedDesignations.includes(optDesignation)) {
                    supervisorSelect.appendChild(opt.cloneNode(true));
                }
            });

            // Optional: if current selected supervisor is no longer allowed, reset to empty
            if (!supervisorSelect.querySelector(`option[value="${supervisorSelect.dataset.currentValue || ''}"]`)) {
                supervisorSelect.value = '';
            }
        }

        // Run immediately (important for edit page pre-filled values)
        filterSupervisors();

        // Re-run every time position changes
        positionSelect.addEventListener('change', filterSupervisors);
    });
    </script>
@endsection