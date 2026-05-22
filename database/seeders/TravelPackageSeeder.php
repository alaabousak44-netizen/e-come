<?php

namespace Database\Seeders;

use App\Models\TravelPackage;
use Illuminate\Database\Seeder;

class TravelPackageSeeder extends Seeder
{
    public function run(): void
    {
        if (TravelPackage::exists()) {
            return;
        }

        $packages = [
            [
                'title' => 'Bali Beach Escape',
                'description' => 'Sun-soaked beaches, temples, and local food tours.',
                'destination_city' => 'Bali',
                'destination_country' => 'Indonesia',
                'duration_days' => 7,
                'price_per_person' => 1099.00,
                'max_capacity' => 20,
            ],
            [
                'title' => 'Santorini Sunset Retreat',
                'description' => 'Romantic cliffside stays with wine tastings and private cruises.',
                'destination_city' => 'Santorini',
                'destination_country' => 'Greece',
                'duration_days' => 5,
                'price_per_person' => 1299.00,
                'max_capacity' => 12,
            ],
            [
                'title' => 'Kyoto Culture Journey',
                'description' => 'Ancient temples, guided city walks, and traditional tea ceremonies.',
                'destination_city' => 'Kyoto',
                'destination_country' => 'Japan',
                'duration_days' => 6,
                'price_per_person' => 1450.00,
                'max_capacity' => 15,
            ],
            [
                'title' => 'Marrakech Medina Adventure',
                'description' => 'Souks, desert camps, and authentic Moroccan cuisine.',
                'destination_city' => 'Marrakech',
                'destination_country' => 'Morocco',
                'duration_days' => 5,
                'price_per_person' => 749.00,
                'max_capacity' => 18,
            ],
            [
                'title' => 'Swiss Alps Explorer',
                'description' => 'Scenic trains, mountain hikes, and cozy alpine lodges.',
                'destination_city' => 'Swiss Alps',
                'destination_country' => 'Switzerland',
                'duration_days' => 8,
                'price_per_person' => 1899.00,
                'max_capacity' => 10,
            ],
            [
                'title' => 'Maldives Luxury Escape',
                'description' => 'Overwater villas, snorkeling, and private island dining.',
                'destination_city' => 'Maldives',
                'destination_country' => 'Indian Ocean',
                'duration_days' => 6,
                'price_per_person' => 2199.00,
                'max_capacity' => 8,
            ],
        ];

        foreach ($packages as $package) {
            TravelPackage::create([
                ...$package,
                'is_active' => true,
                'created_at' => now(),
            ]);
        }
    }
}
