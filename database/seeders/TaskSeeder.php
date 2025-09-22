<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray(); // all user IDs

        $tasksCount = 25; // set a fixed number of tasks

        $priorities = ['Low', 'Medium', 'High'];
        $statuses = ['Pending', 'In Progress', 'Completed'];

        $startDate = Carbon::create(2025, 9, 15);
        $endDate = Carbon::create(2026, 1, 10);

        $titles = [
            'Follow up with Dhaka client',
            'Prepare proposal for Chittagong company',
            'Schedule meeting with Rajshahi supplier',
            'Call Sylhet potential lead',
            'Email contract to Barishal partner',
            'Update client info in CRM',
            'Monthly sales report review',
            'Coordinate with Khulna office team',
            'Send invoice reminder to Narayanganj client',
            'Client feedback collection',
            'Prepare presentation for meeting',
            'Arrange site visit with Gazipur client',
            'Update marketing campaign details',
            'Follow up overdue payments',
            'Review contract terms with Comilla client',
            'Schedule demo for new client',
            'Confirm order delivery for Bogura customer',
            'Team briefing on project status',
            'Analyze customer complaints',
            'Update product catalog for Dhaka branch',
            'Prepare training material for support team',
            'Call VIP clients for feedback',
            'Follow up with frozen account clients',
            'Prepare end-of-year CRM report',
            'Coordinate cross-branch meeting',
        ];

        $categories = ['Follow-up', 'Meeting', 'Call', 'Email', 'Documentation'];

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

        for ($i = 0; $i < $tasksCount; $i++) {

            $taskStart = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
            $taskEnd = Carbon::createFromTimestamp(rand($taskStart->timestamp, $endDate->timestamp));

            $responsiblesCount = rand(1, min(3, count($users)));
            $responsibles = collect($users)->random($responsiblesCount)->toArray();

            $tags = $tagsList[array_rand($tagsList)];

            Task::create([
                'title' => $titles[$i % count($titles)],
                'category' => $categories[array_rand($categories)],
                'responsibles' => $responsibles,
                'start_date' => $taskStart->format('Y-m-d'),
                'due_date' => $taskEnd->format('Y-m-d'),
                'tags' => $tags,
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'description' => "Task: " . $titles[$i % count($titles)] . ". Complete all actions before due date. Ensure proper client communication and documentation.",
            ]);
        }
    }
}
