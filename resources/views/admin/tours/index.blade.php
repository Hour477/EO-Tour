{{-- resources/views/tours/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Tours Management - EO Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">Tours Management</h4>
    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> Add New Tour
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 border-bottom">
        <div class="row g-3 align-items-center">
            <div class="col-md-5 col-lg-4">
            <form
                method="GET"
                action="{{route('admin.tours.index')}}">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text"
                    name="search"
                     class="form-control border-start-0" placeholder="Search tours by name..." id="searchInput">
                </div>
            </form>
            </div>
            {{-- <div class="col-md-7 col-lg-8 text-md-end">
                <div class="d-inline-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-bordered border-light">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Tour Name</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Duration</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Bookings</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse ($tours as $tour)
                        <tr>
                            <td class="px-4">
                                @if ($tour->image)
                                    {{-- @dd(asset('storage/app/public/' . $tour->image)) --}}
                                    {{-- <img src="{{ asset('storage/app/public/' . $tour->image) }}"
                                    
                                         --}}
                                         <img src="{{ asset('storage/' . $tour->image) }}"
                                          alt="{{ $tour->name }}" class="rounded" 
                                         style="width: 80px; height: 50px; object-fit: cover;">
                                         
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 50px;">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4">
                                <div class="fw-semibold">{{ $tour->name }}</div>
                                <small class="text-muted">{{ Str::limit($tour->description ?? '', 60) }}</small>
                            </td>
                            <td class="px-4 fw-bold text-success">
                                ${{ number_format($tour->price ?? 0, 2) }}
                            </td>
                            <td class="px-4">
                                @if ($tour->start_date && $tour->end_date)
                                    {{ \Carbon\Carbon::parse($tour->start_date)->format('d M Y') }} 
                                    — 
                                    {{ \Carbon\Carbon::parse($tour->end_date)->format('d M Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-center px-4">
                                @switch($tour->status ?? 'draft')
                                    @case('published')
                                        <span class="badge bg-success px-3 py-2">Published</span>
                                        @break
                                    @case('draft')
                                    @default
                                   
                                        <span class="badge bg-warning px-3 py-2">Draft</span>
                                @endswitch
                            </td>
                            <td class="text-center px-4">
                                <span class="badge bg-primary-subtle text-primary">
                                    {{ $tour->bookings_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><a class="dropdown-item" href="{{ route('admin.tours.show', $tour->id) }}"><i class="bi bi-eye me-2"></i> View</a></li>
                                        <li><a class="dropdown-item text-primary" href="{{ route('admin.tours.edit', $tour->id) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tour?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-geo-alt display-4 d-block mb-3"></i>
                                No tours found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white border-top py-3 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <small class="text-muted">
                Showing {{ $tours->firstItem() }}–{{ $tours->lastItem() }} of {{ $tours->total() }} tours
            </small>
            {{ $tours->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection