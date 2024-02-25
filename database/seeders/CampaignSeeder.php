<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 10 campaigns
        \App\Models\Campaign::factory()->count(10)->create();
    }
}
