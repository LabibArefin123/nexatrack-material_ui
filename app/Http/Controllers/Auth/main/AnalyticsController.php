<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Deal;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $contractRange = (int) $request->get('contract_range', 30);
        $dealRange     = (int) $request->get('deal_range', 30);
        $dealStage     = $request->get('deal_stage'); // optional filter

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

        // Format deal_stage names for display
        $formattedStages = $deals->pluck('deal_stage')->map(function ($stage) {
            return ucwords(str_replace('_', ' ', $stage));
        })->values();

        if ($request->ajax()) {
            return response()->json([
                'recentContracts' => $recentContracts,
                'deal_stage'      => $formattedStages,
                'stageCounts'     => $deals->pluck('count')->values(),
            ]);
        }

        return view('content.pages.analytics.index', [
            'recentContracts' => $recentContracts,
            'deal_stage'      => $formattedStages,
            'stageCounts'     => $deals->pluck('count')->values(),
            'contractRange'   => $contractRange,
            'dealRange'       => $dealRange,
            'dealStage'       => $dealStage,
        ]);
    }
}
