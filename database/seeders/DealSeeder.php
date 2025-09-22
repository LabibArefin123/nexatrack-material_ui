<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deal;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Arr;

class DealSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $clients = Customer::pluck('name')->toArray();

        // Top 25 largest Bangladeshi firms (for deal names & company options)
        $companies = [
            'Grameenphone',
            'Robi Axiata',
            'BRAC',
            'Beximco Group',
            'Square Pharmaceuticals',
            'Unilever Bangladesh',
            'ACI Limited',
            'PRAN-RFL Group',
            'Banglalink',
            'Marico Bangladesh',
            'British American Tobacco Bangladesh',
            'City Group',
            'ACI Motors',
            'Bangladesh Steel & Engineering Corporation',
            'Summit Power',
            'Navana Group',
            'SQUARE Textiles',
            'ACI Foods',
            'Rangs Group',
            'Bashundhara Group',
            'Esquire Electronics',
            'Singer Bangladesh',
            'Apex Footwear',
            'Keya Group',
            'Eastern Cables'
        ];

        $dealStages = ['new', 'create_stage', 'invoice', 'in_progress', 'final_invoice', 'deal_won', 'deal_lost', 'analyze_failure'];
        $currencies = ['BDT', 'USD', 'EUR', 'GBP', 'INR'];
        $dealTypes = ['sales', 'integrated_sales', 'merchandise_sales', 'services', 'after_sales_service'];
        $sources = ['call', 'email', 'website', 'advertising', 'existing_client', 'by_recommendation', 'show_or_exhibition', 'crm_form', 'callback', 'sales_boost', 'online_store', 'other'];

        for ($i = 0; $i < 400; $i++) {
            // Generate whole number amount excluding 41412
            do {
                $amount = rand(6, 800) * 1000; // 6,000 to 800,000 in whole thousands
            } while ($amount == 41412);

            Deal::create([
                'name' => Arr::random($companies),
                'deal_stage' => Arr::random($dealStages),
                'amount' => $amount,
                'currency' => Arr::random($currencies),
                'start_date' => date('Y-m-d', rand(strtotime('2025-06-15'), strtotime('2025-09-20'))),
                'end_date' => date('Y-m-d', rand(strtotime('2025-09-22'), strtotime('2025-12-30'))),
                'client_option' => Arr::random($clients),
                'company_option' => Arr::random($companies),
                'deal_type' => Arr::random($dealTypes),
                'source' => Arr::random($sources),
                'source_information' => 'Deal source info: please check details properly!',
                'responsibles' => Arr::random($users, rand(1, 3)),
                'observer' => Arr::random($users, rand(1, 3)),
                'comment' => 'Important deal, shob kichu properly check korben!',
            ]);
        }
    }
}
