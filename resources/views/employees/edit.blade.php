@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-primary fw-bold mb-3">Edit Employee</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('clients.show', $employee->client_id) }}" class="text-decoration-none">Client Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('clients.show', $employee->client_id) }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Client Details
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-3">
                        <div class="list-group-item bg-primary text-white py-3">
                            <i class="fas fa-tasks me-2"></i>Form Progress
                            <div class="small opacity-75">Complete all sections</div>
                        </div>
                        <button type="button" class="list-group-item list-group-item-action active py-3" data-section="personal-details">
                            <i class="fas fa-user text-primary me-2"></i>Personal Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action py-3" data-section="employment-details">
                            <i class="fas fa-briefcase text-info me-2"></i>Employment Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action py-3" data-section="salary-details">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>Salary Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action py-3" data-section="bank-details">
                            <i class="fas fa-university text-warning me-2"></i>Bank Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action py-3" data-section="statutory-details">
                            <i class="fas fa-file-contract text-danger me-2"></i>Statutory Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action py-3" data-section="documents">
                            <i class="fas fa-file-upload text-purple me-2"></i>Documents
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Personal Details Section -->
                        <div class="form-section active" id="personal-details">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h5 class="mb-0">Personal Details</h5>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        id="firstName" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control @error('status') is-invalid @enderror"
                                        id="status" name="status" value="{{ old('status', $employee->status) }}" required>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                                        id="middleName" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}">
                                    @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="lastName" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-4">
                                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="dateOfBirth" name="date_of_birth" value="{{ old('date_of_birth', \Carbon\Carbon::parse($employee->dob)->format('Y-m-d')) }}">

                                    @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="maritalStatus" class="form-label">Marital Status</label>
                                    <select class="form-select @error('marital_status') is-invalid @enderror"
                                        id="maritalStatus" name="marital_status" required>
                                        <option value="">Select Status</option>
                                        <option value="single" {{ old('marital_status', $employee->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                        <option value="married" {{ old('marital_status', $employee->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="divorced" {{ old('marital_status', $employee->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="widowed" {{ old('marital_status', $employee->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-12">
                                    <label for="currentAddress" class="form-label">Current Address</label>
                                    <textarea class="form-control @error('current_address') is-invalid @enderror"
                                        id="currentAddress" name="current_address" rows="3">{{ old('current_address', $employee->current_address) }}</textarea>
                                    @error('current_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-section px-4" data-next="employment-details">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Employment Details Section -->
                        <div class="form-section" id="employment-details">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <h5 class="mb-0">Employment Details</h5>
                            </div>

                            <div class="row g-4">
                                <!-- Employee ID (readonly) -->
                                <div class="col-md-6">
                                    <label for="employeeId" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="employeeId" name="employee_id" value="{{ $employee->id }}" readonly>
                                </div>
                                <!-- Reporting To -->
                                <div class="col-md-6">
                                    <label for="reporting" class="form-label">Reporting To</label>
                                    <input type="text" class="form-control @error('reporting') is-invalid @enderror"
                                        id="reporting" name="reporting" value="{{ old('reporting', $employee->reporting) }}">
                                    @error('reporting')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror"
                                        id="department" name="department" value="{{ old('department', $employee->department) }}" required>
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                        id="designation" name="designation" value="{{ old('designation', $employee->designation) }}" required>
                                    @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="joiningDate" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror"
                                        id="joiningDate" name="joining_date" value="{{ old('joining_date', $employee->joining_date) }}" required>
                                    @error('joining_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="employmentType" class="form-label">Employment Type</label>
                                    <select class="form-select @error('emp_type') is-invalid @enderror"
                                        id="employmentType" name="emp_type" required>
                                        <option value="">Select Employment Type</option>
                                        <option value="full-time" {{ old('emp_type', $employee->emp_type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part-time" {{ old('emp_type', $employee->emp_type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('emp_type', $employee->emp_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="temporary" {{ old('emp_type', $employee->emp_type) == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                    </select>
                                    @error('emp_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="employeeCategory" class="form-label">Employee Category</label>
                                    <select class="form-select @error('emp_category') is-invalid @enderror"
                                        id="employeeCategory" name="emp_category" required>
                                        <option value="">Select Employee Category</option>
                                        <option value="permanent" {{ old('emp_category', $employee->emp_category) == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                        <option value="probation" {{ old('emp_category', $employee->emp_category) == 'probation' ? 'selected' : '' }}>Probation</option>
                                        <option value="notice-period" {{ old('emp_category', $employee->emp_category) == 'notice-period' ? 'selected' : '' }}>Notice Period</option>
                                    </select>
                                    @error('emp_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-section px-4" data-next="salary-details">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Salary Details Section -->
                        <div class="form-section" id="salary-details">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-money-bill"></i>
                                </div>
                                <h5 class="mb-0">Salary Details</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="basicDa" class="form-label">Basic & DA</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('basic_da') is-invalid @enderror"
                                            id="basicDa" name="basic_da" value="{{ old('basic_da', $employee->salaryDetails->basic_da) }}" required>
                                    </div>
                                    @error('basic_da')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="hra" class="form-label">HRA</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('hra') is-invalid @enderror"
                                            id="hra" name="hra" value="{{ old('hra', $employee->salaryDetails->hra) }}">
                                    </div>
                                    @error('hra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="medicalAllowance" class="form-label">Medical Allowance</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('medical_allowance') is-invalid @enderror"
                                            id="medicalAllowance" name="medical_allowance" value="{{ old('medical_allowance', $employee->salaryDetails->medical_allowance) }}">
                                    </div>
                                    @error('medical_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="conveyance" class="form-label">Conveyance</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('conveyance') is-invalid @enderror"
                                            id="conveyance" name="conveyance" value="{{ old('conveyance', $employee->salaryDetails->conveyance) }}">
                                    </div>
                                    @error('conveyance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="statutoryBonus" class="form-label">Statutory Bonus</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('statutory_bonus') is-invalid @enderror"
                                            id="statutoryBonus" name="statutory_bonus" value="{{ old('statutory_bonus', $employee->salaryDetails->statutory_bonus) }}">
                                    </div>
                                    @error('statutory_bonus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="elEncashment" class="form-label">EL Encashment</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('el_encashment') is-invalid @enderror"
                                            id="elEncashment" name="el_encashment" value="{{ old('el_encashment', $employee->salaryDetails->el_encashment) }}">
                                    </div>
                                    @error('el_encashment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="specialAllowance" class="form-label">Special Bonus</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('special_allowance') is-invalid @enderror"
                                            id="specialAllowance" name="special_allowance" value="{{ old('special_allowance', $employee->salaryDetails->special_allowance) }}">
                                    </div>
                                    @error('special_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="otherAllowance" class="form-label">Other Allowance</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control @error('other_allowance') is-invalid @enderror"
                                            id="otherAllowance" name="other_allowance" value="{{ old('other_allowance', $employee->salaryDetails->other_allowance) }}">
                                    </div>
                                    @error('other_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-primary prev-section" data-prev="employment-details">
                                    <i class="fas fa-arrow-left me-2"></i>Previous Step
                                </button>
                                <button type="button" class="btn btn-primary next-section" data-next="bank-details">
                                    Next Step<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Bank Details Section -->
                        <div class="form-section" id="bank-details">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-university"></i>
                                </div>
                                <h5 class="mb-0">Bank Details</h5>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="bankName" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                        id="bankName" name="bank_name" value="{{ old('bank_name', $employee->bankDetails->bank_name) }}" required>
                                    @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="branchName" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control @error('branch_name') is-invalid @enderror"
                                        id="branchName" name="branch_name" value="{{ old('branch_name', $employee->bankDetails->branch_name) }}" required>
                                    @error('branch_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="act_holder_name" class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control @error('act_holder_name') is-invalid @enderror"
                                        id="act_holder_name" name="act_holder_name" value="{{ old('act_holder_name', $employee->bankDetails->act_holder_name) }}" required>
                                    @error('act_holder_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="accountNumber" class="form-label">Account Number</label>
                                    <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                        id="accountNumber" name="account_number" value="{{ old('account_number', $employee->bankDetails->account_number) }}" required>
                                    @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="ifscCode" class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                        id="ifscCode" name="ifsc_code" value="{{ old('ifsc_code', $employee->bankDetails->ifsc_code) }}" required>
                                    @error('ifsc_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="upiId" class="form-label">UPI ID</label>
                                    <input type="text" class="form-control @error('upi_id') is-invalid @enderror"
                                        id="upiId" name="upi_id" value="{{ old('upi_id', $employee->bankDetails->upi_id) }}" required>
                                    @error('upi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-section px-4" data-next="statutory-details">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Statutory Details Section -->
                        <div class="form-section" id="statutory-details">
                            <h5 class="mb-4">Statutory Details</h5>

                            <!-- Statutory Toggles -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pfEnabled" name="pf_enabled"
                                            {{ old('pf_enabled', $employee->pf_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pfEnabled">Enable PF</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="esiEnabled" name="esi_enabled"
                                            {{ old('esi_enabled', $employee->esi_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="esiEnabled">Enable ESI</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="ptEnabled" name="pt_enabled"
                                            {{ old('pt_enabled', $employee->pt_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ptEnabled">Enable PT</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="uan" class="form-label">UAN</label>
                                    <input type="text" class="form-control @error('uan') is-invalid @enderror"
                                        id="uan" name="uan" value="{{ old('uan_number', $employee->statutoryDetails->uan_number) }}" required>
                                    @error('uan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="esiNumber" class="form-label">ESI Number</label>
                                    <input type="text" class="form-control @error('esi_number') is-invalid @enderror"
                                        id="esiNumber" name="esi_number" value="{{ old('esi_number', $employee->statutoryDetails->esi_number) }}" required>
                                    @error('esi_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-6">
                                    <label for="emp_state_code" class="form-label">Employee State Code</label>
                                    <input type="text" class="form-control @error('emp_state_code') is-invalid @enderror"
                                        id="emp_state_code" name="emp_state_code" value="{{ old('emp_state_code', $employee->statutoryDetails->emp_state_code) }}" required>
                                    @error('emp_state_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nomineeName" class="form-label">Nominee Name</label>
                                    <input type="text" class="form-control @error('nominee_name') is-invalid @enderror"
                                        id="nomineeName" name="nominee_name" value="{{ old('nominee_name', $employee->statutoryDetails->nominee_name) }}" required>
                                    @error('nominee_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4 mt-2">
                                <div class="col-md-12">
                                    <label for="nominee_relation" class="form-label">Nominee Relationship</label>
                                    <input type="text" class="form-control @error('nominee_relation') is-invalid @enderror"
                                        id="nominee_relation" name="nominee_relation" value="{{ old('nominee_relation', $employee->statutoryDetails->nominee_relation) }}" required>
                                    @error('nominee_relation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-section px-4" data-next="documents">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="form-section" id="documents">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-file-upload"></i>
                                </div>
                                <h5 class="mb-0">Documents</h5>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="aadharCard" class="form-label">Upload Aadhaar Card</label>
                                    <input type="file" class="form-control @error('aadhar_card') is-invalid @enderror"
                                        id="aadharCard" name="aadhar_card" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('aadhar_card')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($employee->aadhar_card)
                                    <div class="mt-2">
                                        <small class="text-muted">Current file: {{ basename($employee->aadhar_card) }}</small>
                                        <a href="{{ asset('http://localhost/hrm-laraval/storage/' . $employee->aadhar_card) }}" target="_blank" class="btn btn-sm btn-info ms-2">View</a>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="panCard" class="form-label">Upload PAN Card</label>
                                    <input type="file" class="form-control @error('pan_card') is-invalid @enderror"
                                        id="panCard" name="pan_card" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('pan_card')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($employee->pan_card)
                                    <div class="mt-2">
                                        <small class="text-muted">Current file: {{ basename($employee->pan_card) }}</small>
                                        <a href="{{ asset('http://localhost/hrm-laraval/storage/' . $employee->pan_card) }}" target="_blank" class="btn btn-sm btn-info ms-2">View</a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    Update <i class="fas fa-save ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #344767;
    }

    .form-control,
    .form-select {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        border-radius: 0.5rem;
        border: 1px solid #e9ecef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: rgba(var(--bs-primary-rgb), 0.5);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.1);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
    }

    .input-group>.form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .form-section {
        display: none;
    }

    .form-section.active {
        display: block;
    }

    .form-floating>label {
        padding-left: 1rem;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .text-purple {
        color: #6f42c1;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = ['personal-details', 'employment-details', 'salary-details', 'bank-details', 'statutory-details', 'documents'];

        // Handle section navigation
        document.querySelectorAll('[data-section]').forEach(button => {
            button.addEventListener('click', function() {
                const targetSection = this.dataset.section;

                // Update active section
                document.querySelectorAll('.form-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(targetSection).classList.add('active');

                // Update active button
                document.querySelectorAll('[data-section]').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Handle next section buttons
        document.querySelectorAll('.next-section').forEach(button => {
            button.addEventListener('click', function() {
                const nextSection = this.dataset.next;
                document.querySelector(`[data-section="${nextSection}"]`).click();
            });
        });
    });
</script>
@endpush

@endsection