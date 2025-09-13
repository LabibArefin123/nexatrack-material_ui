<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBidTrackUsers = Customer::where('software', 'BidTrack')->count();
        $totalBidTrackPlanUsers = Plan::where('software', 'BidTrack')->count();
        $totalTimeTrackUsers = Customer::where('software', 'Timetrack')->count();
        $totalTimetracksPlanUsers = Plan::where('software', 'Timetrack')->count();
        $totalUsers = Customer::count();
        $totalPlanUsers = Plan::count();

        $otherUsers = Customer::whereNotIn('software', ['Bidtrack', 'Timetrack'])->count();
        $otherPlanUsers = Plan::whereNotIn('software', ['Bidtrack', 'Timetrack'])->count();


        return view('content.pages.dashboard', compact(
            'totalBidTrackUsers',
            'totalBidTrackPlanUsers',
            'totalTimetracksPlanUsers',
            'totalTimeTrackUsers',
            'otherUsers',
            'otherPlanUsers',
            'totalUsers',
            'totalPlanUsers'
        ));
    }
}
