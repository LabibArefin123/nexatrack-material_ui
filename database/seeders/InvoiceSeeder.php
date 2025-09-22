<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = strtotime('2025-06-15');
        $endDate   = strtotime('2025-09-20');

        $totalRecords = 450;

        $clients = \App\Models\Organization::pluck('id')->toArray();
        $projects = \App\Models\Project::pluck('id')->toArray();
        $users = \App\Models\User::pluck('id')->toArray();

        $currencies = ['usd', 'bdt', 'inr', 'gbp'];
        $paymentMethods = ['cash', 'bank', 'card'];
        $statuses = ['unpaid', 'paid', 'partially paid', 'overdue'];

        $batchSize = 1000; // insert in chunks
        $data = [];

        for ($i = 1; $i <= $totalRecords; $i++) {
            $randDate = rand($startDate, $endDate);
            $invoiceDate = date('Y-m-d', $randDate);
            $dueDate = date('Y-m-d', strtotime($invoiceDate . ' +15 days'));

            // Generate "nice looking" amount
            $rawAmount = rand(1000, 600000);
            $amount = round($rawAmount, -2); // round to nearest 100

            $clientId = $clients[array_rand($clients)] ?? 1;
            $projectId = $projects[array_rand($projects)] ?? 1;
            $userId = $users[array_rand($users)] ?? 1;

            $items = [
                [
                    'name' => 'Service ' . Str::random(5),
                    'quantity' => rand(1, 10),
                    'price' => rand(100, 5000),
                    'discount' => rand(0, 500),
                    'amount' => $amount,
                ]
            ];

            $data[] = [
                'invoice_id' => 'INV-' . strtoupper(Str::random(8)),
                'client_id' => $clientId,
                'project_id' => $projectId,
                'user_id' => $userId,
                'bill_to' => 'Bill Address ' . rand(1, 500),
                'ship_to' => 'Ship Address ' . rand(1, 500),
                'amount' => $amount,
                'currency' => $currencies[array_rand($currencies)],
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'paid_amount' => rand(0, $amount),
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'status' => $statuses[array_rand($statuses)],
                'description' => 'Invoice generated for testing purpose',
                'items' => json_encode($items),
                'notes' => 'Auto seeded notes',
                'terms' => 'Payment due within 15 days',
                'transaction_id' => strtoupper(Str::random(12)),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($i % $batchSize == 0) {
                Invoice::insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            Invoice::insert($data);
        }
    }
}
