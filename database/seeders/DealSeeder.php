<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    // 1. Create a Test Deal
    $deal = \App\Models\Deal::create([
        'product_name' => 'iPhone 15 Pro',
        'base_price' => 1000.00,
        'end_time' => now()->addDays(2), // Timer set for 2 days from now
    ]);

    // 2. Add Price Tiers (Requirement: Dynamic Price Adjustment)
    \DB::table('price_tiers')->insert([
        ['deal_id' => $deal->id, 'min_participants' => 5, 'tier_price' => 900.00],
        ['deal_id' => $deal->id, 'min_participants' => 10, 'tier_price' => 800.00],
    ]);
}
}
