<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estimation;
use App\Models\Organization;
use App\Models\User;
use App\Models\Project;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EstimationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $companies = Organization::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        $projects = Project::pluck('id')->toArray();

        $statuses = ['draft', 'sent', 'accepted', 'rejected'];
        $currencies = ['taka', 'rupee', 'dollar', 'pound'];

        $estimateStartDate = Carbon::create(2025, 6, 15);
        $estimateEndDate = Carbon::create(2025, 10, 15);

        $expiryStartDate = Carbon::create(2025, 10, 15);
        $expiryEndDate = Carbon::create(2026, 1, 15);

        $tagsList = [
            ['CRM', 'Client', 'Follow-up'],
            ['Sales', 'Proposal', 'Urgent'],
            ['Meeting', 'Presentation', 'Team'],
            ['Invoice', 'Finance', 'Reminder'],
            ['Marketing', 'Campaign', 'Email'],
            ['Feedback', 'Client', 'Survey'],
            ['Training', 'Support', 'Documentation'],
            ['Delivery', 'Order', 'Priority'],
            ['Contract', 'Legal', 'Review'],
            ['Report', 'Analysis', 'Monthly'],
        ];

        for ($i = 0; $i < 300; $i++) {
            $estimateDate = $faker->dateTimeBetween($estimateStartDate, $estimateEndDate);
            $expiryDate = $faker->dateTimeBetween($expiryStartDate, $expiryEndDate);

            $tags = $tagsList[array_rand($tagsList)];

            Estimation::create([
                'company_id' => $faker->randomElement($companies),
                'user_id' => $faker->randomElement($users),
                'project_id' => $faker->randomElement($projects),
                'bill_to' => $faker->company,
                'ship_to' => $faker->address,
                'amount' => $faker->numberBetween(10000, 800000),
                'currency' => $faker->randomElement($currencies),
                'estimate_date' => $estimateDate->format('Y-m-d'),
                'expiry_date' => $expiryDate->format('Y-m-d'),
                'status' => $faker->randomElement($statuses),
                'tags' => $tags,
                'attachment' => null, // optional file attachment
                'description' => $faker->paragraph(rand(2, 5)),
            ]);
        }
    }
}
