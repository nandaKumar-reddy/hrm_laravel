@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-primary fw-bold mb-0">Add New Employee</h4>
        <a href="{{ route('clients.show', $selectedClient) }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Client Details
        </a>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-3">
                        <div class="list-group-item bg-primary text-white py-3">
                            <i class="fas fa-tasks me-2"></i>Form Progress
                            <div class="small opacity-75">Complete all sections</div>
                        </div>
                        <a href="#personal-details" class="list-group-item list-group-item-action active" data-section="personal-details">
                            <i class="fas fa-user me-2"></i>Personal Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </a>
                        <a href="#employment-details" class="list-group-item list-group-item-action" data-section="employment-details">
                            <i class="fas fa-briefcase me-2"></i>Employment Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </a>
                        <a href="#salary-details" class="list-group-item list-group-item-action" data-section="salary-details">
                            <i class="fas fa-money-bill-wave me-2"></i>Salary Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </a>
                        <a href="#bank-details" class="list-group-item list-group-item-action" data-section="bank-details">
                            <i class="fas fa-university me-2"></i>Bank Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </a>
                        <a href="#statutory-details" class="list-group-item list-group-item-action" data-section="statutory-details">
                            <i class="fas fa-file-contract me-2"></i>Statutory Details
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </a>
                        <a href="#documents" class="list-group-item list-group-item-action" data-section="documents">
                            <i class="fas fa-file-upload me-2"></i>Documents
                            <span class="float-end"><i class="fas fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                        @csrf

                        <!-- <div class="mb-3">
                            <label for="client_id" class="form-label">Client</label>
                            <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }} ({{ $client->client_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->

                        <!-- <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" disabled>
                            <small class="text-muted">This ID will be automatically generated when the employee is created</small>
                        </div> -->

                        <!-- Personal Details Section -->
                        <div class="form-section active" id="personal-details">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h5 class="mb-0">Personal Details</h5>
                            </div>

                            <div class="row g-3">
                            <!-- <div class="col-md-4">
                                    <label for="client_id" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('client_id') is-invalid @enderror" 
                                           id="client_id" name="client_id" value="{{ old('client_id') }}" required>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> -->
                                <input type="hidden" name="client_id" value="{{ request('client_id') }}">

                                <div class="col-md-4">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="firstName" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="middleName" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                                           id="middleName" name="middle_name" value="{{ old('middle_name') }}">
                                    @error('middle_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="lastName" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="dateOfBirth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="maritalStatus" class="form-label">Marital Status</label>
                                    <select class="form-select @error('marital_status') is-invalid @enderror" 
                                            id="maritalStatus" name="marital_status" required>
                                        <option value="">Select Status</option>
                                        <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                        <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                        <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="currentAddress" class="form-label">Current Address</label>
                                    <textarea class="form-control @error('current_address') is-invalid @enderror" 
                                              id="currentAddress" name="current_address" rows="3">{{ old('current_address') }}</textarea>
                                    @error('current_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-primary next-section" data-next="employment-details">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Employment Details Section -->
                        <div class="form-section" id="employment-details">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <h5 class="mb-0">Employment Details</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                                           id="department" name="department" value="{{ old('department') }}" required>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                                           id="designation" name="designation" value="{{ old('designation') }}" required>
                                    @error('designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="joiningDate" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror" 
                                           id="joiningDate" name="joining_date" value="{{ old('joining_date') }}" required>
                                    @error('joining_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="empType" class="form-label">Employment Type</label>
                                    <select class="form-select @error('emp_type') is-invalid @enderror" 
                                            id="empType" name="emp_type" required>
                                        <option value="">Select Employment Type</option>
                                        <option value="full-time" {{ old('emp_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part-time" {{ old('emp_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('emp_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="temporary" {{ old('emp_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                    </select>
                                    @error('emp_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="empCategory" class="form-label">Employee Category</label>
                                    <select class="form-select @error('emp_category') is-invalid @enderror" 
                                            id="empCategory" name="emp_category" required>
                                        <option value="">Select Employee Category</option>
                                        <option value="permanent" {{ old('emp_category') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                                        <option value="probation" {{ old('emp_category') == 'probation' ? 'selected' : '' }}>Probation</option>
                                        <option value="notice-period" {{ old('emp_category') == 'notice-period' ? 'selected' : '' }}>Notice Period</option>
                                    </select>
                                    @error('emp_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- <div class="col-md-6">
                                    <label for="reporting" class="form-label">Reporting To</label>
                                    <input type="text" class="form-control @error('reporting') is-invalid @enderror" 
                                           id="reporting" name="reporting_to" value="{{ old('reporting') }}">
                                    @error('reporting')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> -->
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-outline-primary prev-section" data-prev="personal-details">
                                    <i class="fas fa-arrow-left me-2"></i>Previous Step
                                </button>
                                <button type="button" class="btn btn-primary next-section" data-next="salary-details">
                                    Next Step<i class="fas fa-arrow-right ms-2"></i>
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
                                               id="basicDa" name="basic_da" value="{{ old('basic_da') }}" required>
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
                                               id="hra" name="hra" value="{{ old('hra') }}">
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
                                               id="medicalAllowance" name="medical_allowance" value="{{ old('medical_allowance') }}">
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
                                               id="conveyance" name="conveyance" value="{{ old('conveyance') }}">
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
                                               id="statutoryBonus" name="statutory_bonus" value="{{ old('statutory_bonus') }}">
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
                                               id="elEncashment" name="el_encashment" value="{{ old('el_encashment') }}">
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
                                               id="specialAllowance" name="special_allowance" value="{{ old('special_allowance') }}">
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
                                               id="otherAllowance" name="other_allowance" value="{{ old('other_allowance') }}">
                                    </div>
                                    @error('other_allowance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
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
                            <h5 class="mb-3">Bank Details</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bankName" class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" id="bankName" name="bank_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="branchName" class="form-label">Branch Name</label>
                                        <input type="text" class="form-control" id="branchName" name="branch_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="act_holder_name" class="form-label">Account Holder Name</label>
                                        <input type="text" class="form-control" id="act_holder_name" name="act_holder_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="accountNumber" class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="accountNumber" name="account_number">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ifscCode" class="form-label">IFSC Code</label>
                                        <input type="text" class="form-control" id="ifscCode" name="ifsc_code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="upiId" class="form-label">UPI ID</label>
                                        <input type="text" class="form-control" id="upiId" name="upi_id">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-secondary prev-section">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <button type="button" class="btn btn-primary next-section">
                                    Next <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Statutory Details Section -->
                        <div class="form-section" id="statutory-details">
                            <h5 class="mb-3">Statutory Details</h5>
                            
                            <!-- Statutory Toggles -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="pfEnabled" name="pf_enabled" 
                                               {{ old('pf_enabled', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pfEnabled">Enable PF</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="esiEnabled" name="esi_enabled" 
                                               {{ old('esi_enabled', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="esiEnabled">Enable ESI</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="ptEnabled" name="pt_enabled" 
                                               {{ old('pt_enabled', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ptEnabled">Enable PT</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="uan_number" class="form-label">UAN</label>
                                        <input type="text" class="form-control" id="uan_number" name="uan_number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="esiNumber" class="form-label">ESI Number</label>
                                        <input type="text" class="form-control" id="esiNumber" name="esi_number">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="emp_state_code" class="form-label">Employee State Code</label>
                                        <input type="text" class="form-control" id="emp_state_code" name="emp_state_code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nomineeName" class="form-label">Nominee Name</label>
                                        <input type="text" class="form-control" id="nomineeName" name="nominee_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nominee_contact_num" class="form-label">Nominee Contact Numaber</label>
                                        <input type="text" class="form-control" id="nominee_contact_num" name="nominee_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nominee_relation" class="form-label">Nominee Relationship</label>
                                        <input type="text" class="form-control" id="nominee_relation" name="nominee_relation">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-secondary prev-section">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <button type="button" class="btn btn-primary next-section">
                                    Next <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="form-section" id="documents">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white p-3 me-3">
                                    <i class="fas fa-file-upload"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Upload Documents</h5>
                                    <p class="text-muted mb-0">Upload required employee documents</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- Aadhar Card -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="fas fa-id-card me-2"></i>Aadhar Card
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <div class="mb-3">
                                                <input type="file" class="form-control @error('aadhar_card') is-invalid @enderror" 
                                                       name="aadhar_card" accept=".pdf,.jpg,.jpeg,.png" required>
                                                @error('aadhar_card')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PAN Card -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="fas fa-id-badge me-2"></i>PAN Card
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <div class="mb-3">
                                                <input type="file" class="form-control @error('pan_card') is-invalid @enderror" 
                                                       name="pan_card" accept=".pdf,.jpg,.jpeg,.png" required>
                                                @error('pan_card')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <button type="button" class="btn btn-outline-secondary prev-section" data-prev="statutory-details">
                                    <i class="fas fa-arrow-left me-2"></i> Previous
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Submit <i class="fas fa-check ms-2"></i>
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
.form-section {
    display: none;
    transition: all 0.3s ease;
}

.form-section.active {
    display: block;
}

.form-floating {
    position: relative;
}

.form-floating > .form-control,
.form-floating > .form-select {
    height: calc(3.5rem + 2px);
    padding: 1rem 0.75rem;
}

.form-floating > label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem 0.75rem;
    pointer-events: none;
    border: 1px solid transparent;
    transform-origin: 0 0;
    transition: opacity .1s ease-in-out,transform .1s ease-in-out;
}

.list-group-item {
    border: none;
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.list-group-item:last-child {
    border-bottom: none;
}

.list-group-item.active {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    color: var(--bs-primary);
    border-color: rgba(var(--bs-primary-rgb), 0.1);
    font-weight: 500;
}

.list-group-item-action:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    font-size: 1.2rem;
    line-height: 1;
    vertical-align: middle;
}

.breadcrumb-item a {
    color: var(--bs-primary);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--bs-gray-600);
}

.rounded-circle {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-control:focus,
.form-select:focus {
    border-color: rgba(var(--bs-primary-rgb), 0.5);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}

.text-purple {
    color: #6f42c1;
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize form validation
    const form = $('#employeeForm');
    
    // Handle section navigation
    $('.list-group-item[data-section]').click(function(e) {
        e.preventDefault();
        const targetSection = $(this).data('section');
        
        // Update active states
        $('.list-group-item[data-section]').removeClass('active');
        $(this).addClass('active');
        
        // Show selected section
        $('.form-section').removeClass('active');
        $('#' + targetSection).addClass('active');
        
        // Scroll to top
        window.scrollTo(0, 0);
    });
    
    // Handle next section buttons
    $('.next-section').click(function() {
        const currentSection = $(this).closest('.form-section');
        const nextSectionId = $(this).data('next');
        
        // Validate current section before proceeding
        let isValid = true;
        currentSection.find('input[required], select[required]').each(function() {
            if (!this.checkValidity()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            // Show validation messages
            form.addClass('was-validated');
            return;
        }
        
        // Update progress menu
        $('.list-group-item[data-section]').removeClass('active');
        $('.list-group-item[data-section="' + nextSectionId + '"]').addClass('active');
        
        // Show next section
        $('.form-section').removeClass('active');
        $('#' + nextSectionId).addClass('active');
        
        // Scroll to top
        window.scrollTo(0, 0);
    });
    
    // Handle previous section buttons
    $('.prev-section').click(function() {
        const currentSection = $(this).closest('.form-section');
        const prevSectionId = $(this).data('prev');
        
        // Update progress menu
        $('.list-group-item[data-section]').removeClass('active');
        $('.list-group-item[data-section="' + prevSectionId + '"]').addClass('active');
        
        // Show previous section
        $('.form-section').removeClass('active');
        $('#' + prevSectionId).addClass('active');
        
        // Scroll to top
        window.scrollTo(0, 0);
    });
    
    // Handle form submission
    form.on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        form.addClass('was-validated');
    });
});
</script>
@endpush

@endsection
