<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Show list of bookings (optional, you haven't defined index route)
    public function index(Request $request)
    {

        $tours = Tour::select('id', 'name')->where('id', $request->tour_id)->get();


        $bookings = Booking::with('tour')
        //  filter search 
            ->when($request->search, function ($query) use ($request) {
                $query->where('customer_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('customer_email', 'LIKE', '%' . $request->search . '%');
                    
            })
        // Filter status
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->tour_id, function ($query) use ($request) {
                $query->where('tour_id', $request->tour_id);
            })

            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'tours'));
    }


public function create()
{
    // autu calculate  total price = people_count × tour price

    $tours = Tour::where('status', 'published')->orderBy('name')->get(); // assuming you have Tour model

    return view('admin.bookings.create', compact('tours'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name'   => 'required|string|max:255',
        'customer_email'  => 'required|email|max:255',
        'tour_id'         => 'required|exists:tours,id',
        'booking_date'    => 'required|date',
        'people_count'    => 'required|integer|min:1',
        'total_price'     => 'required|numeric|min:0',
        'status'          => 'in:pending,confirmed,cancelled',
    ]);
    // autu calculate  total price = people_count × tour price
    $tour = Tour::findOrFail($validated['tour_id']);
    $validated['total_price'] = $tour->price * $validated['people_count'];
    

    Booking::create($validated);

    return redirect()->route('admin.bookings.index')
                     ->with('success', 'Booking created successfully!');
    }
    // Show edit form
    // BookingController.php

    public function edit(Booking $booking)
    {
        $tours = Tour::orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'tours'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'tour_id'         => 'required|exists:tours,id',
            'customer_name'   => 'required|string|max:255',
            'customer_email'  => 'required|email|max:255',
            // 'customer_phone'  => 'nullable|string|max:30',
            // 'nationality'     => 'nullable|string|max:100',
            'people_count'    => 'required|integer|min:1',
            'total_price'     => 'required|numeric|min:0',
            'booking_date'    => 'date',
            // 'notes'           => 'nullable|string',
            'status'          => 'required|in:pending,confirmed,cancelled,completed',
        ]);
        // autu calculate  total price = people_count × tour price
        $tour = Tour::findOrFail($validated['tour_id']);
        $validated['total_price'] = $tour->price * $validated['people_count'];
        
        // dd($validated); //chech problem
        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking->id)
                        ->with('success', 'Booking updated successfully!');
    }
    public function show(Booking $booking)
    {
        $booking->load('tour'); // eager load tour relationship if exists

        return view('admin.bookings.show', compact('booking'));
    }

    // Delete booking
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.create')->with('success', 'Booking deleted successfully.');
    }


//  autu calculate
    public function  CalculateTotalPrice(Request $request){
        $tour = Tour::find($request->tour_id);

    if (!$tour) {
        return response()->json(['total_price' => 0]);
    }

    $total = $tour->price * $request->people_count;
    return response()->json([
        'total_price' => $total
    ]);
    }
}