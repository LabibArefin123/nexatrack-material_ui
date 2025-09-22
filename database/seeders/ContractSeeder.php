<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Support\Arr;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure at least 100 customers exist
        $customers = Customer::all();
        if ($customers->count() < 100) {
            $this->command->warn("⚠️ Not enough customers. Creating dummy customers...");

            for ($i = $customers->count(); $i < 100; $i++) {
                Customer::create([
                    'name'  => 'Customer ' . ($i + 1),
                    'email' => 'customer' . ($i + 1) . '@example.com',
                ]);
            }

            $customers = Customer::all();
        }

        $contractTypes = [
            'contracts_under_seal',
            'implied_contracts',
            'executory_contracts',
            'voidable_contracts',
        ];

        // Fixed values list
        $fixedValues = [
            15000,
            20000,
            50000,
            75000,
            100000,
            150000,
            200000,
            250000,
            300000,
            500000,
        ];

        // Realistic contract subjects
        $subjects = [
            'Website Development Agreement',
            'Mobile App Development Contract',
            'Annual Maintenance Service Contract',
            'Software Licensing Agreement',
            'Digital Marketing & SEO Contract',
            'Data Hosting & Cloud Services Agreement',
            'Graphic Design & Branding Contract',
            'Consulting & Advisory Agreement',
            'IT Infrastructure Setup Contract',
            'Cybersecurity & Compliance Agreement',
            'Equipment Lease Agreement',
            'Outsourcing & BPO Contract',
            'Training & Workshop Services Agreement',
            'Advertising & Media Contract',
            'Network Installation & Support Contract',
        ];

        $startDate = now()->setDate(2025, 6, 15);
        $endDate   = now()->setDate(2025, 9, 20);

        $contractsCount = 150; // always 150 contracts
        $valueIndex = 0;       // to rotate values

        for ($i = 0; $i < $contractsCount; $i++) {
            $customer = $customers->random();

            // Random start and end date within range
            $contractStart = fake()->dateTimeBetween($startDate, $endDate);
            $contractEnd   = fake()->dateTimeBetween($contractStart, $endDate);

            // Pick value sequentially from fixedValues (rotate when reach end)
            $value = $fixedValues[$valueIndex];
            $valueIndex = ($valueIndex + 1) % count($fixedValues);

            // Pick a realistic subject (some repeat, some unique)
            $subject = Arr::random($subjects);

            Contract::create([
                'subject'     => $subject,
                'client_id'   => $customer->id,
                'type'        => Arr::random($contractTypes),
                'value'       => $value,
                'start_date'  => $contractStart->format('Y-m-d'),
                'end_date'    => $contractEnd->format('Y-m-d'),
                'attachment'  => '20250913_092100_contract.jpg', // same for all
                'description' => fake()->sentence(12),
            ]);
        }

        $this->command->info("✅ $contractsCount contracts created successfully with fixed values, realistic subjects, and same attachment!");
    }
}
