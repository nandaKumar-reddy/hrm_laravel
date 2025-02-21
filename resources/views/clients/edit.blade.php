@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-3">
                        <div class="list-group-item bg-primary text-white py-3">
                            <i class="fas fa-tasks me-2"></i>Form Progress
                            <div class="small opacity-75">Complete all sections</div>
                        </div>
                        <a href="#" class="list-group-item list-group-item-action py-3" data-step="1">
                            <div class="d-flex align-items-center">
                                <span class="step-number">1</span>
                                <div class="ms-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>Basic Information
                                    <div class="small text-muted">Company details and contact</div>
                                </div>
                                <i class="fas fa-check text-success ms-auto step-complete d-none"></i>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-3" data-step="2">
                            <div class="d-flex align-items-center">
                                <span class="step-number">2</span>
                                <div class="ms-3">
                                    <i class="fas fa-user-tie text-info me-2"></i>Contact Person Details
                                    <div class="small text-muted">Primary contact information</div>
                                </div>
                                <i class="fas fa-check text-success ms-auto step-complete d-none"></i>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-3" data-step="3">
                            <div class="d-flex align-items-center">
                                <span class="step-number">3</span>
                                <div class="ms-3">
                                    <i class="fas fa-file-alt text-warning me-2"></i>Statutory Details
                                    <div class="small text-muted">Legal and tax information</div>
                                </div>
                                <i class="fas fa-check text-success ms-auto step-complete d-none"></i>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-3" data-step="4">
                            <div class="d-flex align-items-center">
                                <span class="step-number">4</span>
                                <div class="ms-3">
                                    <i class="fas fa-clipboard-check text-success me-2"></i>Compliance Registration
                                    <div class="small text-muted">Registration numbers</div>
                                </div>
                                <i class="fas fa-check text-success ms-auto step-complete d-none"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 0%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Edit Client
                            </h5>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('clients.show', $client->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Back to Details
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="clientForm" action="{{ route('clients.update', $client->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Step 1: Basic Information -->
                        <div class="form-step" id="step1">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-icon basic-info">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Basic Information</h5>
                                    <p class="text-muted mb-0">Update company details and contact</p>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="clientId" class="form-label">
                                        <i class="fas fa-fingerprint text-primary me-2"></i>Client ID
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('client_id') is-invalid @enderror" 
                                           id="clientId" name="client_id" value="{{ old('client_id', $client->id) }}"
                                           placeholder="Enter unique client ID" required>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="clientName" class="form-label">
                                        <i class="fas fa-signature text-primary me-2"></i>Client Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                           id="clientName" name="client_name" value="{{ old('client_name', $client->client_name) }}"
                                           placeholder="Enter client name" required>
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="industryType" class="form-label">
                                        <i class="fas fa-industry text-primary me-2"></i>Industry Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('industry_type') is-invalid @enderror" 
                                            id="industryType" name="industry_type" required>
                                        <option value="">Select Industry Type</option>
                                        <option value="IT" {{ old('industry_type', $client->industry_type) == 'IT' ? 'selected' : '' }}>Information Technology</option>
                                        <option value="Manufacturing" {{ old('industry_type', $client->industry_type) == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="Healthcare" {{ old('industry_type', $client->industry_type) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                        <option value="Finance" {{ old('industry_type', $client->industry_type) == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Retail" {{ old('industry_type', $client->industry_type) == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="Other" {{ old('industry_type', $client->industry_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('industry_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $client->client_email) }}"
                                           placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="address" class="form-label">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address" name="address" rows="3"
                                              placeholder="Enter complete address" required>{{ old('address', $client->client_address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-step">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Contact Person Details -->
                        <div class="form-step d-none" id="step2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-icon contact-person">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Contact Person Details</h5>
                                    <p class="text-muted mb-0">Add primary contact information</p>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label">
                                        <i class="fas fa-user text-primary me-2"></i>Contact Person Name
                                    </label>
                                    <input type="text" class="form-control" name="contact_person_name" 
                                           value="{{ old('contact_person_name', $client->poc_name) }}"
                                           placeholder="Enter contact person's full name">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">
                                        <i class="fas fa-id-badge text-primary me-2"></i>Designation
                                    </label>
                                    <input type="text" class="form-control" name="designation" 
                                           value="{{ old('designation', $client->poc_designation) }}"
                                           placeholder="Enter contact person's designation">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-envelope text-primary me-2"></i>Contact Person Email
                                    </label>
                                    <input type="email" class="form-control" name="contact_person_email"
                                           value="{{ old('contact_person_email', $client->poc_email) }}"
                                           placeholder="Enter contact person's email">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-phone text-primary me-2"></i>Contact Person Phone
                                    </label>
                                    <input type="text" class="form-control" name="contact_person_phone"
                                           value="{{ old('contact_person_phone', $client->poc_number) }}"
                                           placeholder="Enter contact person's phone">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Statutory Details -->
                        <div class="form-step d-none" id="step3">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-icon statutory">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Statutory Details</h5>
                                    <p class="text-muted mb-0">Legal and tax information</p>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="gstin" class="form-label">
                                        <i class="fas fa-receipt text-primary me-2"></i>GSTIN
                                    </label>
                                    <input type="text" class="form-control @error('gstin') is-invalid @enderror"
                                           id="gstin" name="gstin" value="{{ old('gstin', $client->gst) }}"
                                           placeholder="Enter GSTIN">
                                    @error('gstin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pan" class="form-label">
                                        <i class="fas fa-id-card text-primary me-2"></i>PAN
                                    </label>
                                    <input type="text" class="form-control @error('pan') is-invalid @enderror"
                                           id="pan" name="pan" value="{{ old('pan', $client->pan) }}"
                                           placeholder="Enter PAN">
                                    @error('pan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tan" class="form-label">
                                        <i class="fas fa-file-alt text-primary me-2"></i>TAN
                                    </label>
                                    <input type="text" class="form-control @error('tan') is-invalid @enderror"
                                           id="tan" name="tan" value="{{ old('tan', $client->tan_number) }}"
                                           placeholder="Enter TAN">
                                    @error('tan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex align-items-center mb-4">
                                <div class="step-icon statutory">
                                    <i class="fas fa-toggle-on"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Statutory Settings</h5>
                                    <p class="text-muted mb-0">Enable/disable statutory components</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="pfEnabled" name="pf_enabled"
                                               {{ old('pf_enabled', $client->pf_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pfEnabled">
                                            <i class="fas fa-piggy-bank text-primary me-2"></i>Enable PF
                                        </label>
                                        <div class="text-muted small">Provident Fund deduction</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="esiEnabled" name="esi_enabled"
                                               {{ old('esi_enabled', $client->esi_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="esiEnabled">
                                            <i class="fas fa-heart text-primary me-2"></i>Enable ESI
                                        </label>
                                        <div class="text-muted small">Employee State Insurance</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="ptEnabled" name="pt_enabled"
                                               {{ old('pt_enabled', $client->pt_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ptEnabled">
                                            <i class="fas fa-file-invoice text-primary me-2"></i>Enable PT
                                        </label>
                                        <div class="text-muted small">Professional Tax deduction</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="tdsEnabled" name="tds_enabled"
                                               {{ old('tds_enabled', $client->tds_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tdsEnabled">
                                            <i class="fas fa-percent text-primary me-2"></i>Enable TDS
                                        </label>
                                        <div class="text-muted small">Tax Deducted at Source</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Compliance Registration -->
                        <div class="form-step d-none" id="step4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-icon compliance">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Compliance Registration</h5>
                                    <p class="text-muted mb-0">Add compliance and registration details</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-user-shield text-primary me-2"></i>PF Registration
                                    </label>
                                    <input type="text" class="form-control" name="pf_registration" 
                                           value="{{ old('pf_registration', $client->pf_num) }}"
                                           placeholder="Enter PF registration number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heartbeat text-primary me-2"></i>ESI Registration
                                    </label>
                                    <input type="text" class="form-control" name="esi_registration"
                                           value="{{ old('esi_registration', $client->esi_num) }}"
                                           placeholder="Enter ESI registration number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-store text-primary me-2"></i>PT Registration
                                    </label>
                                    <input type="text" class="form-control" name="pt_registration"
                                           value="{{ old('pt_registration', $client->pt_num) }}"
                                           placeholder="Enter PT registration number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-file-signature text-primary me-2"></i>LWF Registration
                                    </label>
                                    <input type="text" class="form-control" name="lwf_registration"
                                           value="{{ old('lwf_registration', $client->lwf_num) }}"
                                           placeholder="Enter LWF registration number">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Previous
                                </button>
                                <button type="submit" class="btn btn-success" id="submitForm">
                                    <i class="fas fa-save me-2"></i>Update Client
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Progress Menu Styles */
.step-number {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.list-group-item-action {
    position: relative;
    border: none;
    border-radius: 0.5rem !important;
    margin-bottom: 0.25rem;
}

.list-group-item-action:hover {
    background-color: rgba(67, 97, 238, 0.05);
}

.list-group-item-action:hover .step-number {
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary-color);
}

.list-group-item-action.active .step-number {
    background-color: #ffffff;
    color: var(--primary-color);
}

.list-group-item-action.completed {
    background-color: rgba(25, 135, 84, 0.05);
}

.list-group-item-action.completed .step-number {
    background-color: #198754;
    color: white;
}

.list-group-item-action.completed:hover {
    background-color: rgba(25, 135, 84, 0.1);
}

.step-complete {
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s ease;
}

.list-group-item-action.completed .step-complete {
    opacity: 1;
    transform: scale(1);
}

/* Progress Bar */
.progress-bar-container {
    position: relative;
    height: 4px;
    background-color: #e9ecef;
    margin: 1rem 0;
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    background-color: var(--primary-color);
    transition: width 0.3s ease;
}

/* Form Step Transitions */
.form-step {
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}

.form-step:not(.d-none) {
    opacity: 1;
    transform: translateX(0);
}

/* Step Icons */
.step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-right: 1rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 4;
    let formData = {};

    // Initialize form data
    function initFormData() {
        const form = $('#clientForm');
        formData = {};
        form.find('input, select, textarea').each(function() {
            formData[$(this).attr('name')] = $(this).val();
        });
    }

    // Update progress bar
    function updateProgress() {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        $('.progress-bar').css('width', `${progress}%`);
    }

    // Update step indicators
    function updateStepIndicators() {
        $('.list-group-item-action').removeClass('active');
        $(`.list-group-item-action[data-step="${currentStep}"]`).addClass('active');
    }

    // Show current step
    function showStep(step) {
        $('.form-step').addClass('d-none');
        $(`#step${step}`).removeClass('d-none');
        currentStep = step;
        updateProgress();
        updateStepIndicators();
    }

    // Navigation click handlers - Direct access to any tab
    $('.list-group-item-action').click(function(e) {
        e.preventDefault();
        const step = $(this).data('step');
        showStep(step);
    });

    $('.next-step').click(function() {
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    });

    $('.prev-step').click(function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    // Form validation - Only on submission
    function validateForm() {
        let isValid = true;
        const requiredFields = $('#clientForm').find('input[required], select[required]');
        
        requiredFields.removeClass('is-invalid');
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                const fieldName = $(this).prev('label').text().trim();
                toastr.error(`Please fill in ${fieldName}`);
            }
        });

        // Email validation if email is filled
        const email = $('#email').val();
        if (email && !isValidEmail(email)) {
            isValid = false;
            $('#email').addClass('is-invalid');
            toastr.error('Please enter a valid email address');
        }

        return isValid;
    }

    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // Form submission
    $('#clientForm').on('submit', function(e) {
        e.preventDefault();

        if (!validateForm()) {
            return false;
        }

        const form = $(this);
        const submitBtn = $('#submitForm');
        const originalBtnText = submitBtn.html();

        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...').prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                toastr.success('Client updated successfully');
                setTimeout(() => {
                    window.location.href = response.redirect || '/clients';
                }, 1500);
            },
            error: function(xhr) {
                submitBtn.html(originalBtnText).prop('disabled', false);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        toastr.error(errors[key][0]);
                        $(`[name="${key}"]`).addClass('is-invalid');
                    });
                } else {
                    toastr.error('An error occurred while updating the client');
                }
            }
        });
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Show initial step
    showStep(1);
});
</script>
@endpush

@endsection
