<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use App\Models\Booking;
// use App\Models\Tour;

// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $totalBookings = Booking::count();
        // dd($totalBooking);
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        
        $pendingBookings = Booking::where('status', 'pending')->count();

        $totalAmount = 0;
        if (Schema::hasColumn('bookings', 'total_price')) {
            $totalAmount = Booking::sum('total_price');
        }
        
        $totalIncome = 0;
        if (Schema::hasColumn('bookings', 'total_price')) {
            $totalIncome = Booking::where('status', 'confirmed')->sum('total_price');
        }
        
       
        return view('admin.dashboard', compact('totalBookings', 'confirmedBookings', 'pendingBookings', 'totalAmount', 'totalIncome'));
    }

    // total Booing

    public function totalBooking()
    {
       
    }
    

}
