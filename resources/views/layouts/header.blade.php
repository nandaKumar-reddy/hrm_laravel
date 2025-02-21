<header class="navbar navbar-expand-lg fixed-top" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); height: 64px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <span class="fs-4 fw-bold text-white">HR Client Management</span>
        </a>

        <!-- Search Bar -->
        <div class="d-none d-md-block flex-grow-1 mx-4">
            <div class="position-relative">
                <input type="search" class="form-control bg-light bg-opacity-15 border-0 ps-4 text-white" placeholder="Search..." style="background: rgba(255,255,255,0.1);">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-white-50"></i>
            </div>
        </div>

        <!-- Right Navigation -->
        <div class="d-flex align-items-center gap-3">
            <!-- Notifications -->
            <div class="position-relative">
                <button class="btn btn-link text-white p-2">
                    <i class="bi bi-bell"></i>
                </button>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    2
                </span>
            </div>

            <!-- User Profile -->
            <div class="dropdown">
                <button class="btn btn-link text-white p-2" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end mt-2">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
