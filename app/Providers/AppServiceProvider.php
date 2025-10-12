<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Deal;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔔 Share notifications globally across all views (like navbar)
        View::composer('*', function ($view) {
            $user = Auth::user();
            $totalNotifications = [];

            if ($user) {
                $today = Carbon::today();

                // 🎯 Deal Notifications
                $targetDaysDeal = [30, 15, 7, 3, 2, 1];
                foreach ($targetDaysDeal as $days) {
                    $targetDate = $today->copy()->addDays($days);
                    $deals = Deal::whereDate('end_date', $targetDate)->get();

                    foreach ($deals as $deal) {
                        $totalNotifications[] = [
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
                    ->whereIn(DB::raw('DATE(due_date)'), array_map(fn($d) => $today->copy()->addDays($d)->format('Y-m-d'), $targetDaysInvoice))
                    ->get();

                foreach ($invoices as $invoice) {
                    $daysLeft = $today->diffInDays(Carbon::parse($invoice->due_date), false);
                    $totalNotifications[] = [
                        'type' => 'invoice',
                        'message' => "Invoice #{$invoice->invoice_id} for {$invoice->client->name} is due in {$daysLeft} day(s).",
                        'days' => $daysLeft,
                        'status' => $invoice->status,
                        'due_date' => $invoice->due_date,
                    ];
                }

                // 🔢 Sort so invoices appear first, then deals
                usort($totalNotifications, function ($a, $b) {
                    return strcmp($a['type'], $b['type']);
                });
            }

            // 🔸 Share globally to all views
            $view->with('totalNotifications', $totalNotifications);
        });
    }
}
