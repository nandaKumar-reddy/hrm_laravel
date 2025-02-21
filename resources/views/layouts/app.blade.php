<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HR Client Management')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Existing CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            /* Primary Colors */
            --primary-color: #4361ee;
            --primary-hover: #3f37c9;
            
            /* Action Colors */
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
            
            /* Background Colors */
            --bg-primary: #f8f9fa;
            --bg-secondary: #ffffff;
            --bg-accent: #e9ecef;
            
            /* Text Colors */
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #868e96;
            
            /* Border Colors */
            --border-color: #dee2e6;
            
            /* Custom Colors */
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --success-color: #059669;
            --danger-color: #dc2626;
            --background-color: #f8fafc;
            --text-color: #1f2937;
        }
        /* Typography Only - Rest Remains Same */
        h1, h2, h3, h4, h5, h6, .navbar-brand, .card-title, .page-title { font-family: 'Poppins', sans-serif; }
        body, p, .nav-link, .btn, .form-control, .table, .alert, .card-text, .dropdown-item { font-family: 'Inter', sans-serif; }
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            margin: 0;
            padding-top: 56px;
        }
        .main-content { padding: 1rem; max-width: 100%; margin: 0 auto; min-height: calc(100vh - 56px); }
        .table-responsive { overflow-x: auto; max-width: 100%; }
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 0.5rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar-brand { font-weight: 600; color: var(--primary-color); }
        .navbar-nav .nav-link {
            color: var(--text-color);
            padding: 0.5rem 0.75rem;
            transition: color 0.2s;
        }
        .navbar-nav .nav-link:hover { color: var(--primary-color); }
        /* Reduced spacing in forms */
        .form-group { margin-bottom: 0.75rem; }
        .card { margin-bottom: 1rem; }
        .card-body { padding: 1rem; }
        .table td, .table th { padding: 0.5rem; }
        .alert { padding: 0.75rem 1rem; margin-bottom: 1rem; }
        /* Custom Toast Styling */
        .toast-success { background-color: #198754 !important; }
        .toast-error { background-color: #dc3545 !important; }
        .toast-info { background-color: #0dcaf0 !important; }
        .toast-warning { background-color: #ffc107 !important; }
        
        /* Smooth Transitions */
        .fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
        .fade-enter-from, .fade-leave-to { opacity: 0; }
        
        /* Loading Spinner */
        .spinner-border { width: 2rem; height: 2rem; }
        
        /* Form Validation Styles */
        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus { box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25); }
        .form-control.is-valid:focus,
        .form-select.is-valid:focus { box-shadow: 0 0 0 0.2rem rgba(25,135,84,0.25); }
        
        /* Autosave Indicator */
        #autosaveIndicator {
            z-index: 9999;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: fadeInOut 2s ease;
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(20px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
        @media (min-width: 768px) {
            .main-content { padding: 1.5rem; }
            .card-body { padding: 1.5rem; }
        }
        
        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
        }

        /* Background Colors */
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        .bg-success {
            background-color: var(--success-color) !important;
        }
        .bg-danger {
            background-color: var(--danger-color) !important;
        }
        .bg-warning {
            background-color: var(--warning-color) !important;
        }
        .bg-info {
            background-color: var(--info-color) !important;
        }

        /* Text Colors */
        .text-primary {
            color: var(--primary-color) !important;
        }
        .text-success {
            color: var(--success-color) !important;
        }
        .text-danger {
            color: var(--danger-color) !important;
        }
        .text-warning {
            color: var(--warning-color) !important;
        }
        .text-info {
            color: var(--info-color) !important;
        }
    </style>
    @stack('styles')
    @livewireStyles
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                        <i class="fas fa-building me-1"></i>Clients
                    </a>
                    <div class="ms-auto">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Configure Toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000,
            extendedTimeOut: 1000,
            preventDuplicates: true,
            newestOnTop: true,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        
        // Configure SweetAlert2 Default Settings
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        // Setup AJAX CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle Form Validation Display
        function showFormValidation(form, errors) {
            // Clear previous errors
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
            
            // Add new error messages
            Object.keys(errors).forEach(field => {
                const input = form.find(`[name="${field}"]`);
                input.addClass('is-invalid');
                input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
            });
            
            // Scroll to first error
            const firstError = form.find('.is-invalid:first');
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
                firstError.focus();
            }
        }
        
        // Handle AJAX Errors
        $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
            // Don't show error if request was aborted
            if (jqXHR.statusText === 'abort') return;

            if (jqXHR.status === 422) { // Validation error
                const errors = jqXHR.responseJSON.errors;
                const form = $(event.target).closest('form');
                if (form.length) {
                    showFormValidation(form, errors);
                }
                toastr.error('Please check the form for errors.');
            } 
            else if (jqXHR.status === 419) { // CSRF token mismatch
                Swal.fire({
                    icon: 'error',
                    title: 'Session Expired',
                    text: 'Your session has expired. Please refresh the page and try again.',
                    confirmButtonText: 'Refresh Page',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }
            else if (jqXHR.status === 403) { // Forbidden
                toastr.error('You do not have permission to perform this action.');
            }
            else if (jqXHR.status === 404) { // Not found
                toastr.error('The requested resource was not found.');
            }
            else if (jqXHR.status === 500) { // Server error
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'An unexpected error occurred. Please try again later.',
                    confirmButtonText: 'OK'
                });
            }
            else if (jqXHR.status === 0) { // Network error
                toastr.error('Unable to connect to the server. Please check your internet connection.');
            }
            else {
                toastr.error('An error occurred while processing your request.');
            }
        });

        // Handle session flash messages
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        // Handle Laravel validation errors
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        // Global form submit handler to prevent double submission
        $(document).on('submit', 'form', function() {
            const $form = $(this);
            const $submitButton = $form.find('[type="submit"]');
            
            if ($form.data('submitting')) {
                return false;
            }
            
            $form.data('submitting', true);
            if ($submitButton.length) {
                const originalText = $submitButton.html();
                $submitButton.html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...').prop('disabled', true);
                
                // Reset button after 30 seconds (failsafe)
                setTimeout(() => {
                    $submitButton.html(originalText).prop('disabled', false);
                    $form.data('submitting', false);
                }, 30000);
            }
        });

        // Handle confirmation dialogs
        $(document).on('click', '[data-confirm]', function(e) {
            e.preventDefault();
            const $this = $(this);
            
            Swal.fire({
                title: $this.data('confirm-title') || 'Are you sure?',
                text: $this.data('confirm-text') || 'This action cannot be undone.',
                icon: $this.data('confirm-icon') || 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: $this.data('confirm-button') || 'Yes, proceed',
                cancelButtonText: $this.data('cancel-button') || 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    if ($this.is('a')) {
                        window.location.href = $this.attr('href');
                    } else if ($this.is('button')) {
                        $this.closest('form').submit();
                    }
                }
            });
        });
    </script>
    @stack('scripts')
    @livewireScripts
    <script src="{{ asset('js/attendance.js') }}"></script>
</body>
</html>
