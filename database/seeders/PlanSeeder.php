<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use Faker\Factory as Faker;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $plans = ['Standard', 'Professional', 'Premium', 'Premium Plus'];
        $softwareList = ['Bidtrack', 'Timetracks'];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F']; // for name variation

        $totalRecords = 550; // roughly between 500-600
        $counter = 1;

        for ($i = 0; $i < $totalRecords; $i++) {
            $letter = $letters[array_rand($letters)];
            $software = $softwareList[array_rand($softwareList)];

            // Random date between 15 June 2025 to 20 Sep 2025
            $createdDate = $faker->dateTimeBetween('2025-06-15', '2025-09-20');

            Plan::create([
                'software'      => $software,
                'source'        => $faker->randomElement(['Website', 'Facebook', 'LinkedIn', 'Referral', 'Email Campaign']),
                'name'          => "Customer Plan {$letter} {$counter}",
                'email'         => "customerplan{$counter}@gmail.com",
                'phone'         => '01700000000',
                'company_name'  => $faker->company(),
                'address'       => $faker->address(),
                'area'          => $faker->streetName(),
                'city'          => $faker->city(),
                'country'       => $faker->country(),
                'post_code'     => $faker->postcode(),
                'plan'          => $faker->randomElement($plans),
                'created_at'    => $createdDate,
                'updated_at'    => $createdDate,
            ]);

            $counter++;
        }
    }
}
