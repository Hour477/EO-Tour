@extends('layouts.app')

@section('title', 'Edit Tour - ' . $tour->name)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">
        Edit Tour
        <span class="text-primary ms-2">{{ $tour->name }}</span>
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tours.show', $tour->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Details
        </a>
        <a href="{{ route('admin.tours.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-list-ul me-2"></i> All Tours
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Update Tour Information</h5>
            <small class="text-muted">Modify the tour details below</small>
        </div>
        <div class="badge bg-primary-subtle text-primary px-3 py-2">
            Current Status: {{ ucfirst($tour->status ?? 'draft') }}
        </div>
    </div>

    <div class="card-body p-4 p-md-5">
        <form method="POST" action="{{ route('admin.tours.update', $tour->id) }}" 
              enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <h6 class="mb-4 fw-semibold text-primary border-bottom pb-2">Basic Information</h6>
            <div class="row g-4 mb-5">
                <div class="col-md-8">
                    <label for="name" class="form-label fw-medium">Tour Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                           value="{{ old('name', $tour->name) }}" required autofocus>
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
                               value="{{ old('price', $tour->price) }}" required>
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-medium">Start Date</label>
                    <input type="date" name="start_date" id="start_date"
                           class="form-control form-control-lg @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date', $tour->start_date)}}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-medium">End Date</label>
                    <input type="date" name="end_date" id="end_date"
                           class="form-control form-control-lg @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date', $tour->end_date) }}">
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
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $tour->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-medium">Status</label>
                    <select name="status" id="status" class="form-select form-select-lg @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status', $tour->status) == 'draft' ? 'selected' : ''
                         }}>draft</option>
                        <option value="published" {{ old('status', $tour->status) == 'published' ? 'selected' : ''
                        }}>Published</option>
                       
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label fw-medium">Update Tour Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="form-control form-control-lg @error('image') is-invalid @enderror">

                    @if ($tour->image)
                        <div class="mt-3">
                            <small class="text-muted">Current image:</small><br>
                            <img src="{{ asset('storage/' . $tour->image) }}" alt="Current tour image"
                                 class="img-thumbnail mt-2" style="max-height: 180px;">
                        </div>
                    @endif

                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="d-flex gap-3 justify-content-end mt-5">
                <a href="{{ route('admin.tours.show', $tour->id) }}" class="btn btn-outline-secondary px-4 py-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="bi bi-save me-2"></i> Update Tour
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Bootstrap validation
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

    // Optional image preview
    document.getElementById('image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.classList.add('img-fluid', 'mt-3', 'rounded');
                preview.style.maxHeight = '200px';
                this.parentNode.appendChild(preview);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection