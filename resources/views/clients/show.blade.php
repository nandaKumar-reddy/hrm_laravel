@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-md-12">
            <!-- Client Info Card -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="badge {{ $client->status === 'active' ? 'bg-success' : 'bg-danger' }} ms-2">
                            {{ ucfirst($client->status) }}
                        </span>
                        <div class="ms-3 text-muted">
                            <strong>Client Name:</strong> {{ $client->client_name }}
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-edit me-2"></i>Edit Client
                        </a>
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                <div class="card-body py-2">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Contact Person</label>
                            <div>{{ $client->poc_name }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Email</label>
                            <div>{{ $client->poc_email }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Phone</label>
                            <div>{{ $client->poc_number }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small mb-1">Address</label>
                            <div>{{ $client->client_address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Selector -->
            @livewire('month-selector')

            <!-- Tabs -->
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#employees">
                                <i class="bi bi-people me-2"></i>Employees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#attendance">
                                <i class="bi bi-calendar-check me-2"></i>Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#payroll">
                                <i class="bi bi-cash me-2"></i>Payroll
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content pt-3">
                        <div class="tab-pane active" id="employees">
                            @livewire('employee-table', ['client' => $client])
                        </div>
                        <div class="tab-pane" id="attendance">
                            <livewire:attendance-table :client="$client" wire:key="attendance-table" />
                        </div>
                        <div class="tab-pane" id="payroll">
                            <livewire:payroll-table :client="$client" />
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
    padding: 0.75rem 1.25rem;
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
.card {
    border: none;
    border-radius: 0.5rem;
}
.card-header {
    border-bottom: none;
    padding: 0;
}
.client-avatar {
    font-size: 1.5rem;
    font-weight: 500;
}
.form-control, .form-select {
    border-color: #dee2e6;
}
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}
.btn-outline-primary {
    border-width: 1.5px;
}
.btn-outline-primary:hover {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}
.badge {
    padding: 0.5em 0.8em;
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<!-- Make sure jQuery, Bootstrap JS and Livewire scripts are included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts

<script>
$(document).ready(function() {
    // Event listener for month/year change
    $('#commonMonth, #commonYear').change(function() {
        const month = $('#commonMonth').val();
        const year = $('#commonYear').val();
        Livewire.dispatch('dates-updated', [month, year]);
    });
});

function exportToExcel() {
    // Add Excel export functionality here
    alert('Excel export functionality will be implemented here');
}
</script>
@endpush
