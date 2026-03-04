@extends('layouts.app')

@section('title', 'Create New Tour - EO Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">Create New Tour</h4>
    <a href="{{ route('admin.tours.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i> Back to Tours
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 px-4 border-bottom">
        <h5 class="mb-0">Tour Information</h5>
        <small class="text-muted">Add details for the new tour package</small>
    </div>

    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('admin.tours.store') }}" 
              enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <!-- Basic Information -->
            <h6 class="mb-4 fw-semibold text-primary border-bottom pb-2">Basic Information</h6>
            <div class="row g-4 mb-5">
                <div class="col-md-8">
                    <label for="name" class="form-label fw-medium">Tour Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus placeholder="e.g. Angkor Wat Sunrise Tour">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="price" class="form-label fw-medium">Price per Person (USD) <span class="text-danger">*</span></label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">$</span>
                        <input type="number" name="price" id="price" step="0.01" min="0"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price') }}" required placeholder="85.00">
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-medium">Start Date</label>
                    <input type="date" name="start_date" id="start_date"
                           class="form-control form-control-lg @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-medium">End Date</label>
                    <input type="date" name="end_date" id="end_date"
                           class="form-control form-control-lg @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Description & Status -->
            <h6 class="mb-4 fw-semibold text-primary border-bottom pb-2">Description & Status</h6>
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <label for="description" class="form-label fw-medium">Tour Description</label>
                    <textarea name="description" id="description" rows="6"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Describe the tour highlights, itinerary, inclusions...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-medium">Status</label>
                    <select name="status" id="status" class="form-select form-select-lg @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label fw-medium">Tour Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="form-control form-control-lg @error('image') is-invalid @enderror">
                    <small class="text-muted mt-1 d-block">Recommended size: 800×600 px (JPG/PNG)</small>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-3 justify-content-end mt-5">
                <a href="{{ route('admin.tours.index') }}" class="btn btn-outline-secondary px-4 py-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="bi bi-save me-2"></i> Create Tour
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Bootstrap client-side validation
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

    // Image preview when selected
    document.getElementById('image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.classList.add('img-fluid', 'mt-3', 'rounded');
                preview.style.maxHeight = '200px';
                e.target.parentNode.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection