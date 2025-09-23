<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'Phone Calls',
            'Social Media',
            'Referral Sites',
            'Web Analytics',
            'Previous Purchases',
            'Lead & Opportunity',
            'Image-based Features',
            'Bots',
            'Insights',
            'Commerce',
        ];

        $startDate = strtotime("2025-06-15");
        $endDate   = strtotime("2025-12-30");

        foreach ($sources as $reason) {
            $randomTimestamp = rand($startDate, $endDate);
            $createdAt = Carbon::createFromTimestamp($randomTimestamp);

            DB::table('sources')->insert([
                'title'      => $reason,
                'status'     => rand(0, 1) ? 'Active' : 'Inactive',
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);
        }
    }
}
