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
            <div class="col-md-12 text-md-end">
                <form action="{{ route('admin.bookings.index') }}" method="GET">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search customer or ID..." value="{{ request('search') }}">
                        <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Clear
                            </a>
                        @endif
                    </div>
                </form>
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
                        <th class="px-4 py-3">Customer and Email</th>
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
                                        {{-- btn comfirm --}}
                                        @if(strtolower($booking->status ?? 'pending') === 'pending')
                                            <li>
                                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <input type="hidden" name="customer_name" value="{{ $booking->customer_name }}">
                                                    <input type="hidden" name="customer_email" value="{{ $booking->customer_email }}">
                                                    <input type="hidden" name="tour_id" value="{{ $booking->tour_id }}">
                                                    <input type="hidden" name="people_count" value="{{ $booking->people_count }}">
                                                    <input type="hidden" name="total_price" value="{{ $booking->total_price }}">
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-check-circle me-2"></i> Confirm Booking
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                       
                                        @if(strtolower($booking->status ?? 'pending') === 'confirmed')
                                            <li>
                                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <input type="hidden" name="customer_name" value="{{ $booking->customer_name }}">
                                                    <input type="hidden" name="customer_email" value="{{ $booking->customer_email }}">
                                                    <input type="hidden" name="tour_id" value="{{ $booking->tour_id }}">
                                                    <input type="hidden" name="people_count" value="{{ $booking->people_count }}">
                                                    <input type="hidden" name="total_price" value="{{ $booking->total_price }}">
                                                    <button type="submit" class="dropdown-item text-info">
                                                        <i class="bi bi-check2-all me-2"></i> Mark as Completed
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        

                                        @if(in_array(strtolower($booking->status ?? 'pending'), ['pending', 'confirmed']))
                                            <li>
                                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <input type="hidden" name="customer_name" value="{{ $booking->customer_name }}">
                                                    <input type="hidden" name="customer_email" value="{{ $booking->customer_email }}">
                                                    <input type="hidden" name="tour_id" value="{{ $booking->tour_id }}">
                                                    <input type="hidden" name="people_count" value="{{ $booking->people_count }}">
                                                    <input type="hidden" name="total_price" value="{{ $booking->total_price }}">
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                        <i class="bi bi-x-circle me-2"></i> Cancel Booking
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        @if(strtolower($booking->status ?? 'pending') === 'cancelled')
                                            <li>
                                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="pending">
                                                    <input type="hidden" name="customer_name" value="{{ $booking->customer_name }}">
                                                    <input type="hidden" name="customer_email" value="{{ $booking->customer_email }}">
                                                    <input type="hidden" name="tour_id" value="{{ $booking->tour_id }}">
                                                    <input type="hidden" name="people_count" value="{{ $booking->people_count }}">
                                                    <input type="hidden" name="total_price" value="{{ $booking->total_price }}">
                                                    <button type="submit" class="dropdown-item text-warning">
                                                        <i class="bi bi-arrow-counterclockwise me-2"></i> Restore to Pending
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                        
                                        
                                        
                                        
                        
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
        </div>
    </div>

    <div class="card-footer bg-white border-top py-3 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mr-3.5">
            <small class="text-muted">
                Showing {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
            </small>
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection