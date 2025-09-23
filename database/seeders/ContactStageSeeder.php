<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['title' => 'Contacted',       'created_at' => Carbon::parse('2025-09-25 13:22'), 'status' => 'Active'],
            ['title' => 'Not Contacted',   'created_at' => Carbon::parse('2025-09-29 22:20'), 'status' => 'Active'],
            ['title' => 'Closed',          'created_at' => Carbon::parse('2025-10-04 08:30'), 'status' => 'Active'],
            ['title' => 'Lost',            'created_at' => Carbon::parse('2025-10-17 11:45'), 'status' => 'Active'],
            ['title' => 'Qualified',       'created_at' => Carbon::parse('2025-05-28 07:08'), 'status' => 'Active'],
            ['title' => 'Negotiation',     'created_at' => Carbon::parse('2025-07-01 02:15'), 'status' => 'Inactive'],
            ['title' => 'Subscriber',      'created_at' => Carbon::parse('2025-07-20 10:25'), 'status' => 'Active'],
            ['title' => 'Renewed',         'created_at' => Carbon::parse('2025-09-16 14:10'), 'status' => 'Inactive'],
            ['title' => 'Lead',            'created_at' => Carbon::parse('2025-10-10 10:15'), 'status' => 'Active'],
            ['title' => 'New Lead',        'created_at' => Carbon::parse('2025-11-01 13:32'), 'status' => 'Active'],
        ];

        foreach ($stages as $stage) {
            DB::table('contact_stages')->insert([
                'title'      => $stage['title'],
                'status'     => $stage['status'],
                'created_at' => $stage['created_at'],
                'updated_at' => now(),
            ]);
        }
    }
}
