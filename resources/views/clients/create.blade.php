@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-primary fw-bold mb-3">Add New Client</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Client</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Clients
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
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: 0%"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form id="clientForm" action="{{ route('clients.store') }}" method="POST">
                        @csrf

                        <!-- Step 1: Basic Information -->
                        <div class="form-step" id="step1">
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-icon basic-info">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Basic Information</h5>
                                    <p class="text-muted mb-0">Enter the client's basic details</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <!-- Client Name -->
                                <div class="col-md-6">
                                    <label for="clientName" class="form-label">
                                        <i class="fas fa-signature text-primary me-2"></i>Client Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                        id="clientName" name="client_name" value="{{ old('client_name') }}"
                                        placeholder="Enter client name" required>
                                    @error('client_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Industry Type -->
                                <div class="col-md-6">
                                    <label for="industryType" class="form-label">
                                        <i class="fas fa-industry text-primary me-2"></i>Industry Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('industry_type') is-invalid @enderror"
                                        id="industryType" name="industry_type" required>
                                        <option value="">Select Industry Type</option>
                                        <option value="IT" {{ old('industry_type') == 'IT' ? 'selected' : '' }}>Information Technology</option>
                                        <option value="Manufacturing" {{ old('industry_type') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="Healthcare" {{ old('industry_type') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                        <option value="Finance" {{ old('industry_type') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Retail" {{ old('industry_type') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="Other" {{ old('industry_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('industry_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Client Email -->
                                <div class="col-md-6">
                                    <label for="clientEmail" class="form-label">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('client_email') is-invalid @enderror"
                                        id="clientEmail" name="client_email" value="{{ old('client_email') }}"
                                        placeholder="Enter email address" required>
                                    @error('client_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Client Phone -->
                                <div class="col-md-6">
                                    <label for="clientPhone" class="form-label">
                                        <i class="fas fa-phone text-primary me-2"></i>Phone Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('client_number') is-invalid @enderror"
                                        id="clientPhone" name="client_number" value="{{ old('client_number') }}"
                                        placeholder="Enter phone number" required>
                                    @error('client_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Client Address -->
                                <div class="col-md-12">
                                    <label for="clientAddress" class="form-label">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>Address
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('client_address') is-invalid @enderror"
                                        id="clientAddress" name="client_address" rows="3"
                                        placeholder="Enter complete address" required>{{ old('client_address') }}</textarea>
                                    @error('client_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <div class="text-muted">
                                    <small><span class="text-danger">*</span> Required fields</small>
                                </div>
                                <button type="button" class="btn btn-primary next-step">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
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
                                <!-- Contact Person Name -->
                                <div class="col-md-12">
                                    <label class="form-label">
                                        <i class="fas fa-user text-primary me-2"></i>Contact Person Name
                                    </label>
                                    <input type="text" class="form-control" name="poc_name"
                                        value="{{ old('poc_name') }}"
                                        placeholder="Enter contact person's full name">
                                </div>

                                <!-- Contact Person Designation -->
                                <div class="col-md-12">
                                    <label class="form-label">
                                        <i class="fas fa-id-badge text-primary me-2"></i>Designation
                                    </label>
                                    <input type="text" class="form-control" name="poc_designation"
                                        value="{{ old('poc_designation') }}"
                                        placeholder="Enter contact person's designation">
                                </div>

                                <!-- Contact Person Email -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-envelope text-primary me-2"></i>Contact Person Email
                                    </label>
                                    <input type="email" class="form-control" name="poc_email"
                                        value="{{ old('poc_email') }}"
                                        placeholder="Enter contact person's email">
                                </div>

                                <!-- Contact Person Phone -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-phone text-primary me-2"></i>Contact Person Phone
                                    </label>
                                    <input type="text" class="form-control" name="poc_number"
                                        value="{{ old('poc_number') }}"
                                        placeholder="Enter contact person's phone">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-primary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Previous Step
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
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
                                    <p class="text-muted mb-0">Add legal and tax information</p>
                                </div>
                            </div>

                            <div class="row g-4">
                                <!-- PAN Number -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-id-card text-primary me-2"></i>PAN Number
                                    </label>
                                    <input type="text" class="form-control" name="pan"
                                        value="{{ old('pan') }}"
                                        placeholder="Enter PAN number">
                                </div>

                                <!-- GST Number -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-building text-primary me-2"></i>GST Number
                                    </label>
                                    <input type="text" class="form-control" name="gst"
                                        value="{{ old('gst') }}"
                                        placeholder="Enter GST number">
                                </div>

                                <!-- TAN Number -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-file-invoice text-primary me-2"></i>TAN Number
                                    </label>
                                    <input type="text" class="form-control" name="tan_number"
                                        value="{{ old('tan_number') }}"
                                        placeholder="Enter TAN number">
                                </div>

                                <!-- CIN Number -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-shield-alt text-primary me-2"></i>CIN Number
                                    </label>
                                    <input type="text" class="form-control" name="cin_number"
                                        value="{{ old('cin_number') }}"
                                        placeholder="Enter CIN number">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-primary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Previous Step
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
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
                                <!-- PF Registration -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-user-shield text-primary me-2"></i>PF Registration
                                    </label>
                                    <input type="text" class="form-control" name="pf_num"
                                        value="{{ old('pf_num') }}"
                                        placeholder="Enter PF registration number">
                                </div>

                                <!-- ESI Registration -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-heartbeat text-primary me-2"></i>ESI Registration
                                    </label>
                                    <input type="text" class="form-control" name="esi_num"
                                        value="{{ old('esi_num') }}"
                                        placeholder="Enter ESI registration number">
                                </div>

                                <!-- PT Registration -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-store text-primary me-2"></i>PT Registration
                                    </label>
                                    <input type="text" class="form-control" name="pt_num"
                                        value="{{ old('pt_num') }}"
                                        placeholder="Enter PT registration number">
                                </div>

                                <!-- LWF Registration -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-file-signature text-primary me-2"></i>LWF Registration
                                    </label>
                                    <input type="text" class="form-control" name="lwf_num"
                                        value="{{ old('lwf_num') }}"
                                        placeholder="Enter LWF registration number">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-primary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Previous Step
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Save Client
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
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --success-color: #4cc9f0;
        --info-color: #4895ef;
        --warning-color: #f72585;
        --danger-color: #e63946;
        --light-color: #f8f9fa;
        --dark-color: #212529;
    }

    .list-group-item {
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 500;
        color: var(--dark-color);
        background-color: var(--light-color);
        border-radius: 0.5rem !important;
        margin-bottom: 0.25rem;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: rgba(67, 97, 238, 0.05);
        color: var(--primary-color);
    }

    .list-group-item.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
    }

    .list-group-item i {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 0.75rem;
        font-size: 0.9rem;
    }

    .list-group-item.active i {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .step-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .step-icon.basic-info {
        background-color: #4cc9f0;
        color: white;
    }

    .step-icon.contact-person {
        background-color: #4895ef;
        color: white;
    }

    .step-icon.statutory {
        background-color: #4361ee;
        color: white;
    }

    .step-icon.compliance {
        background-color: #3f37c9;
        color: white;
    }

    .form-control,
    .form-select {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
        font-size: 0.95rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .progress-steps {
        position: relative;
        counter-reset: step;
    }

    .progress-step {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 1.5rem;
    }

    .progress-step::before {
        content: counter(step);
        counter-increment: step;
        width: 32px;
        height: 32px;
        background-color: var(--light-color);
        color: var(--dark-color);
        border-radius: 50%;
        position: absolute;
        left: 0;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .progress-step.active::before {
        background-color: var(--primary-color);
        color: white;
    }

    .form-step {
        transition: all 0.3s ease;
        transform-origin: top;
    }

    .form-step.d-none {
        transform: translateY(20px);
        opacity: 0;
    }

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

    .form-step {
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }

    .form-step:not(.d-none) {
        opacity: 1;
        transform: translateX(0);
    }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize variables
        let currentStep = 1;
        const totalSteps = 4;
        let completedSteps = new Set([]);
        let formData = new FormData();

        // Function to show step with animation
        function showStep(stepNumber, direction = 'next') {
            if (stepNumber < 1 || stepNumber > totalSteps) return;

            // Hide all steps with animation
            $('.form-step').each(function() {
                const $step = $(this);
                if (!$step.hasClass('d-none')) {
                    $step.css({
                        'transform': direction === 'next' ? 'translateX(-20px)' : 'translateX(20px)',
                        'opacity': '0'
                    });
                    setTimeout(() => {
                        $step.addClass('d-none');
                    }, 300);
                }
            });

            // Show target step with animation
            setTimeout(() => {
                const $targetStep = $(`#step${stepNumber}`);
                $targetStep.removeClass('d-none').css({
                    'transform': direction === 'next' ? 'translateX(20px)' : 'translateX(-20px)',
                    'opacity': '0'
                });

                // Force reflow
                $targetStep[0].offsetHeight;

                $targetStep.css({
                    'transform': 'translateX(0)',
                    'opacity': '1'
                });
            }, 300);

            // Update progress menu
            updateProgressMenu(stepNumber);

            // Update navigation buttons
            updateNavigationButtons(stepNumber);

            // Update current step
            currentStep = stepNumber;

            // Scroll to top smoothly
            $('html, body').animate({
                scrollTop: $('#clientForm').offset().top - 20
            }, 300);
        }

        // Function to validate current step
        function validateStep(stepNumber) {
            const $currentStep = $(`#step${stepNumber}`);
            let isValid = true;
            let firstError = null;

            // Clear previous errors
            $currentStep.find('.is-invalid').removeClass('is-invalid');
            $currentStep.find('.invalid-feedback').remove();

            // Validate required fields
            $currentStep.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val();

                if (!value || value.trim() === '') {
                    isValid = false;
                    markFieldAsInvalid($field, 'This field is required');
                    firstError = firstError || $field;
                }
            });

            // Validate email fields
            $currentStep.find('input[type="email"]').each(function() {
                const $field = $(this);
                if ($field.val() && !isValidEmail($field.val())) {
                    isValid = false;
                    markFieldAsInvalid($field, 'Please enter a valid email address');
                    firstError = firstError || $field;
                }
            });

            // Validate phone fields
            $currentStep.find('input[type="tel"]').each(function() {
                const $field = $(this);
                if ($field.val() && !isValidPhone($field.val())) {
                    isValid = false;
                    markFieldAsInvalid($field, 'Please enter a valid 10-digit phone number');
                    firstError = firstError || $field;
                }
            });

            // Focus first error field
            if (firstError) {
                firstError.focus();
            }

            // If valid, mark step as completed
            if (isValid) {
                completedSteps.add(stepNumber);
                updateProgressMenu(currentStep);
            }

            return isValid;
        }

        // Helper function to mark field as invalid
        function markFieldAsInvalid($field, message) {
            $field.addClass('is-invalid');
            $field.after(`<div class="invalid-feedback">${message}</div>`);
        }

        // Helper functions for validation
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        function isValidPhone(phone) {
            return /^\d{10}$/.test(phone);
        }

        // Function to update navigation buttons
        function updateNavigationButtons(stepNumber) {
            const $prevBtn = $('.prev-step');
            const $nextBtn = $('.next-step');
            const $submitBtn = $('button[type="submit"]');

            // Show/hide previous button
            $prevBtn.toggle(stepNumber > 1);

            // Update next/submit buttons
            if (stepNumber === totalSteps) {
                $nextBtn.hide();
                $submitBtn.show();
            } else {
                $nextBtn.show();
                $submitBtn.hide();
            }
        }

        // Function to update progress menu
        function updateProgressMenu(currentStep) {
            $('.list-group-item-action').each(function() {
                const $item = $(this);
                const stepNum = parseInt($item.data('step'));

                // Reset classes
                $item.removeClass('active completed disabled');

                // Add appropriate classes
                if (stepNum === currentStep) {
                    $item.addClass('active');
                } else if (completedSteps.has(stepNum)) {
                    $item.addClass('completed');
                } else if (stepNum > Math.max(...completedSteps, currentStep)) {
                    $item.addClass('disabled');
                }

                // Update checkmark
                $item.find('.step-complete').toggleClass('d-none', !completedSteps.has(stepNum));
            });

            // Update progress bar
            const progress = ((completedSteps.size + (currentStep > Math.max(...completedSteps) ? 1 : 0)) / totalSteps) * 100;
            $('.progress-bar').css('width', `${progress}%`);
        }

        // Event Handlers
        $('.next-step').on('click', function() {
            if (validateStep(currentStep)) {
                showStep(currentStep + 1, 'next');
            }
        });

        $('.prev-step').on('click', function() {
            showStep(currentStep - 1, 'prev');
        });

        // Handle progress menu clicks
        $('.list-group-item-action').on('click', function(e) {
            e.preventDefault();
            const targetStep = parseInt($(this).data('step'));

            // Only allow navigation to completed steps or current step
            if (targetStep <= Math.max(...completedSteps, currentStep)) {
                showStep(targetStep, targetStep < currentStep ? 'prev' : 'next');
            }
        });

        // Form submission
        $('#clientForm').on('submit', function(e) {
            e.preventDefault();

            if (!validateStep(currentStep)) {
                return false;
            }

            // Add loading state
            const $submitBtn = $(this).find('button[type="submit"]');
            const originalText = $submitBtn.html();
            $submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);

            // Submit form using AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success('Client created successfully');
                    setTimeout(() => {
                        window.location.href = '{{ route("clients.index") }}';
                    }, 1000);
                },
                error: function(xhr) {
                    $submitBtn.html(originalText).prop('disabled', false);

                    const errors = xhr.responseJSON?.errors || {};
                    Object.keys(errors).forEach(field => {
                        const $field = $(`[name="${field}"]`);
                        markFieldAsInvalid($field, errors[field][0]);
                    });

                    toastr.error('Please check the form for errors');
                }
            });
        });

        // Initialize form
        showStep(1);
        updateNavigationButtons(1);

        // Add input event listeners for real-time validation
        $('input, select, textarea').on('input change', function() {
            const $field = $(this);
            if ($field.hasClass('is-invalid')) {
                $field.removeClass('is-invalid');
                $field.next('.invalid-feedback').remove();
            }
        });
    });

    // Add loading overlay
    $('body').append(`
    <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" 
         style="background: rgba(255,255,255,0.8); z-index: 9999;">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <div class="spinner-border text-primary mb-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="text-primary">Processing...</div>
        </div>
    </div>
`);

    // Show/hide loading overlay
    function toggleLoading(show) {
        $('#loadingOverlay').toggleClass('d-none', !show);
    }

    // Add keyboard navigation
    $(document).on('keydown', function(e) {
        // Only handle if not in an input field
        if (!$(e.target).is('input, select, textarea')) {
            if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                e.preventDefault();
                if (e.key === 'ArrowRight' && currentStep < totalSteps) {
                    $('.next-step:visible').click();
                } else if (e.key === 'ArrowLeft' && currentStep > 1) {
                    $('.prev-step:visible').click();
                }
            }
        }

        // Handle enter key in form fields
        if (e.key === 'Enter' && $(e.target).is('input')) {
            e.preventDefault();
            const $inputs = $(`#step${currentStep}`).find('input, select, textarea');
            const currentIndex = $inputs.index(e.target);
            if (currentIndex < $inputs.length - 1) {
                $inputs.eq(currentIndex + 1).focus();
            } else {
                $('.next-step:visible').click();
            }
        }
    });

    // Add tooltips for keyboard shortcuts
    $('.next-step').attr('title', 'Next Step (→)');
    $('.prev-step').attr('title', 'Previous Step (←)');
    $('[title]').tooltip();

    // Enhance form submission
    $('#clientForm').on('submit', function(e) {
        e.preventDefault();

        if (!validateStep(currentStep)) {
            return false;
        }

        // Show loading overlay
        toggleLoading(true);

        // Disable all form inputs during submission
        const $form = $(this);
        const $inputs = $form.find('input, select, textarea, button');
        $inputs.prop('disabled', true);

        // Submit form using AJAX
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Client created successfully');

                // Show success message with checkmark animation
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Client has been created successfully.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ route("clients.index") }}';
                });
            },
            error: function(xhr) {
                // Re-enable form inputs
                $inputs.prop('disabled', false);
                toggleLoading(false);

                const errors = xhr.responseJSON?.errors || {};

                // Group validation errors by step
                const stepErrors = {};
                Object.keys(errors).forEach(field => {
                    const $field = $(`[name="${field}"]`);
                    const stepNum = $field.closest('.form-step').attr('id').replace('step', '');
                    stepErrors[stepNum] = stepErrors[stepNum] || [];
                    stepErrors[stepNum].push(field);

                    markFieldAsInvalid($field, errors[field][0]);
                });

                // If errors are in a different step, navigate to the first step with errors
                const currentStepHasErrors = stepErrors[currentStep];
                if (!currentStepHasErrors) {
                    const firstErrorStep = Math.min(...Object.keys(stepErrors));
                    if (firstErrorStep !== currentStep) {
                        showStep(parseInt(firstErrorStep));
                    }
                }

                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form for errors and try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Add autosave functionality
    let autosaveTimer;
    $('input, select, textarea').on('change', function() {
        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(function() {
            const formData = new FormData($('#clientForm')[0]);
            localStorage.setItem('clientFormData', JSON.stringify(Object.fromEntries(formData)));

            // Show autosave indicator
            const $indicator = $('#autosaveIndicator');
            if (!$indicator.length) {
                $('body').append(`
                <div id="autosaveIndicator" class="position-fixed bottom-0 end-0 m-3 p-2 bg-success text-white rounded">
                    <i class="fas fa-save me-2"></i>Draft saved
                </div>
            `);
            }
            $('#autosaveIndicator').fadeIn().delay(2000).fadeOut();
        }, 1000);
    });

    // Load autosaved data if exists
    const savedData = localStorage.getItem('clientFormData');
    if (savedData) {
        const formData = JSON.parse(savedData);
        Object.keys(formData).forEach(field => {
            $(`[name="${field}"]`).val(formData[field]);
        });
    }

    // Clear autosaved data on successful submission
    $(document).on('clientFormSubmitted', function() {
        localStorage.removeItem('clientFormData');
    });
</script>
@endpush

@endsection