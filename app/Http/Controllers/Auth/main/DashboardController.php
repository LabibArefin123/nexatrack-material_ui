<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Deal;
use App\Models\Invoice;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalBidTrackUsers = Customer::where('software', 'BidTrack')->count();
        $totalTimeTrackUsers = Customer::where('software', 'Timetracks')->count();
        $totalUsers = Customer::count();
        $totalBidTrackPlanUsers = Plan::where('software', 'BidTrack')->count();
        $totalTimetracksPlanUsers = Plan::where('software', 'Timetracks')->count();
        $totalPlanUsers = Plan::count();
        $otherPlanUsers = Plan::whereNotIn('software', ['Bidtrack', 'Timetracks'])->count();
        $otherUsers = Customer::whereNotIn('software', ['Bidtrack', 'Timetracks'])->count();

        // 🟢 Get notification alerts
        $totalNotifications = $this->totalNotification();

        return view('content.pages.dashboard', compact(
            'totalBidTrackUsers',
            'totalBidTrackPlanUsers',
            'totalTimetracksPlanUsers',
            'totalTimeTrackUsers',
            'otherUsers',
            'otherPlanUsers',
            'totalUsers',
            'totalPlanUsers',
            'totalNotifications'
        ));
    }

    /**
     * 🔔 Private function to generate upcoming deal expiry notifications
     */
    private function totalNotification()
    {
        $today = \Carbon\Carbon::today();
        $notifications = [];

        // 🎯 Deal Notifications
        $targetDaysDeal = [30, 15, 7, 3, 2, 1];
        foreach ($targetDaysDeal as $days) {
            $targetDate = $today->copy()->addDays($days);
            $deals = Deal::whereDate('end_date', $targetDate)->get();

            foreach ($deals as $deal) {
                $notifications[] = [
                    'type' => 'deal',
                    'message' => "Deal '{$deal->name}' (Source: {$deal->source}) ends in {$days} day(s).",
                    'days' => $days,
                    'source' => $deal->source,
                    'end_date' => $deal->end_date,
                ];
            }
        }

        // 💰 Invoice Notifications
        $targetDaysInvoice = [3, 2, 1];
        $invoices = Invoice::whereIn('status', ['unpaid', 'partially paid', 'overdue'])
            ->whereIn(\DB::raw('DATE(due_date)'), array_map(fn($d) => $today->copy()->addDays($d)->format('Y-m-d'), $targetDaysInvoice))
            ->get();

        foreach ($invoices as $invoice) {
            $daysLeft = $today->diffInDays(\Carbon\Carbon::parse($invoice->due_date), false);
            $notifications[] = [
                'type' => 'invoice',
                'message' => "Invoice #{$invoice->invoice_id} for {$invoice->client->name} is due in {$daysLeft} day(s).",
                'days' => $daysLeft,
                'status' => $invoice->status,
                'due_date' => $invoice->due_date,
            ];
        }

        // 🔢 Sort so invoices appear first, then deals
        usort($notifications, function ($a, $b) {
            return strcmp($a['type'], $b['type']);
        });

        return $notifications;
    }
}
