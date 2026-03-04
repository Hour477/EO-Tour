@extends('layouts.app')

@section('title', 'Tour Details - ' . $tour->name)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">
        Tour Details
        <span class="text-primary ms-2">{{ $tour->name }}</span>
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tours.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to List
        </a>
        <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i> Edit Tour
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left column - main info + description -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="mb-0">Tour Overview</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-medium text-muted small">Tour Name</label>
                        <h4 class="mb-2">{{ $tour->name }}</h4>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-medium text-muted small">Price per Person</label>
                        <h4 class="mb-2 text-success">${{ number_format($tour->price ?? 0, 2) }}</h4>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-medium text-muted small">Duration</label>
                        <p class="mb-0 fs-5">
                            @if ($tour->start_date && $tour->end_date)
                                {{ \Carbon\Carbon::parse($tour->start_date)->format('d M Y') }} 
                                — 
                                {{ \Carbon\Carbon::parse($tour->end_date)->format('d M Y') }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-medium text-muted small">Status</label>
                        <div>
                            @switch($tour->status ?? 'draft')
                                @case('published')
                                    <span class="badge bg-success px-3 py-2 fs-6">Published</span>
                                    @break
                                @case('draft')
                                @default
                                    <span class="badge bg-warning px-3 py-2 fs-6">Draft</span>
                            @endswitch
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-muted small">Description</label>
                        <div class="bg-light p-3 rounded border">
                            {!! nl2br(e($tour->description ?? 'No description provided.')) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics / Related -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="mb-0">Booking Statistics</h5>
            </div>
            <div class="card-body p-4">
                <div class="row text-center">
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold mb-0">{{ $tour->bookings_count ?? 0 }}</h3>
                        <small class="text-muted">Total Bookings</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <h3 class="fw-bold mb-0 text-success">
                            ${{ number_format(($tour->bookings_count ?? 0) * $tour->price, 2) }}
                        </h3>
                        <small class="text-muted">Total Revenue</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right column - Image & Quick actions -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="mb-0">Tour Image</h5>
            </div>
            <div class="card-body p-3 text-center">
                @if ($tour->image)
                    <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}"
                         class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="bi bi-image text-muted display-1"></i>
                    </div>
                    <p class="mt-3 text-muted">No image uploaded</p>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 px-4">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-2"></i> Edit Tour
                    </a>
                    <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" onsubmit="return confirm('Delete this tour? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i> Delete Tour
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection