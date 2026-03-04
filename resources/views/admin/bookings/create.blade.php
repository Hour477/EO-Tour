{{-- resources/views/bookings/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create New Booking - EO Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">Create New Booking</h4>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to List
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 px-4 border-bottom">
        <h5 class="mb-0">Booking Information</h5>
        <small class="text-muted">Fill in the details to create a new booking</small>
    </div>

    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('admin.bookings.store') }}" class="needs-validation" novalidate>
            @csrf

            <!-- Customer Information -->
            <h6 class="mb-4 fw-semibold text-primary border-bottom pb-2">Customer Details</h6>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label fw-medium">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" id="customer_name"
                           class="form-control form-control-lg @error('customer_name') is-invalid @enderror"
                           value="{{ old('customer_name') }}" required autofocus>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="customer_email" class="form-label fw-medium">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="customer_email" id="customer_email"
                           class="form-control form-control-lg @error('customer_email') is-invalid @enderror"
                           value="{{ old('customer_email') }}" required>
                    @error('customer_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Tour Information -->
            <h6 class="mb-4 fw-semibold text-primary border-bottom pb-2">Tour Details</h6>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <label for="tour_id" class="form-label fw-medium">Select Tour <span class="text-danger">*</span></label>
                    <select name="tour_id" id="tour_id"
                            class="form-select form-select-lg @error('tour_id') is-invalid @enderror" required>
                        <option value="">-- Choose a tour --</option>
                        @foreach ($tours as $tour)
                            <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>
                                {{ $tour->name }} ({{ $tour->price ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('tour_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="booking_date" class="form-label fw-medium">Booking Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="booking_date" id="booking_date"
                           class="form-control form-control-lg @error('booking_date') is-invalid @enderror"
                           value="{{ old('booking_date') }}" required>
                    @error('booking_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="people_count" class="form-label fw-medium">Number of People <span class="text-danger">*</span></label>
                    <input type="number" name="people_count" id="people_count" min="1"
                           class="form-control form-control-lg @error('people_count') is-invalid @enderror"
                           value="{{ old('people_count', 1) }}" required>
                    @error('people_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="total_price" class="form-label fw-medium">Total Price (USD) <span class="text-danger">*</span></label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">$</span>
                        <input type="number" name="total_price" id="total_price" step="0.01"
                               class="form-control @error('total_price') is-invalid @enderror"
                               value="{{ old('total_price') }}" required>
                    </div>
                    @error('total_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Additional Information -->
            {{-- <h6 class="mb-4 fw-semibold text-primary border-bottom pb-2">Additional Notes</h6>
            <div class="mb-5">
                <label for="notes" class="form-label fw-medium">Special Requests / Notes</label>
                <textarea name="notes" id="notes" rows="4"
                          class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}

            <!-- Status -->
            <div class="mb-5">
                <label for="status" class="form-label fw-medium">Initial Status</label>
                <select name="status" id="status" class="form-select form-select-lg">
                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-3 justify-content-end">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary px-4 py-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="bi bi-save me-2"></i> Create Booking
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Simple client-side validation enhancement (optional)
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection