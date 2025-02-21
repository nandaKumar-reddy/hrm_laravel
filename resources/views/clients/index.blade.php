@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-primary mb-1">Clients</h4>
            <p class="text-muted mb-0">Manage your organization's clients</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Client
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('clients.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-transparent">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                               name="search" value="{{ request('search') }}" 
                               placeholder="Search clients...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Company Name</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($clients as $client)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm hover-shadow-md transition-all w-50">
                <div class="card-body p-4 position-relative">
                    <!-- Action Menu at Top Left -->
                    <div class="position-absolute top-0 start-0 mt-3 ms-3">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('clients.edit', $client) }}">
                                        <i class="fas fa-edit me-2 text-primary"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Are you sure you want to delete this client?')">
                                            <i class="fas fa-trash-alt me-2"></i>Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <span class="badge {{ $client->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($client->status) }}
                        </span>
                    </div>

                    <!-- Client Information -->
                    <div class="mt-4">
                        <h3 class="mb-3 fw-bold">{{ $client->company_name }}</h3>
                        <div class="mb-2 text-muted">
                            <strong>Client ID:</strong> {{ $client->id }}
                        </div>
                        <div class="mb-2 text-muted">
                            <strong>Client Name:</strong> {{ $client->client_name }}
                        </div>
                        <div class="mb-2">
                        <i class="fas fa-industry text-primary me-2"></i>
                            <span class="text-muted">{{ $client->industry_type }}</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <a href="mailto:{{ $client->email }}" class="text-decoration-none text-muted">{{ $client->client_email }}</a>
                        </div>
                        <div class="mb-4">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span class="text-muted">{{ $client->client_address }}</span>
                        </div>
                    </div>

                    <!-- View Button at Bottom Right -->
                    <div class="text-end mt-3">
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-users fa-3x text-muted"></i>
                </div>
                <h5>No Clients Found</h5>
                <p class="text-muted">Start by adding your first client</p>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Client
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $clients->links() }}
    </div>
</div>

<style>
.hover-shadow-md {
    transition: box-shadow 0.3s ease;
}
.hover-shadow-md:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.transition-all {
    transition: all 0.3s ease;
}
.info-list {
    font-size: 0.9rem;
}
</style>
@endsection
