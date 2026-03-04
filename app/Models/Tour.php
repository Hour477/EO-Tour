<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'start_date',
        'end_date',
        'status',
        'image',
        ];
    //
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
