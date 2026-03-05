<?php

namespace App\Http\Controllers;


use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    // Show list of bookings (optional, you haven't defined index route)
   // app/Http/Controllers/TourController.php

    public function index(Request $request)
    {


                 $tours = Tour::withCount('bookings')


                     ->when($request->search, function ($query, $search) {
                         $query->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('description', 'LIKE', "%{$search}%");
                     })
                     ->when($request->status, function ($query, $status) {
                        $query->where('status', $status);
                    })
                     ->latest()
                     ->paginate(5)
                     ->withQueryString();  
        return view('admin.tours.index', compact('tours'));
    }

    // Show create booking form
    public function create()
    {
        $tours = Tour::all(); // For dropdown select
        return view('admin.tours.create', compact('tours'));
    }

    // Store new Tour
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'required|in:draft,published',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ]);
        // dd($validated);
        // if ($request->hasFile('image')) {
        //     // Optional: delete old image
        //     $validated['image'] = $request->file('image')->store('tours', 'public');
        // }

        // Tour::create($validated);

        $tour = new Tour;
        $tour->name = $validated['name'];
        $tour->description = $validated['description'];
        $tour->price = $validated['price'];
        $tour->start_date = $validated['start_date'];
        $tour->end_date = $validated['end_date'];
        $tour->status = $validated['status'];  
         
        $tour->image = $validated['image']->store('tours', 'public');
        $tour->save();
        

        return redirect()->route('admin.tours.index');
    }

    // TourController.php

public function edit(Tour $tour)
{
//    id 
    $tour = Tour::findOrFail($tour->id);
    return view('admin.tours.edit', compact('tour'));
}

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'in:draft,published',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:102983',
        ]);

        if ($request->hasFile('image')) {
            // Optional: delete old image
            if ($tour->image) {
                Storage::disk('public')->delete($tour->image);
            }
            $validated['image'] = $request->file('image')->store('tours', 'public');
        }
        $tour->update($validated);
        // $tour->update($validated);

        return redirect()->route('admin.tours.show', $tour->id)
                        ->with('success', 'Tour updated successfully');
    }

    public function show(Tour $tour)
    {
        $tour->loadCount('bookings'); // if you have bookings relationship
        return view('admin.tours.show', compact('tour'));
    }

    // Delete booking
    public function destroy($id)
    {
        $tour = Tour::where('id', $id)->first();
        if($tour->image){
            Storage::disk('public')->delete($tour->image);
        }

        
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('success', 'Booking deleted successfully.');

    }
}