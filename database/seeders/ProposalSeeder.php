<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients  = Customer::pluck('id')->toArray();
        $projects = Project::pluck('id')->toArray();
        $deals    = Deal::pluck('id')->toArray();
        $users    = User::pluck('id')->toArray();

        // Meaningful tags
        $tagPool = [
            'urgent',
            'priority',
            'client',
            'review',
            'deadline',
            'negotiation',
            'contract',
            'follow-up',
            'finalized',
            'design',
            'development',
            'marketing',
            'budget',
            'approval'
        ];

        // Some subject patterns for realistic proposals
        $subjectPatterns = [
            'Website Redesign Proposal for :company',
            'Marketing Campaign Plan - :company',
            'Software Development Agreement with :company',
            'Mobile App Project Scope for :company',
            'Brand Strategy Proposal - :company',
            'IT Support Contract for :company',
            'SEO Optimization Plan - :company',
            'Cloud Migration Proposal - :company',
            'Product Launch Strategy for :company',
            'Annual Maintenance Contract - :company',
        ];

        for ($i = 1; $i <= 350; $i++) {
            $date     = fake()->dateTimeBetween('2025-06-15', '2025-09-30');
            $openTill = fake()->dateTimeBetween('2025-09-01', '2025-12-30');

            $company  = fake()->company();
            $pattern  = Arr::random($subjectPatterns);
            $subject  = str_replace(':company', $company, $pattern);

            Proposal::create([
                'subject'     => $subject,
                'client_id'   => Arr::random($clients),
                'project_id'  => Arr::random($projects),
                'deal_id'     => Arr::random($deals),
                'currency'    => Arr::random(['taka', 'rupee', 'dollar', 'pound']),
                'status'      => Arr::random(['draft', 'sent', 'accepted', 'rejected']),
                'date'        => $date,
                'open_till'   => $openTill,
                'assigned_to' => fake()->randomElements($users, rand(1, 3)), // 1–3 users
                'tags'        => fake()->randomElements($tagPool, rand(2, 5)), // 2–5 tags
                'description' => fake()->paragraph(3),
                'attachment'  => null,
            ]);
        }
    }
}
