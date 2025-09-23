<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LostReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            'Budget too low',
            'Chose competitor',
            'No response from client',
            'Project postponed',
            'Requirements unclear',
            'Timeline mismatch',
            'Decision-maker unavailable',
            'Lost to internal IT team',
            'Not a priority now',
            'Client went with freelancer',
            'High implementation cost',
            'Client’s management changed',
            'Security concerns',
            'Integration issues',
            'Unrealistic expectations',
            'Client cancelled project',
            'Preferred local vendor',
            'Support concerns',
            'Did not like demo',
            'Too many approvals required',
            'Technical limitations',
            'Client chose in-house tool',
            'Long approval cycle',
            'Client moved to another software',
            'Not convinced by ROI',
            'Features not sufficient',
            'Payment issues',
            'Duplicate lead',
            'Client closed business',
            'Other priorities emerged',
        ];

        $startDate = strtotime("2025-06-15");
        $endDate   = strtotime("2025-12-30");

        foreach ($reasons as $reason) {
            $randomTimestamp = rand($startDate, $endDate);
            $createdAt = Carbon::createFromTimestamp($randomTimestamp);

            DB::table('lost_reasons')->insert([
                'title'      => $reason,
                'status'     => rand(0, 1) ? 'Active' : 'Inactive',
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);
        }
    }
}
