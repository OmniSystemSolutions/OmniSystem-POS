<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Spatie\Permission\Models\Permission;
use App\Models\SpouseDetail;
use App\Models\ContactPerson;
use App\Models\SalaryMethod;
use App\Models\EducationalBackground;
use App\Models\Dependent;
use App\Models\EmployeeWorkInformation;
use App\Models\WorkforceShift;
use App\Models\WorkforceAllowance;
use App\Models\WorkLeave;
use App\Models\Designation;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'active'); // default to active
        $perPage = $request->get('per_page', 10);
    // prefer explicit query param, otherwise fall back to the application's
    // currently-selected branch (if any). This makes the users index show
    // users for the active branch by default.
    $branchId = $request->get('branch_id') ?: (function_exists('current_branch_id') ? current_branch_id() : null);

        $validStatuses = ['active', 'resigned', 'terminated'];
        if (!in_array($status, $validStatuses)) {
            $status = 'active';
        }

        $query = User::with([
            'roles:id,name',
            'branches.roles:id,name',
            'employeeWorkInformations.department:id,name',
            'employeeWorkInformations.designation:id,name'
        ])
        ->where('status', $status);

        if (!empty($branchId)) {
            $query->where('branch_id', $branchId);
        }

        $users = $query->paginate($perPage)->appends(array_filter(['status' => $status, 'branch_id' => $branchId]));

        $nextUserId = User::max('id') + 1;
        $roles = Role::all();
        $branches = Branch::all();

        return view('users.index', compact('users', 'nextUserId', 'roles', 'branches', 'status', 'perPage'));
    }


    public function create()
    {
        // Pass roles and branches so the form can render selects
        $roles = Role::all();
        $branches = Branch::all();

        // Pass permissions so the form can show per-branch permission multiselects
        $permissions = Permission::all();
        // workforce reference data for salary method, allowances and leaves
        $shifts = WorkforceShift::all();
        $allowances = WorkforceAllowance::all();
        $leaves = WorkLeave::all();
        // Salary method options (no dedicated table currently)
        $salaryMethods = [
            'cash' => 'Cash',
            'bank' => 'Bank Transfer',
            'check' => 'Check',
            'agency' => 'Agency',
        ];
        // HR reference data
        $designations = Designation::all();
        $departments = Department::all();

        // All possible supervisors (your existing filtered list: Manager/Supervisor/Director/CEO)
        $potentialSupervisors = User::with(['employeeWorkInformations' => function($q) {
            $q->latest('hire_date')->limit(1);
        }])
            ->whereHas('employeeWorkInformations', function($q) {
                $q->whereHas('designation', function($dq) {
                    $dq->whereIn('name', ['Manager', 'Supervisor', 'Director', 'CEO']);
                });
            })
            ->orderBy('username')
            ->get();

        // // Special: users who are currently "Supervisor"
        // $supervisorUsersOnly = $potentialSupervisors->filter(function($user) {
        //     $latest = $user->employeeWorkInformations->first();
        //     return $latest && $latest->designation?->name === 'Supervisor';
        // });

        // list of users for selects (supervisor etc.)
        $users = User::orderBy('username')->get();

        return view('users.form', compact('roles', 'branches', 'potentialSupervisors', 'permissions', 'shifts', 'allowances', 'leaves', 'designations', 'departments', 'salaryMethods', 'users'));
    }

    // Store a newly created user
    public function store(Request $request)
    {
        // Normal processing: handle incoming request and create user
            $hasBasicIdentity = $request->filled('name') || $request->filled('first_name') || $request->filled('last_name') || $request->filled('email');
            $isAccessOnly = ($request->has('allow_db_user') || $request->filled('username')) && !$hasBasicIdentity;

            if ($isAccessOnly) {
                // minimal rules for creating DB credentials independently
                $rules = [
                    'username' => 'required|string|max:255|unique:users,username',
                    'password' => 'required|string|min:4',
                    'branch_permissions' => 'nullable|array',
                    'branch_permissions.*.branch_id' => 'required_with:branch_permissions|exists:branches,id',
                    'branch_permissions.*.permissions' => 'nullable|array',
                    'branch_permissions.*.permissions.*' => 'exists:roles,id',
                    'branch_id' => 'nullable|exists:branches,id',
                    'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                    'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                ];
            } else {
                // Build validation rules for full/basic creation
                $rules = [
                    'last_name' => 'nullable|string|max:255',
                    'first_name' => 'nullable|string|max:255',
                    'middle_name' => 'nullable|string|max:255',
                    // 'name' is not required; we build a display name from first/last if absent
                    'username' => 'nullable|string|max:255|unique:users,username',
                    'email' => 'nullable|string|email|max:255|unique:users,email',
                    'password' => 'nullable|string|min:4',
                    'mobile_number' => 'nullable|string|max:20',
                    'roles' => 'nullable|array',
                    'roles.*' => 'exists:roles,id',
                    'branches' => 'nullable|array',
                    'branches.*' => 'exists:branches,id',
                    'branch_permissions' => 'nullable|array',
                    'branch_permissions.*.branch_id' => 'required_with:branch_permissions|exists:branches,id',
                    'branch_permissions.*.permissions' => 'nullable|array',
                    'branch_permissions.*.permissions.*' => 'exists:roles,id',
                    'branch_id' => 'nullable|exists:branches,id',
                    'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                    'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                    'biometric_number' => 'nullable|string|max:255',
                    'id_number' => 'nullable|string|max:255',
                    'date_of_birth' => 'nullable|date',
                    'age' => 'nullable|integer',
                    // after change: these will store string values
                    'gender_id' => 'nullable|string',
                    'tin' => 'nullable|string|max:255',
                    'sss_number' => 'nullable|string|max:255',
                    'phil_health_number' => 'nullable|string|max:255',
                    'pag_ibig_number' => 'nullable|string|max:255',
                    'blood_type_id' => 'nullable|string',
                    'civil_status_id' => 'nullable|string',
                    'landline_number' => 'nullable|string|max:50',
                    'allow_timekeeper_access' => 'nullable|boolean',
                    'allow_prf_access' => 'nullable|boolean',
                    'allow_inventory_request' => 'nullable|boolean',
                    'allow_processed_goods_logging' => 'nullable|boolean',
                    'allow_sales_report' => 'nullable|boolean',
                    'allow_fund_transfer' => 'nullable|boolean',
                    'allow_liquidation' => 'nullable|boolean',
                    'address' => 'nullable|string|max:255',
                    'spouse' => 'nullable|array',
                    'contact_person' => 'nullable|array',

                    // 'salary_method' => 'nullable|array',
                    // 'salary_method.shift_id' => 'nullable|exists:workforce_shifts,id',

                    // === SALARY METHOD VALIDATION ===
                    'salary_method' => 'nullable|array',
                    'salary_method.method_id' => 'nullable|string|in:cash,bank,check,agency',
                    'salary_method.period_id' => 'nullable|string|in:bi-monthly,monthly,weekly,daily',
                    'salary_method.account' => 'nullable|string|max:255',
                    'salary_method.shift_id' => 'nullable|exists:workforce_shifts,id',
                    'salary_method.custom_time_start' => 'nullable|date_format:H:i',
                    'salary_method.custom_time_end' => 'nullable|date_format:H:i',
                    'salary_method.custom_break_start' => 'nullable|date_format:H:i',
                    'salary_method.custom_break_end' => 'nullable|date_format:H:i',
                    'salary_method.custom_work_days' => 'nullable|string', // JSON string from JS
                    'salary_method.custom_rest_days' => 'nullable|string',
                    'salary_method.custom_open_time' => 'nullable|string',

                    // === ALLOWANCES & LEAVES ===
                    'allowances' => 'nullable|array',
                    'allowances.*.allowance_id' => 'required_with:allowances|exists:workforce_allowances,id',
                    'allowances.*.amount' => 'nullable|numeric',
                    'allowances.*.monthly_count' => 'nullable|integer',
                    'leaves'                  => 'nullable|array',
                    'leaves.*.leave_id'       => 'required_with:leaves|exists:workforce_leaves,id',
                    'leaves.*.assigned_days'  => 'nullable|integer|min:0',
                    'leaves.*.effective_date' => 'nullable|date',
        
                    'educational_backgrounds' => 'nullable|array',
                    'dependents' => 'nullable|array',
                    'employee_work_informations' => 'nullable|array',
                ];
            }

            // log incoming request keys for debugging (will go to storage/logs/laravel.log)
            try {
                Log::info('users.store - incoming', $request->except(['password']));
            } catch (\Throwable $e) {
                // ignore logging errors
            }

            // Pre-filter arrays that the UI renders with an initial empty row so empty rows
            // don't trigger "required_with" / "exists" validation rules.
            $input = $request->all();

            // Normalize branch_permissions: drop entries that are completely empty
            if (!empty($input['branch_permissions']) && is_array($input['branch_permissions'])) {
                $bpFiltered = [];
                foreach ($input['branch_permissions'] as $row) {
                    $hasBranch = isset($row['branch_id']) && $row['branch_id'] !== '' && $row['branch_id'] !== null;
                    $hasPerms = isset($row['permissions']) && is_array($row['permissions']) && count(array_filter($row['permissions'], function($v){ return $v !== null && $v !== ''; })) > 0;
                    if ($hasBranch || $hasPerms) {
                            // normalize permissions: accept either an array or a comma-separated string
                            $permsRaw = $row['permissions'] ?? [];
                            if (!is_array($permsRaw)) {
                                // might be a comma-separated string from the JS widget
                                if (is_string($permsRaw)) {
                                    $permsArr = array_filter(array_map('trim', explode(',', $permsRaw)), function($v){ return $v !== null && $v !== ''; });
                                } else {
                                    $permsArr = [];
                                }
                            } else {
                                $permsArr = array_filter($permsRaw, function($v){ return $v !== null && $v !== ''; });
                            }
                            $row['permissions'] = array_values($permsArr);
                            $bpFiltered[] = $row;
                        }
                }
                $input['branch_permissions'] = $bpFiltered;
            }

            // Normalize allowances: drop empty rows
            if (!empty($input['allowances']) && is_array($input['allowances'])) {
                $alFiltered = [];
                foreach ($input['allowances'] as $al) {
                    $hasAllowance = isset($al['allowance_id']) && $al['allowance_id'] !== '' && $al['allowance_id'] !== null;
                    $hasAmount = isset($al['amount']) && $al['amount'] !== '';
                    $hasMonthly = isset($al['monthly_count']) && $al['monthly_count'] !== '';
                    if ($hasAllowance || $hasAmount || $hasMonthly) {
                        $alFiltered[] = $al;
                    }
                }
                $input['allowances'] = $alFiltered;
            }

            // Normalize leaves: drop rows where leave_id is empty (checkbox not checked)
            if (!empty($input['leaves']) && is_array($input['leaves'])) {
                $lvFiltered = [];
                foreach ($input['leaves'] as $lv) {
                    $hasLeave = isset($lv['leave_id']) && $lv['leave_id'] !== '' && $lv['leave_id'] !== null;
                    $hasAssigned = isset($lv['assigned_days']) && $lv['assigned_days'] !== '';
                    $hasEffective = isset($lv['effective_date']) && $lv['effective_date'] !== '';
                    if ($hasLeave || $hasAssigned || $hasEffective) {
                        // if leave_id empty but assigned_days/effective set, we still keep the row so validation can catch it
                        $lvFiltered[] = $lv;
                    }
                }
                $input['leaves'] = $lvFiltered;
            }

            // You can add similar filters for dependents/leaves/educational_backgrounds if needed.

            // Validate using the cleaned input so blank UI rows are ignored
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                $errors = array_keys($validator->errors()->toArray());
                // decide which tab to show based on error keys
                $tab = 'basic';
                foreach ($errors as $k) {
                    if (Str::startsWith($k, 'branch_permissions') || Str::startsWith($k, 'username') || Str::startsWith($k, 'password')) {
                        $tab = 'access';
                        break;
                    }
                }
                try { Log::warning('users.store - validation_failed', ['errors' => $validator->errors()->toArray()]); } catch (\Throwable $ex) {}
                return redirect()->back()->withErrors($validator)->withInput()->with('active_tab', $tab);
            }

            $validated = $validator->validated();

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('users', 'public');
        }

        
        // Create user
        // Determine username and password to save
        $usernameToSave = $validated['username'] ?? null;
        if (!$usernameToSave) {
            // create a unique fallback username
            $base = Str::slug($validated['name'] ?? ($validated['first_name'] ?? 'user'));
            $candidate = $base ?: 'user';
            $i = 0;
            while (User::where('username', $candidate . ($i ? "-{$i}" : ''))->exists()) {
                $i++;
            }
            $usernameToSave = $candidate . ($i ? "-{$i}" : '');
        }

        $passwordToSave = isset($validated['password']) ? Hash::make($validated['password']) : Hash::make(Str::random(12));

        // Build a display name: prefer provided name, else first+last, else username
        $nameToSave = $validated['name'] ?? null;
        if (empty($nameToSave)) {
            $parts = [];
            if (!empty($validated['first_name'])) $parts[] = $validated['first_name'];
            if (!empty($validated['last_name'])) $parts[] = $validated['last_name'];
            $nameToSave = count($parts) ? implode(' ', $parts) : $usernameToSave;
        }

        // ensure we have an email value to avoid DB NOT NULL constraint
        $emailToSave = $validated['email'] ?? ($usernameToSave . '@gmail.com');

        $user = User::create([
            'branch_id' => $validated['branch_id'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'first_name' => $validated['first_name'] ?? null,
            'middle_name' => $validated['middle_name'] ?? null,
            'name' => $nameToSave,
            'username' => $usernameToSave,
            'email' => $emailToSave,
            'password' => $passwordToSave,
            'mobile_number' => $validated['mobile_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'image' => $imagePath,
            'avatar' => $avatarPath,
            'biometric_number' => $validated['biometric_number'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'age' => $validated['age'] ?? null,
            'gender_id' => $validated['gender_id'] ?? null,
            'tin' => $validated['tin'] ?? null,
            'sss_number' => $validated['sss_number'] ?? null,
            'phil_health_number' => $validated['phil_health_number'] ?? null,
            'pag_ibig_number' => $validated['pag_ibig_number'] ?? null,
            'blood_type_id' => $validated['blood_type_id'] ?? null,
            'civil_status_id' => $validated['civil_status_id'] ?? null,
            'landline_number' => $validated['landline_number'] ?? null,
            'allow_timekeeper_access' => $request->has('allow_timekeeper_access'),
            'allow_prf_access' => $request->has('allow_prf_access'),
            'allow_inventory_request' => $request->has('allow_inventory_request'),
            'allow_processed_goods_logging' => $request->has('allow_processed_goods_logging'),
            'allow_sales_report' => $request->has('allow_sales_report'),
            'allow_fund_transfer' => $request->has('allow_fund_transfer'),
            'allow_liquidation' => $request->has('allow_liquidation'),
            'status' => 'active', // default status
        ]);

        if (!empty($validated['branch_id'])) {
        $user->branches()->syncWithoutDetaching([$validated['branch_id']]);
        // syncWithoutDetaching → adds it if missing, doesn't remove others
    }

        try {
            Log::info('users.store - created_user', ['id' => $user->id, 'username' => $user->username]);
        } catch (\Throwable $e) {}

        // Sync roles only if provided
        if (!empty($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        // Sync branches either from the new branch_permissions rows or from the legacy branches[] input
        if (!empty($validated['branch_permissions'])) {
            $bp = $validated['branch_permissions'];
            $branchIds = [];
            foreach ($bp as $row) {
                if (!empty($row['branch_id'])) {
                    $branchIds[] = $row['branch_id'];
                }
            }
            $user->branches()->sync(array_values(array_unique($branchIds)));
        } elseif (!empty($validated['branches'])) {
            $user->branches()->sync($validated['branches']);
        }

        // Persist branch -> role assignments into branch_role pivot table
        // Also collect role ids so we can assign those roles to the user
        if (!empty($validated['branch_permissions'])) {
            $collectedRoleIds = [];
            foreach ($validated['branch_permissions'] as $row) {
                $branchId = $row['branch_id'] ?? null;
                $rolesForBranch = $row['permissions'] ?? [];
                if (empty($branchId) || !is_array($rolesForBranch) || empty($rolesForBranch)) continue;
                foreach ($rolesForBranch as $roleId) {
                    if (empty($roleId)) continue;
                    $collectedRoleIds[] = $roleId;
                    $exists = DB::table('branch_role')
                        ->where('branch_id', $branchId)
                        ->where('role_id', $roleId)
                        ->exists();
                    if (!$exists) {
                        DB::table('branch_role')->insert([
                            'branch_id' => $branchId,
                            'role_id' => $roleId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Sync user's roles with any roles selected globally plus roles selected per-branch.
            $collectedRoleIds = array_values(array_unique(array_filter($collectedRoleIds)));
            try {
                $existingRoles = $user->roles()->pluck('id')->toArray();
                $finalRoleIds = array_values(array_unique(array_merge($existingRoles, $collectedRoleIds)));
                if (!empty($finalRoleIds)) {
                    $user->roles()->sync($finalRoleIds);
                }
            } catch (\Throwable $e) {
                try { Log::warning('users.store - syncRoles failed', ['error' => $e->getMessage()]); } catch (\Throwable $_) {}
            }
        }

        // Spouse: only create if there is meaningful data
        $s = $validated['spouse'] ?? [];
        if (is_array($s) && array_filter($s)) {
            $spouseModel = SpouseDetail::updateOrCreate(['user_id' => $user->id], [
                'name' => $s['name'] ?? null,
                'date_of_birth' => $s['date_of_birth'] ?? null,
                'age' => $s['age'] ?? null,
            ]);
            try { Log::info('users.store - spouse_saved', ['user_id' => $user->id, 'spouse_id' => $spouseModel->id]); } catch (\Throwable $e) {}
        }

        // Contact person: only create if there is meaningful data
        $c = $validated['contact_person'] ?? [];
        if (is_array($c) && array_filter($c)) {
            $contactModel = ContactPerson::updateOrCreate(['user_id' => $user->id], [
                'name' => $c['name'] ?? null,
                'contact_number' => $c['contact_number'] ?? null,
                'address' => $c['address'] ?? null,
            ]);
            try { Log::info('users.store - contact_saved', ['user_id' => $user->id, 'contact_id' => $contactModel->id]); } catch (\Throwable $e) {}
        }

 // === SALARY METHOD WITH CUSTOM SHIFT & WEEKLY SCHEDULE ===
if (!empty($validated['salary_method'])) {
    $sm = $validated['salary_method'];

    // Decode JSON strings from hidden inputs (or null if empty)
    $customWorkDays = !empty($sm['custom_work_days'])
        ? json_decode($sm['custom_work_days'], true)
        : null;

    $customRestDays = !empty($sm['custom_rest_days'])
        ? json_decode($sm['custom_rest_days'], true)
        : null;

    $customOpenTime = !empty($sm['custom_open_time'])
        ? json_decode($sm['custom_open_time'], true)
        : null;

    // Now re-encode them as JSON strings for DB storage
    SalaryMethod::updateOrCreate(
        ['user_id' => $user->id],
        [
            'method_id'   => $sm['method_id'] ?? null,
            'period_id'   => $sm['period_id'] ?? null,
            'account'     => $sm['account'] ?? null,
            'shift_id'    => $sm['shift_id'] ?? null,

            'custom_time_start'   => $sm['custom_time_start'] ?? null,
            'custom_time_end'     => $sm['custom_time_end'] ?? null,
            'custom_break_start'  => $sm['custom_break_start'] ?? null,
            'custom_break_end'    => $sm['custom_break_end'] ?? null,

            // Encode arrays → JSON strings
            'custom_work_days' => $customWorkDays ? json_encode($customWorkDays) : null,
            'custom_rest_days' => $customRestDays ? json_encode($customRestDays) : null,
            'custom_open_time' => $customOpenTime ? json_encode($customOpenTime) : null,
        ]
    );
}
        // Allowances (pivot)
        if (!empty($validated['allowances'])) {
            $syncAllowances = [];
            foreach ($validated['allowances'] as $al) {
                if (empty($al['allowance_id'])) continue;
                $syncAllowances[$al['allowance_id']] = [
                    'amount' => isset($al['amount']) ? $al['amount'] : null,
                    'monthly_count' => isset($al['monthly_count']) ? $al['monthly_count'] : null,
                ];
            }
            $user->allowances()->sync($syncAllowances);
        }

        // Leaves (pivot)
        if (!empty($validated['leaves'])) {
            $syncLeaves = [];
            foreach ($validated['leaves'] as $lv) {
                if (empty($lv['leave_id'])) continue;
                $syncLeaves[$lv['leave_id']] = [
                    // renamed column from 'days' -> 'assigned_days' and default to 0
                    'assigned_days' => isset($lv['assigned_days']) ? (int)$lv['assigned_days'] : 0,
                    // tracking columns (defaults to 0 when not provided)
                    'earn' => isset($lv['earn']) ? (int)$lv['earn'] : 0,
                    'used' => isset($lv['used']) ? (int)$lv['used'] : 0,
                    'balance' => isset($lv['balance']) ? (int)$lv['balance'] : 0,
                    'effective_date' => isset($lv['effective_date']) ? $lv['effective_date'] : null,
                ];
            }
           $user->leaves()->syncWithoutDetaching($syncLeaves);
        }

        // Educational backgrounds
        if (!empty($validated['educational_backgrounds'])) {
            foreach ($validated['educational_backgrounds'] as $eb) {
                if (empty(array_filter($eb))) continue;
                EducationalBackground::create([
                    'user_id' => $user->id,
                    'name_of_school' => $eb['name_of_school'] ?? null,
                    'level' => $eb['level'] ?? null,
                    'tenure_start' => $eb['tenure_start'] ?? null,
                    'tenure_end' => $eb['tenure_end'] ?? null,
                ]);
            }
        }

        // First delete old attachments if needed (or keep them and just add new)
        $user->attachments()->delete(); // optional: replace all on update

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $attachmentName = $request->input("attachment_names.$index");

                if ($file->isValid() && !empty($attachmentName)) {
                    $filename = $file->getClientOriginalName();
                    $path = $file->storeAs('attachments', $user->id . '_' . time() . '_' . $filename, 'public');

                    Attachment::create([
                        'user_id'    => $user->id,
                        'name'       => $attachmentName,
                        'file_path'  => $path,
                        'file_name'  => $filename,
                        'mime_type'  => $file->getMimeType(),
                    ]);
                }
            }
        }

        // Dependents
        if (!empty($validated['dependents'])) {
            foreach ($validated['dependents'] as $dep) {
                if (empty(array_filter($dep))) continue;
                $depModel = Dependent::create([
                    'user_id' => $user->id,
                    'name' => $dep['name'] ?? null,
                    'birthdate' => $dep['birthdate'] ?? null,
                    'age' => $dep['age'] ?? null,
                    'gender' => $dep['gender'] ?? null,
                    'relationship' => $dep['relationship'] ?? null,
                ]);
                try { Log::info('users.store - dependent_saved', ['user_id' => $user->id, 'dependent_id' => $depModel->id]); } catch (\Throwable $e) {}
            }
        }

        // Employee work informations

            $statusMap = [
                'probationary' => 1,
                'regular'      => 2,
                'promotion'    => 3,
                'contractual'  => 4,
                'resigned'     => 5,
            ];
            foreach ($validated['employee_work_informations'] ?? [] as $wi) {

                $employmentStatusId = $statusMap[$wi['employment_status_id']] ?? null;

                if (empty(array_filter($wi))) continue;
                EmployeeWorkInformation::create([
                    'user_id' => $user->id,
                    'hire_date' => $wi['hire_date'] ?? null,
                    'employment_status_id' => $employmentStatusId,
                    'designation_id' => $wi['designation_id'] ?? null,
                    'department_id' => $wi['department_id'] ?? null,
                    'direct_supervisor' => $wi['direct_supervisor'] ?? null,
                    'monthly_rate' => $wi['monthly_rate'] ?? null,
                    'daily_rate' => $wi['daily_rate'] ?? null,
                    'hourly_rate' => $wi['hourly_rate'] ?? null,
                    'position' => $wi['position'] ?? null,
                ]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    
    // GET: Show the full edit page
    public function edit($id)
    {
        $user = User::with([
            'spouseDetail',
            'contactPerson',
            'salaryMethod',
            'dependents',
            'educationalBackgrounds',
            'employeeWorkInformations',
            'branches',
            'allowances',
            'leaves',
            'attachments',
        ])->findOrFail($id);

        // Same data as create()
    $branches = Branch::all();
    $roles = Role::all();
        $shifts = WorkforceShift::all();
        $allowances = WorkforceAllowance::all();
        $leaves = WorkLeave::all();
        $salaryMethods = [
            'cash' => 'Cash',
            'bank' => 'Bank Transfer',
            'check' => 'Check',
            'agency' => 'Agency',
        ];
        $designations = Designation::all();
        $departments = Department::all();

        $potentialSupervisors = User::with(['employeeWorkInformations' => function($q) {
            $q->latest('hire_date')->limit(1);
        }])
            ->whereHas('employeeWorkInformations.designation', function($q) {
                $q->whereIn('name', ['Manager', 'Supervisor', 'Director', 'CEO']);
            })
            ->orderBy('username')
            ->get();

        $supervisorUsersOnly = $potentialSupervisors->filter(function($user) {
            $latest = $user->employeeWorkInformations->first();
            return $latest && $latest->designation?->name === 'Supervisor';
        });
        
        $users = User::orderBy('username')->get();

        // Extract related data for the view
        $spouse = $user->spouseDetail;
        $contactPerson = $user->contactPerson;
        $dependents = $user->dependents;
        $educationalBackgrounds = $user->educationalBackgrounds;
        $workInformations = $user->employeeWorkInformations;

        // entries for the branch and the user's direct roles.
        $userRoleIds = $user->roles()->pluck('id')->toArray();
        $userBranchPermissions = [];
        foreach ($user->branches as $b) {
            $bpIds = DB::table('branch_role')->where('branch_id', $b->id)->pluck('role_id')->toArray();
            $userBranchPermissions[$b->id] = array_values(array_intersect($bpIds, $userRoleIds));
        }
        
        // (no work info creation should happen in edit() — it's handled on store/update flows)

        return view('users.edit', [
            'user' => $user,
            'branches' => $branches,
            'roles' => $roles,
            'shifts' => $shifts,
            'allowances' => $allowances,
            'leaves' => $leaves,
            'salaryMethods' => $salaryMethods,
            'designations' => $designations,
            'departments' => $departments,
            'users' => $users,
            'spouse' => $spouse,
            'contactPerson' => $contactPerson,
            'dependents' => $dependents,
            'educationalBackgrounds' => $educationalBackgrounds,
            'workInformations' => $workInformations,
            'userBranchPermissions' => $userBranchPermissions,
            'potentialSupervisors' => $potentialSupervisors,
            'supervisorUsersOnly' => $supervisorUsersOnly
        ]);
    }

    public function leaveHistory(User $user, $leaveId)
    {
        $leave = $user->leaves()
            ->wherePivot('leave_id', $leaveId)
            ->withPivot('assigned_days', 'earn', 'used', 'balance', 'effective_date')
            ->first();

        if (!$leave) {
            return response()->json(['credits' => [], 'usages' => [], 'balance' => 0]);
        }

        $pivot   = $leave->pivot;
        $credits = [];

        if (!empty($pivot->assigned_days)) {
            $credits[] = [
                'assigned_days'  => (int) $pivot->assigned_days,
                'effective_date' => $pivot->effective_date,
                'reference'      => 'LC-' . str_pad($leaveId, 2, '0', STR_PAD_LEFT) . '-001',
            ];
        }

        if (!empty($pivot->earn)) {
            $credits[] = [
                'assigned_days'  => (int) $pivot->earn,
                'effective_date' => null,
                'reference'      => 'LC-' . str_pad($leaveId, 2, '0', STR_PAD_LEFT) . '-002',
            ];
        }

        $balance = (int) ($pivot->balance
            ?? (((int)($pivot->assigned_days ?? 0) + (int)($pivot->earn ?? 0)) - (int)($pivot->used ?? 0)));

        return response()->json([
            'credits' => $credits,
            'usages'  => [],   // plug in LeaveRequest query here when ready
            'balance' => $balance,
        ]);
    }

    // PUT/PATCH: Save the updated data
    public function update(Request $request, $id)
    {
        // Reuse almost the same logic as your store() method
        // Just change create() → update(), and use updateOrCreate for related models

        $user = User::findOrFail($id);

        // by strict validation here.
        $rules = [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'username' => 'nullable|unique:users,username,' . $id,
            'branch_id' => 'nullable|exists:branches,id',
            // ... add other rules like in store() if needed
        ];

        $request->validate($rules);

        // Update user fields
        $user->update($request->only([
            'first_name', 'last_name', 'middle_name', 'email', 'mobile_number',
            'biometric_number', 'id_number', 'date_of_birth', 'gender_id',
            'tin', 'phil_health_number', 'pag_ibig_number', 'blood_type_id',
            'civil_status_id', 'address', 'branch_id',
        ]));

        // NOTE: primary-branch handling is performed later after branch_permissions
        // are processed. Do NOT sync here (was re-attaching branches that the
        // user intended to remove in the edit form).

        // Handle image
        if ($request->hasFile('image')) {
            // Optional: delete old image
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('users', 'public');
            $user->save();
        }

        // Update username & password if provided
        if ($request->filled('username')) {
            $user->username = $request->username;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $checkedNames = $request->input('attachment_checked', []);

        // Only run delete if the form actually sent the attachment_checked field at all
        if ($request->filled('attachment_checked') || $request->hasFile('attachments')) {
            $user->attachments()
                ->whereNotIn('name', $checkedNames)
                ->delete();
        }

        // Then handle uploads (your existing code)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $name = $request->input("attachment_names.$index");
                
                // Only process if name exists AND checkbox was checked (extra safety)
                if (!$file->isValid() || empty($name) || !in_array($name, $checkedNames)) {
                    continue;
                }

                $filename = $file->getClientOriginalName();
                $path = $file->storeAs('attachments', $user->id . '_' . time() . '_' . $filename, 'public');

                Attachment::updateOrCreate(
                    ['user_id' => $user->id, 'name' => $name],
                    [
                        'file_path' => $path,
                        'file_name' => $filename,
                        'mime_type' => $file->getMimeType(),
                    ]
                );
            }
        }

        // Update related models (same logic as store, but use updateOrCreate)
        // Spouse
        if ($request->has('spouse')) {
            SpouseDetail::updateOrCreate(
                ['user_id' => $user->id],
                $request->input('spouse')
            );
        }

        // Contact Person
        if ($request->has('contact_person')) {
            ContactPerson::updateOrCreate(
                ['user_id' => $user->id],
                $request->input('contact_person')
            );
        }

        // Dependents: delete old, create new
        $user->dependents()->delete();
        if ($request->has('dependents')) {
            foreach ($request->input('dependents') as $dep) {
                if (array_filter($dep)) {
                    $user->dependents()->create($dep);
                }
            }
        }

        // Educational Backgrounds
        $user->educationalBackgrounds()->delete();
        if ($request->has('educational_backgrounds')) {
            foreach ($request->input('educational_backgrounds') as $eb) {
                if (array_filter($eb)) {
                    $user->educationalBackgrounds()->create($eb);
                }
            }
        }

        // === SALARY METHOD WITH CUSTOM SHIFT & WEEKLY SCHEDULE ===
      if ($request->has('salary_method')) {
    $sm = $request->input('salary_method', []);

    $newShiftId = $sm['shift_id'] ?? null;
    $oldShiftId = $user->salaryMethod->shift_id ?? null;

    $shouldClearCustoms = $newShiftId && $newShiftId != $oldShiftId;

    $customWorkDays   = !empty($sm['custom_work_days'])   ? json_decode($sm['custom_work_days'], true)   : null;
    $customRestDays   = !empty($sm['custom_rest_days'])   ? json_decode($sm['custom_rest_days'], true)   : null;
    $customOpenTime   = !empty($sm['custom_open_time'])   ? json_decode($sm['custom_open_time'], true)   : null;

    // If switching template AND no new custom values were provided → clear them
    if ($shouldClearCustoms && empty($customWorkDays) && empty($customRestDays) && empty($customOpenTime)) {
        $customWorkDays = null;
        $customRestDays = null;
        $customOpenTime = null;
    }

    SalaryMethod::updateOrCreate(
        ['user_id' => $user->id],
        [
            'method_id'   => $sm['method_id'] ?? null,
            'period_id'   => $sm['period_id'] ?? null,
            'account'     => $sm['account'] ?? null,
            'shift_id'    => $newShiftId,

            'custom_time_start'   => $sm['custom_time_start'] ?? null,
            'custom_time_end'     => $sm['custom_time_end'] ?? null,
            'custom_break_start'  => $sm['custom_break_start'] ?? null,
            'custom_break_end'    => $sm['custom_break_end'] ?? null,

            'custom_work_days'    => $customWorkDays   ? json_encode($customWorkDays)   : null,
            'custom_rest_days'    => $customRestDays   ? json_encode($customRestDays)   : null,
            'custom_open_time'    => $customOpenTime   ? json_encode($customOpenTime)   : null,
        ]
    );
}

        // Allowances (pivot)
        if ($request->has('allowances')) {
            $syncAllowances = [];
            foreach ($request->input('allowances', []) as $al) {
                if (empty($al['allowance_id'])) continue;
                $syncAllowances[$al['allowance_id']] = [
                    'amount' => isset($al['amount']) ? $al['amount'] : null,
                    'monthly_count' => isset($al['monthly_count']) ? $al['monthly_count'] : null,
                ];
            }
            $user->allowances()->sync($syncAllowances);
        }

   // Leaves (pivot table) - FULL replacement on update
if ($request->has('leaves') || $request->filled('leaves')) {
    $syncLeaves = [];

    foreach ($request->input('leaves', []) as $lv) {
        if (empty($lv['leave_id'])) {
            continue;
        }

        $syncLeaves[$lv['leave_id']] = [
            'assigned_days'   => (int) ($lv['assigned_days'] ?? 0),
            'earn'            => (int) ($lv['earn'] ?? 0),
            'used'            => (int) ($lv['used'] ?? 0),
            'balance'         => (int) ($lv['balance'] ?? 0),
            'effective_date'  => $lv['effective_date'] ?? null,
            // Optional: updated_at if you want to force timestamp update
            'updated_at'      => now(),
        ];
    }

    // This is the KEY CHANGE:
    // Use sync() → completely replaces the current pivot records with what was submitted
   $user->leaves()->syncWithoutDetaching($syncLeaves);

    // Optional: recalculate balance if you have business logic
    foreach ($syncLeaves as $leaveId => $data) {
        $user->leaves()->updateExistingPivot($leaveId, [
            'balance' => ($data['assigned_days'] + $data['earn']) - $data['used'],
        ]);
    }
} else {
    // If no leaves were submitted at all → optionally detach all
    // $user->leaves()->detach();  // ← only if you want to clear everything when unchecked
}

        // Work Informations
        $user->employeeWorkInformations()->delete();
        if ($request->has('employee_work_informations')) {
            foreach ($request->input('employee_work_informations') as $wi) {
                if (array_filter($wi)) {
                    $user->employeeWorkInformations()->create($wi);
                }
            }
        }

       // === Branch Permissions & Primary Branch handling ===
$input = $request->all();

// 1. Handle branch_permissions (multi-branch + roles) if submitted meaningfully
$bpFiltered = [];
if (!empty($input['branch_permissions']) && is_array($input['branch_permissions'])) {
    foreach ($input['branch_permissions'] as $row) {
        $hasBranch = !empty($row['branch_id']);
        $hasPerms = !empty($row['permissions']) && (
            (is_array($row['permissions']) && count(array_filter($row['permissions']))) ||
            (is_string($row['permissions']) && trim($row['permissions']))
        );

        if ($hasBranch || $hasPerms) {
            // Normalize permissions
            $permsRaw = $row['permissions'] ?? [];
            $permsArr = is_array($permsRaw)
                ? array_filter($permsRaw)
                : array_filter(array_map('trim', explode(',', $permsRaw ?? '')));

            $row['permissions'] = array_values($permsArr);
            $bpFiltered[] = $row;
        }
    }
}

// 2. Collect branches to sync
$branchesToSync = [];

// If branch_permissions were used meaningfully
if (!empty($bpFiltered)) {
    foreach ($bpFiltered as $row) {
        if (!empty($row['branch_id'])) {
            $branchesToSync[] = $row['branch_id'];
        }
    }
    // Also sync any direct branches[] if present (rare case)
    if ($request->has('branches')) {
        $branchesToSync = array_merge($branchesToSync, $request->input('branches', []));
    }
}
// Fallback: use branches[] directly (most common case when only primary branch is changed)
elseif ($request->has('branches')) {
    $branchesToSync = $request->input('branches', []);
}

// 3. Actually sync branches
// If branch_permissions were submitted (even if empty) we treat that as an
// explicit replacement of the user's branches. This allows removing all
// branches by submitting an empty set. Otherwise fall back to the legacy
// `branches[]` input.
if (!empty($bpFiltered)) {
    $user->branches()->sync(array_unique($branchesToSync));
} elseif ($request->has('branches')) {
    $user->branches()->sync($request->input('branches', []));
}

// 3.a Persist any branch -> role assignments submitted via branch_permissions
// We will replace the branch_role rows for each branch with the submitted
// role set (so unselected roles are removed). Then compute the final set of
// user role ids as the union of explicitly-selected global roles + all
// submitted branch roles, and sync the user's roles to that set (removing
// roles that were unchecked).
if (!empty($bpFiltered)) {
    $collectedRoleIds = [];

    foreach ($bpFiltered as $row) {
        $branchId = $row['branch_id'] ?? null;
        $rolesForBranch = is_array($row['permissions']) ? $row['permissions'] : [];
        if (empty($branchId)) continue;

        // Normalize role ids to integers and remove empty values
        $submitted = array_values(array_filter(array_map(function($v){ return is_numeric($v) ? (int)$v : null; }, $rolesForBranch)));

        // Existing roles for this branch
        $existing = DB::table('branch_role')->where('branch_id', $branchId)->pluck('role_id')->toArray();

        // Roles to delete (existing but not submitted)
        $toDelete = array_diff($existing, $submitted);
        if (!empty($toDelete)) {
            DB::table('branch_role')->where('branch_id', $branchId)->whereIn('role_id', $toDelete)->delete();
        }

        // Roles to insert (submitted but not existing)
        $toInsert = array_diff($submitted, $existing);
        foreach ($toInsert as $rid) {
            DB::table('branch_role')->insert([
                'branch_id' => $branchId,
                'role_id' => $rid,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Collect for user role sync
        $collectedRoleIds = array_merge($collectedRoleIds, $submitted);
    }

    // Final user roles: union of explicit global roles (if any) + branch-selected roles
    $explicitRoles = $request->input('roles', []);
    $explicitRoles = is_array($explicitRoles) ? array_map('intval', $explicitRoles) : [];

    $collectedRoleIds = array_values(array_unique(array_filter($collectedRoleIds)));
    $finalRoleIds = array_values(array_unique(array_merge($explicitRoles, $collectedRoleIds)));

    try {
        $user->roles()->sync($finalRoleIds);
    } catch (\Throwable $e) {
        try { Log::warning('users.update - syncRoles failed', ['error' => $e->getMessage()]); } catch (\Throwable $_) {}
    }
}

// 4. Update primary branch_id column (always, if submitted)
if ($request->filled('branch_id')) {
    $user->branch_id = $request->input('branch_id');
    $user->save();
} elseif ($request->has('branches') && count($request->input('branches')) === 1) {
    // If only one branch was sent via branches[], set it as primary
    $user->branch_id = $request->input('branches')[0];
    $user->save();
}
        return redirect()->route('users.index')->with('success', 'Employee updated successfully!');
    }

    // Display the specified user
    public function show($id)
    {
    $user = User::findOrFail($id);

    return view('users.show', compact('user'));
    }

    // Remove the specified user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
            return redirect()
        ->route('users.index') 
        ->with('success', 'User deleted successfully.');
    }

    public function viewProfile($id)
    {
        $user = User::findOrFail($id);

        // Load a Blade view and pass user data to it
        $pdf = Pdf::loadView('users.profile-pdf', compact('user'));

        // Download directly
        return $pdf->download($user->name . '.pdf');
    }

    public function archive(User $user)
    {
        $user->update(['status' => 'archived']);
        return redirect()->route('users.index', ['status' => 'active'])
                        ->with('success', 'User moved to archive.');
    }

    public function restore(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->route('users.index', ['status' => 'archived'])
                        ->with('success', 'User restored successfully.');
    }

    public function updateStatus(User $user, $status)
    {
        $validStatuses = ['active', 'resigned', 'terminated'];

        if (!in_array($status, $validStatuses)) {
            return back()->with('error', 'Invalid status');
        }

        $user->status = $status;
        $user->save();

        return back()->with('success', 'User status updated to ' . ucfirst($status));
    }

}
