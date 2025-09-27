<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Contract;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure some owners exist
        $owners = User::count() ? User::all() : User::factory(10)->create();

        $data = [
            [
                'title' => 'We scheduled a meeting for next week',
                'activity_type' => 'meeting',
                'due_date' => Carbon::create(2025, 9, 25, 12, 12),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 9, 22, 10, 14),
            ],
            [
                'title' => 'Had conversation with Fred regarding task',
                'activity_type' => 'call',
                'due_date' => Carbon::create(2025, 9, 29, 16, 12),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 9, 27, 15, 26),
            ],
            [
                'title' => 'Analysing latest time estimation for new project',
                'activity_type' => 'email',
                'due_date' => Carbon::create(2025, 10, 11, 17, 00),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 10, 3, 15, 53),
            ],
            [
                'title' => 'Store and manage contact data',
                'activity_type' => 'task',
                'due_date' => Carbon::create(2025, 10, 19, 14, 25),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 10, 14, 13, 25),
            ],
            [
                'title' => 'Will have a meeting before project start',
                'activity_type' => 'meeting',
                'due_date' => Carbon::create(2025, 10, 27, 12, 30),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 10, 21, 15, 0),
            ],
            [
                'title' => 'Call John and discuss about project',
                'activity_type' => 'call',
                'due_date' => Carbon::create(2025, 11, 12, 22, 20),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 11, 2, 17, 35),
            ],
            [
                'title' => 'Built landing pages',
                'activity_type' => 'task',
                'due_date' => Carbon::create(2025, 11, 25, 13, 40),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 11, 20, 8, 20),
            ],
            [
                'title' => 'Regarding latest updates in project',
                'activity_type' => 'email',
                'due_date' => Carbon::create(2025, 11, 30, 21, 20),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 11, 25, 19, 20),
            ],
            [
                'title' => 'Discussed budget proposal with Edwin',
                'activity_type' => 'call',
                'due_date' => Carbon::create(2025, 12, 8, 16, 35),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 12, 1, 10, 45),
            ],
            [
                'title' => 'Attach final proposal for upcoming project',
                'activity_type' => 'email',
                'due_date' => Carbon::create(2025, 12, 19, 14, 20),
                'owner_id' => $owners->random()->id,
                'created_at' => Carbon::create(2025, 12, 10, 18, 30),
            ],
        ];

        foreach ($data as $item) {
            $dueDate = $item['due_date'];

            Activity::create([
                ...$item,
                'customer_id' => Customer::inRandomOrder()->value('id'),
                'deal_id' => Deal::inRandomOrder()->value('id'),
                'contract_id' => Contract::inRandomOrder()->value('id'),
                'company_id' => Organization::inRandomOrder()->value('id'),
                'time' => $dueDate->format('H:i:s'),
                'reminder' => collect([5, 10, 15, 30, 60])->random(), // minutes before due
                'guests' => Customer::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray(),
                'description' => fake()->sentence(8),
            ]);
        }
    }
}
