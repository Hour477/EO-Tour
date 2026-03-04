{{-- resources/views/bookings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Booking List - EO Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-bold mb-0">Booking Management</h4>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> New Booking
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 px-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5 col-lg-4">
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="d-flex">
                    <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" 
                    name="search"
                    class="form-control border-start-0" placeholder="Search by ID, name or email..." id="searchInput">
                </div>

                </form>
                
            </div>
            <div class="col-md-7 col-lg-8 text-md-end">
               
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-bordered border-light">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">
                            No
                        </th>
                        <th class="px-4 py-3">Booking ID</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Tour</th>
                        <th class="px-4 py-3">People</th>
                        <th class="px-4 py-3">Date / Time</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse ($bookings as $key=> $booking)
                        <tr>
                            <td class="px-4 fw-bold text-primary">
                               {{$bookings->firstItem()+$key}}
                            </td>
                            <td class="px-4 fw-bold text-primary">
                                #{{$booking->id}}
                            </td>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 38px; height: 38px;">
                                        {{ strtoupper(substr($booking->customer_name ?? 'G', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $booking->customer_name ?? 'Guest' }}</div>
                                        <small class="text-muted">{{ $booking->customer_email ?? '—' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4">
                                {{ $booking->tour->name ?? 'Tour #' . $booking->tour_id }}
                            </td>
                            <td class="px-4 text-center">
                                {{ $booking->people_count ?? 1 }} pax
                            </td>
                            <td class="px-4">
                                @if ($booking->booking_date)
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    <small class="text-muted d-block">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('h:i A') }}
                                    </small>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 fw-bold">
                                ${{ number_format($booking->total_price ?? 0, 2) }}
                            </td>
                            <td class="text-center px-4">
                                @switch(strtolower($booking->status ?? 'pending'))
                                    @case('confirmed')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Confirmed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">Cancelled</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2">Completed</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">Pending</span>
                                @endswitch
                            </td>
                            <td class="px-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><a class="dropdown-item" href="{{ route('admin.bookings.show', $booking->id) }}"><i class="bi bi-eye me-2"></i> View Details</a></li>
                                        {{-- <li>
                                            <form method="PUT" action="{{ route('admin.bookings.update', $booking->id) }}"></form>
                                            <a class="dropdown-item text-success"
                                            method="PUT"   
                                            ><i class="bi bi-check-circle me-2">
                                            </i> Confirm</a>

                                        </li> --}}
                                        <li><a class="dropdown-item text-primary" href="{{ route('admin.bookings.edit', $booking->id) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x display-4 d-block mb-3"></i>
                                No bookings found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination --}}
            {{-- @if ($bookings->hasPages())
                <div class="d-md-none p-3 border-top">
                    {{ $bookings->links('pagination::bootstrap-5') }}
                </div>
            @endif --}}
            
        </div>
        {{-- <div class="table-responsive">
            {{ $bookings->links() }}
        </div> --}}
    </div>

    <div class="card-footer bg-white border-top py-3 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <small class="text-muted d-none ">
                Showing {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
            </small>
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection