<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Campaign;
use App\Models\Activity;
use App\Models\Deal;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $contractRange = (int) $request->get('contract_range', 30);
        $dealRange     = (int) $request->get('deal_range', 30);
        $dealStage     = $request->get('deal_stage');
        $activeRange   = (int) $request->get('active_range', 30);

        // Recent contracts
        $recentContracts = Contract::where('created_at', '>=', now()->subDays($contractRange))
            ->latest()
            ->take(5)
            ->get();

        // Deals query
        $dealsQuery = Deal::where('created_at', '>=', now()->subDays($dealRange));
        if (!empty($dealStage)) {
            $dealsQuery->where('deal_stage', $dealStage);
        }

        $deals = $dealsQuery
            ->selectRaw('deal_stage, COUNT(*) as count')
            ->groupBy('deal_stage')
            ->orderBy('deal_stage')
            ->get();

        $formattedStages = $deals->pluck('deal_stage')->map(function ($stage) {
            return ucwords(str_replace('_', ' ', $stage));
        })->values();

        // ✅ Recent activities
        $activities = Activity::with('owner')
            ->where('created_at', '>=', now()->subDays($activeRange))
            ->latest()
            ->take(5)
            ->get();

        // ✅ Recently created campaigns (latest 3 only)
        $campaigns = Campaign::latest()->take(3)->get();

        if ($request->ajax()) {
            return response()->json([
                'recentContracts' => $recentContracts,
                'deal_stage'      => $formattedStages,
                'stageCounts'     => $deals->pluck('count')->values(),
                'activities'      => $activities,
                'campaigns'       => $campaigns,
            ]);
        }

        return view('content.pages.analytics.index', [
            'recentContracts' => $recentContracts,
            'deal_stage'      => $formattedStages,
            'stageCounts'     => $deals->pluck('count')->values(),
            'contractRange'   => $contractRange,
            'dealRange'       => $dealRange,
            'dealStage'       => $dealStage,
            'activeRange'     => $activeRange,
            'activities'      => $activities,
            'campaigns'       => $campaigns,
        ]);
    }
}
