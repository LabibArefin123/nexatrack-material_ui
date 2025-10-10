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
        $notifications = $this->notificationAlert();
        $invoiceNotifications = $this->invoiceNotificationAlert();

        return view('content.pages.dashboard', compact(
            'totalBidTrackUsers',
            'totalBidTrackPlanUsers',
            'totalTimetracksPlanUsers',
            'totalTimeTrackUsers',
            'otherUsers',
            'otherPlanUsers',
            'totalUsers',
            'totalPlanUsers',
            'notifications',
            'invoiceNotifications'
        ));
    }

    /**
     * 🔔 Private function to generate upcoming deal expiry notifications
     */
    private function notificationAlert()
    {
        $today = Carbon::today();
        $targetDays = [30, 15, 7, 3, 2, 1];

        $notifications = [];

        foreach ($targetDays as $days) {
            $targetDate = $today->copy()->addDays($days);

            $deals = Deal::whereDate('end_date', $targetDate)->get();

            foreach ($deals as $deal) {
                $notifications[] = [
                    'message' => "Deal '{$deal->name}' (Source: {$deal->source}) ends in {$days} day(s).",
                    'days' => $days,
                    'source' => $deal->source,
                    'end_date' => $deal->end_date,
                ];
            }
        }

        return $notifications;
    }

    private function invoiceNotificationAlert()
    {
        $today = \Carbon\Carbon::today();
        $targetDays = [3, 2, 1]; // 🔔 Only 3, 2, and 1 days before due date

        $notifications = [];

        foreach ($targetDays as $days) {
            $targetDate = $today->copy()->addDays($days);

            // 🎯 Target invoices with due dates in 3/2/1 days and not fully paid
            $invoices = Invoice::whereIn('status', ['unpaid', 'partially paid', 'overdue'])
                ->whereDate('due_date', $targetDate)
                ->get();

            foreach ($invoices as $invoice) {
                $notifications[] = [
                    'message' => "Invoice #{$invoice->invoice_id} for {$invoice->client->name} is due in {$days} day(s). Please tell the client to pay for it urgently.",
                    'days' => $days,
                    'status' => $invoice->status,
                    'due_date' => $invoice->due_date,
                ];
            }
        }

        return $notifications;
    }
}
