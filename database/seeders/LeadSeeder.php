<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $users = User::all();

        if ($customers->isEmpty() || $users->isEmpty()) {
            $this->command->error('Customers or Users table is empty! Please seed them first.');
            return;
        }

        $plans = ['Standard', 'Professional', 'Premium', 'Premium Plus'];

        // এখন status গুলো string আকারে
        $statuses = ['contacted', 'not_contacted', 'closed', 'lost'];

        $amountSteps = range(100000, 600000, 50000); // 100000, 150000, ..., 600000

        $startDate = strtotime("2025-06-15");
        $endDate   = strtotime("2025-12-30");

        $leads = [];

        for ($i = 0; $i < 420; $i++) {
            $customer = $customers->random();
            $user = $users->random();

            $plan = $plans[array_rand($plans)];
            $amount = $amountSteps[array_rand($amountSteps)];
            $status = $statuses[array_rand($statuses)];

            $randomTimestamp = rand($startDate, $endDate);
            $createdAt = date('Y-m-d H:i:s', $randomTimestamp);

            $leads[] = [
                'customer_id' => $customer->id,
                'name'        => $customer->name,
                'email'       => $customer->email,
                'phone'       => $customer->phone,
                'plan'        => $plan,
                'source'      => fake()->randomElement(['Website', 'Referral', 'Cold Call', 'Advertisement']),
                'status'      => $status, // এখন varchar status save হবে
                'assigned_to' => $user->id,
                'note'        => fake()->sentence(10),
                'amount'      => $amount,
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ];
        }

        // Insert in chunks
        foreach (array_chunk($leads, 100) as $chunk) {
            Lead::insert($chunk);
        }

        $this->command->info("420 Leads seeded successfully!");
    }
}
