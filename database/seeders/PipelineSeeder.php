<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pipeline;
use Faker\Factory as Faker;

class PipelineSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $pipelineNames = [
            'Sales',
            'Marketing',
            'Email',
            'Chats',
            'Operational',
            'Collaborative',
            'Differentiate',
            'Interact'
        ];

        $stages = ['win', 'in_pipeline', 'conversation', 'lost'];
        $statuses = ['Active', 'Inactive'];

        $recordsToCreate = rand(500, 650);

        for ($i = 0; $i < $recordsToCreate; $i++) {
            // Generate a date excluding 1 September 2025
            do {
                $createdDate = $faker->dateTimeBetween('2025-06-15', '2025-12-30')->format('Y-m-d');
            } while ($createdDate === '2025-09-01');

            Pipeline::create([
                'name' => $pipelineNames[array_rand($pipelineNames)],
                'total_deal_value' => rand(5, 800) * 1000, // 5,000 to 800,000
                'no_of_deals' => rand(10, 600),
                'stage' => $stages[array_rand($stages)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $createdDate,
                'updated_at' => $createdDate,
            ]);
        }
    }
}
