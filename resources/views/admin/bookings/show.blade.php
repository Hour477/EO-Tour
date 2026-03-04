{{-- resources/views/bookings/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Booking Details #' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) . ' - EO Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">
        Booking Details
        <span class="text-primary ms-2">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to List
        </a>
        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i> Edit Booking
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Main Info -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Booking ID</label>
                        <p class="fs-5 fw-bold mb-0 text-primary">#{{ $booking->id }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Status</label>
                        <div>
                            @switch(strtolower($booking->status ?? 'pending'))
                                @case('confirmed')
                                    <span class="badge bg-success px-3 py-2 fs-6">Confirmed</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger px-3 py-2 fs-6">Cancelled</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-info px-3 py-2 fs-6">Completed</span>
                                    @break
                                @default
                                    <span class="badge bg-warning px-3 py-2 fs-6">Pending</span>
                            @endswitch
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Booking Date & Time</label>
                        <p class="mb-0">
                            @if ($booking->booking_date)
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                <span class="text-muted">at</span>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('h:i A') }}
                            @else
                                —
                            @endif
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Created At</label>
                        <p class="mb-0">{{ $booking->created_at->format('d M Y • h:i A') }}</p>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium text-muted small">Special Notes / Requests</label>
                        <div class="bg-light p-3 rounded border">
                            {{ $booking->notes ?? 'No additional notes provided.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Full Name</label>
                        <p class="fs-5 mb-0">{{ $booking->customer_name ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Email Address</label>
                        <p class="mb-0">
                            <a href="mailto:{{ $booking->customer_email }}" class="text-primary">
                                {{ $booking->customer_email ?? '—' }}
                            </a>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Phone Number</label>
                        <p class="mb-0">{{ $booking->customer_phone ?? '—' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium text-muted small">Nationality</label>
                        <p class="mb-0">{{ $booking->nationality ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Tour & Payment Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="mb-0">Tour Details</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-medium text-muted small d-block">Tour Name</label>
                    <h5 class="mb-1">{{ $booking->tour->name ?? 'Tour #' . $booking->tour_id }}</h5>
                    @if ($booking->tour)
                        <small class="text-muted">Code: {{ $booking->tour->code ?? 'N/A' }}</small>
                    @endif
                </div>

                <div>
                    <label class="form-label fw-medium text-muted small d-block">Number of People</label>
                    <h5 class="mb-0">{{ $booking->people_count ?? 1 }} pax</h5>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="mb-0">Payment Summary</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <span class="fw-medium">Total Amount:</span>
                    <span class="fs-4 fw-bold text-success">${{ number_format($booking->total_price ?? 0, 2) }}</span>
                </div>

                <div class="small text-muted">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Status:</span>
                        <span class="fw-medium">
                            {{ ucfirst($booking->payment_status ?? 'Unpaid') }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Created:</span>
                        <span>{{ $booking->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection