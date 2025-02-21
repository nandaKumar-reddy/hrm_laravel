<div class="sidebar-menu">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Clients
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Employees
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('attendance.index') }}" class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Attendance
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('payroll.index') }}" class="nav-link {{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Payroll
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>
    </ul>
</div>

<style>
.sidebar-menu {
    padding: 1rem 0;
}

.sidebar-menu .nav-link {
    color: #6c757d;
    padding: 0.75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-menu .nav-link i {
    width: 20px;
    text-align: center;
}

.sidebar-menu .nav-link:hover {
    color: #2196f3;
    background-color: rgba(33, 150, 243, 0.1);
}

.sidebar-menu .nav-link.active {
    color: #2196f3;
    background-color: rgba(33, 150, 243, 0.1);
    font-weight: 500;
}
</style>