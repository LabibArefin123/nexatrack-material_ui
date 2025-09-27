<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Pipeline;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'public_relations',
            'content_marketting',
            'social_marketting',
            'brand',
            'sales',
            'media',
            'rebranding',
            'product_launch',
        ];

        $plans = ['Standard', 'Professional', 'Premium', 'Premium Plus'];

        // ✅ 3 main statuses for UI filters
        $mainStatuses = ['Active', 'Completed', 'Archived'];

        $pipelineIds = Pipeline::pluck('id')->toArray();

        $startRange = Carbon::create(2025, 6, 15);
        $endRange   = Carbon::create(2025, 12, 30);

        // 600 total → 200 for each category
        foreach ($mainStatuses as $index => $mainStatus) {
            for ($i = 1; $i <= 200; $i++) {
                $opened       = round(rand(105, 905) / 10, 1);
                $closed       = round(rand(105, 905) / 10, 1);
                $unsubscribe  = round(rand(105, 905) / 10, 1);
                $delivered    = round(rand(105, 905) / 10, 1);
                $conversation = round(rand(105, 905) / 10, 1);

                $progress = round(rand(105, 905) / 10, 1);

                $startDate = $startRange->copy()->addDays(rand(0, $endRange->diffInDays($startRange)));
                $endDate   = $startDate->copy()->addDays(rand(7, 60));

                Campaign::create([
                    'name'          => Str::title(fake()->company()) . " " . $plans[array_rand($plans)] . " Campaign " . (($index * 200) + $i),
                    'type'          => $types[array_rand($types)],
                    'pipeline_id'   => $pipelineIds[array_rand($pipelineIds)],
                    'plan'          => $plans[array_rand($plans)],
                    'total_members' => rand(100, 10000),
                    'sent'          => rand(100, 10000),
                    'opened'        => $opened,
                    'closed'        => $closed,
                    'unsubscribe'   => $unsubscribe,
                    'delivered'     => $delivered,
                    'bounced'       => rand(0, 500),
                    'progress'      => $progress,
                    'status'        => $mainStatus, // ✅ Fixed status (Active, Completed, Archived)
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                ]);
            }
        }
    }
}
