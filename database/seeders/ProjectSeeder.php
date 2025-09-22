<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Customer;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projectTypes = [
            'IPD Hospital',
            'OPD Hospital',
            'CRM Software',
            'Payroll System Software',
        ];

        $uniqueNames = [
            "PayMaster",
            "SalarySync",
            "CompTrack",
            "WageFlow",
            "EarnEase",
            "PayMatrix",
            "SalaryNet",
            "CompuPay",
            "PayGenix",
            "WorkPay",
            "StaffLedger",
            "PayWise",
            "PaySphere",
            "SalaryCore",
            "EarnPro",
            "PayBook",
            "PayGuard",
            "WageWave",
            "PayPilot",
            "PayNova",
            "CashTrack",
            "CompEase",
            "PayRoute",
            "SalaryBase",
            "PaySecure",
            "ClientLink",
            "RelataCRM",
            "Connectify",
            "LeadSync",
            "CRMCore",
            "TrackClient",
            "BondCRM",
            "DealSphere",
            "CRMFlow",
            "ClientHive",
            "EngageCRM",
            "LeadPilot",
            "Relatix",
            "CRMEdge",
            "CustomerNet",
            "ConnectWell",
            "CRMGuard",
            "PipelinePro",
            "ClientNova",
            "CRMTrack",
            "DealNex",
            "Relato",
            "ClientSphere",
            "EngageWell",
            "CRMPath",
            "IPDCore",
            "WardTrack",
            "PatientPlus",
            "MediWard",
            "InCare",
            "BedFlow",
            "IPDConnect",
            "HospWard",
            "CarePath",
            "StayWell",
            "MediWardX",
            "HealWard",
            "TrackIn",
            "WardNex",
            "IPDLink",
            "HospiStay",
            "CureWard",
            "WardEase",
            "PatientHub",
            "IPDSafe",
            "LifeWard",
            "InWard",
            "CareSync",
            "StayTrack",
            "WardCare",
            "OPDCore",
            "ClinicFlow",
            "VisitTrack",
            "CareVisit",
            "MediOut",
            "OPDLink",
            "HealVisit",
            "PatientDay",
            "CureVisit",
            "TrackOut",
            "HospiOut",
            "VisitEase",
            "OPDNova",
            "CareDesk",
            "PulseVisit",
            "HealthOut",
            "ClinicMate",
            "VisitNet",
            "OPDPath",
            "OutCare",
            "CareStep",
            "MediVisit",
            "OPDSync",
            "DayTrack",
            "QuickCare"
        ];

        $startRangeStart = Carbon::create(2025, 6, 15);
        $startRangeEnd   = Carbon::create(2025, 10, 15);

        $endRangeStart   = Carbon::create(2025, 10, 10);
        $endRangeEnd     = Carbon::create(2026, 1, 15);

        $priorities = ['Low', 'Medium', 'High'];
        $statuses   = ['Active', 'Inactive'];
        $stages     = ['plan', 'design', 'develop', 'completed'];

        $customerIds = Customer::pluck('id')->toArray();

        if (empty($customerIds)) {
            $this->command->warn('⚠️ No customers found! Please seed customers first.');
            return;
        }

        for ($i = 1; $i <= 120; $i++) {
            $type = $projectTypes[array_rand($projectTypes)];
            $prefix = $uniqueNames[array_rand($uniqueNames)];

            // Correct start date between 15 June – 15 Oct
            $startDate = Carbon::createFromTimestamp(
                rand($startRangeStart->timestamp, $startRangeEnd->timestamp)
            );

            // Minimum end date is startDate + 5 days
            $minEndDate = $startDate->copy()->addDays(5);

            // Correct end date between max(minEndDate, endRangeStart) – endRangeEnd
            $endStart = $minEndDate->greaterThan($endRangeStart) ? $minEndDate : $endRangeStart;
            $endDate = Carbon::createFromTimestamp(
                rand($endStart->timestamp, $endRangeEnd->timestamp)
            );

            Project::create([
                'name'           => $prefix,
                'project_photo'  => '',
                'client'         => $customerIds[array_rand($customerIds)],
                'priority'       => $priorities[array_rand($priorities)],
                'start_date'     => $startDate->format('Y-m-d'),
                'end_date'       => $endDate->format('Y-m-d'),
                'pipeline_stage' => $stages[array_rand($stages)],
                'status'         => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
