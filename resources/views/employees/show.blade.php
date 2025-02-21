@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('employees.index') }}" class="text-white text-decoration-none me-3">
                            <i class="bi bi-arrow-left"></i> Back to Employees
                        </a>
                        <span class="h4 mb-0 d-inline-block">Employee Details</span>
                    </div>
                    <div>
                        <a href="{{ route('employees.create') }}" class="btn btn-success me-2">
                            <i class="bi bi-plus-lg"></i> Add Employee
                        </a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-light">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">
                                <i class="bi bi-person me-2"></i>Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#employment">
                                <i class="bi bi-briefcase me-2"></i>Employment Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#salary">
                                <i class="bi bi-cash me-2"></i>Salary Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#payroll">
                                <i class="bi bi-credit-card me-2"></i>Payroll History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#attendance">
                                <i class="bi bi-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Personal Details -->
                        <div class="tab-pane active" id="personal">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th width="35%">Employee ID</th>
                                            <td>{{ $employee->employee_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Full Name</th>
                                            <td>{{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $employee->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $employee->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{ $employee->date_of_birth ? date('d M Y', strtotime($employee->date_of_birth)) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ ucfirst($employee->gender) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th width="35%">Address</th>
                                            <td>{{ $employee->address ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>{{ $employee->city ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $employee->state ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pin Code</th>
                                            <td>{{ $employee->pin_code ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($employee->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Details -->
                        <div class="tab-pane fade" id="employment">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th width="35%">Client</th>
                                            <td>{{ $employee->client->client_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Position</th>
                                            <td>{{ $employee->position }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>{{ $employee->department }}</td>
                                        </tr>
                                        <tr>
                                            <th>Join Date</th>
                                            <td>{{ $employee->join_date ? date('d M Y', strtotime($employee->join_date)) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Employee Type</th>
                                            <td>{{ ucfirst($employee->employee_type) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Salary Details -->
                        <div class="tab-pane fade" id="salary">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th width="35%">Basic + DA</th>
                                            <td>₹{{ number_format($employee->basic_da, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>HRA</th>
                                            <td>₹{{ number_format($employee->hra, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Medical Allowance</th>
                                            <td>₹{{ number_format($employee->medical_allowance, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Special Allowance</th>
                                            <td>₹{{ number_format($employee->special_allowance, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <th width="35%">Conveyance</th>
                                            <td>₹{{ number_format($employee->conveyance, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Statutory Bonus</th>
                                            <td>₹{{ number_format($employee->statutory_bonus, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>EL Encashment</th>
                                            <td>₹{{ number_format($employee->el_encashment, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Other Allowance</th>
                                            <td>₹{{ number_format($employee->other_allowance, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Payroll History -->
                        <div class="tab-pane fade" id="payroll">
                            @livewire('payroll-table', ['client' => $employee->client])
                        </div>

                        <!-- Attendance -->
                        <div class="tab-pane fade" id="attendance">
                            @livewire('attendance-table', ['client' => $employee->client])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #6c757d;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: none;
    }
    .nav-tabs .nav-link:hover {
        border-color: transparent;
        isolation: isolate;
    }
    .table th {
        font-weight: 500;
        color: #6c757d;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endpush
