<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calls = [
            'Busy',
            'No Answer',
            'Wrong Number',
            'Unavailable',
            'Technical Issue',
            'Bug Report',
            'Customer Call',
            'Management Call',
            'Support Call',
            'Sales Call',
        ];

        $startDate = strtotime("2025-06-15");
        $endDate   = strtotime("2025-12-30");

        foreach ($calls as $reason) {
            $randomTimestamp = rand($startDate, $endDate);
            $createdAt = Carbon::createFromTimestamp($randomTimestamp);

            DB::table('calls')->insert([
                'title'      => $reason,
                'status'     => rand(0, 1) ? 'Active' : 'Inactive',
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);
        }
    }
}
