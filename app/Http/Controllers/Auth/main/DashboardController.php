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
        return view('content.dashboard.dashboards-analytics');
    }

    public function dashboard()
    {
        $totalBidTrackUsers = Customer::where('software', 'BidTrack')->count();
        $totalBidTrackPlanUsers = Plan::where('software', 'BidTrack')->count();
        $totalTimeTrackUsers = Customer::where('software', 'Timetracks')->count();
        $totalTimetracksPlanUsers = Plan::where('software', 'Timetracks')->count();
        $totalUsers = Customer::count();
        $totalPlanUsers = Plan::count();

        $otherUsers = Customer::whereNotIn('software', ['Bidtrack', 'Timetracks'])->count();
        $otherPlanUsers = Plan::whereNotIn('software', ['Bidtrack', 'Timetracks'])->count();


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
