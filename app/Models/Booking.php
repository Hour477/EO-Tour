<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
        'tour_id',
        'customer_name',
        'customer_email',
        'people_count',
        'total_price',
        'booking_date',
        'status'
        
        
    ];
    // relation public function tour()
    // Booking.php
    public function tour() {
        return $this->belongsTo(Tour::class);
    }
    


}
