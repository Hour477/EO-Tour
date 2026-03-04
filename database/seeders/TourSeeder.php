<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourSeeder extends Seeder
{
    public function run()
    {
        $tours = [
            [
                'name' => 'Angkor Wat Tour',
                'description' => 'Explore the ancient temples of Angkor Wat.',
                'price' => 120.00,
                'start_date' => now(),
                'end_date' => now()->addDay(),
                'status' => 'dratf',
                'image' => 'angkor.jpg',
            ],
            [
                'name' => 'Phnom Penh City Tour',
                'description' => 'Discover Phnom Penh highlights.',
                'price' => 60.00,
                'start_date' => now(),
                'end_date' => now()->addHours(5),
                'status' => 'dratf',
                'image' => 'phnom-penh.jpg',
            ],
            [
                'name' => 'Kampot River Cruise',
                'description' => 'Relax on the scenic Kampot River.',
                'price' => 80.00,
                'start_date' => now()->addDays(2),
                'end_date' => now()->addDays(2)->addHours(4),
                'status' => 'dratf',
                'image' => 'kampot.jpg',
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }
    }
}