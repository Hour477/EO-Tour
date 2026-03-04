<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;

// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
         $totalBooking = Booking::count();
        // dd($totalBooking);
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        
        $pendingBookings = Booking::where('status', 'pending')->count();

        $toursTotal = Tour::count();
        
        return view('admin.dashboard', compact('totalBooking', 'confirmedBookings', 'pendingBookings', 'toursTotal'));
    }

    // total Booing

    public function totalBooking()
    {
       
    }
    

}
