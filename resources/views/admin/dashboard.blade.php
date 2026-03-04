<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - EO Tour')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h4 class="fw-semibold mb-0">Welcome to EO Tour Dashboard</h4>

    <div class="d-flex flex-wrap gap-3">
        {{-- <select class="form-select" style="width: auto; min-width: 200px;">
            <option>All Locations</option>
            <option>Phnom Penh</option>
            <option>Siem Reap</option>
            <option>Sihanoukville</option>
        </select> --}}

        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-primary btn-sm active">Today</button>
            <button type="button" class="btn btn-outline-primary btn-sm">This Week</button>
            <button type="button" class="btn btn-outline-primary btn-sm">This Month</button>
            <button type="button" class="btn btn-outline-primary btn-sm">This Year</button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stat bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar2-check fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 small text-white-75">Total Bookings</h6>
                        <h4 class="mb-0">
                            {{-- total booking --}}
                            {{-- @dd($totalBookings); --}}

                            {{ $totalBooking ?? 0 }}

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-stat bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check2-circle fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 small text-white-75">Confirmed</h6>
                        <h4 class="mb-0">
                        
                        {{ $confirmedBookings ?? 0 }}

                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-stat bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-hourglass-split fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 small text-white-75">Pending</h6>
                        <h4 class="mb-0">
                            {{ $pendingBookings ?? 0 }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card card-stat bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-currency-dollar fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 small text-white-75">Tours Total</h6>
                        <h4 class="mb-0">
                        
                        {{ $toursTotal ?? 0 }}
=
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- You can add charts, tables, recent bookings, etc. here later -->

@endsection