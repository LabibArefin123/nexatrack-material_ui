<?php

namespace App\Http\Controllers\Auth\Main;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\User;
use App\Models\Deal;
use App\Models\Contract;
use App\Models\Organization;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query();

        // Filters
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }
        if ($request->filled('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }

        $activities = $query->with(['customer', 'owner', 'deal', 'contract', 'company'])
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        $activityTypes = ['call', 'email', 'task', 'meeting'];
        $reminderOptions = ['before_due', 'after_due', 'none'];

        return view('content.pages.workflow_management.activity.index', compact('activities', 'activityTypes', 'reminderOptions'));
    }

    public function create()
    {
        $customers = Customer::all();
        $users     = User::all();
        $deals     = Deal::orderBy('name', 'asc')->get()->unique('name'); // unique by name
        $contracts = Contract::orderBy('subject', 'asc')->get()->unique('subject');
        $companies = Organization::all();


        $activityTypes = ['call', 'email', 'task', 'meeting'];
        $reminderOptions = ['before_due', 'after_due', 'none'];

        return view('content.pages.workflow_management.activity.create', compact(
            'customers',
            'users',
            'deals',
            'contracts',
            'companies',
            'activityTypes',
            'reminderOptions'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'activity_type' => 'required|string|in:call,email,task,meeting',
            'due_date'      => 'required|date',
            'time'          => 'required|date_format:H:i',
            'reminder'      => 'required|string',
            'description'   => 'required|string',
            'guests'        => 'required|array',
            'customer_id'   => 'nullable|exists:customers,id',
            'owner_id'      => 'required|exists:users,id',
            'deal_id'       => 'required|exists:deals,id',
            'contract_id'   => 'required|exists:contracts,id',
            'company_id'    => 'required|exists:organizations,id',
        ]);

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity)
    {
        return view('content.pages.workflow_management.activity.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $customers = Customer::all();
        $users    = User::all();
        $deals     = Deal::all();
        $contracts = Contract::all();
        $companies = Organization::all();

        $activityTypes = ['call', 'email', 'task', 'meeting'];
        $reminderOptions = ['before_due', 'after_due', 'none'];

        return view('content.pages.workflow_management.activity.edit', compact(
            'activity',
            'customers',
            'users',
            'deals',
            'contracts',
            'companies',
            'activityTypes',
            'reminderOptions'
        ));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'activity_type' => 'required|string|in:call,email,task,meeting',
            'due_date'      => 'required|date',
            'time'          => 'nullable|date_format:H:i',
            'reminder'      => 'nullable|string',
            'description'   => 'nullable|string',
            'guests'        => 'nullable|array',
            'customer_id'   => 'nullable|exists:customers,id',
            'owner_id'      => 'nullable|exists:users,id',
            'deal_id'       => 'nullable|exists:deals,id',
            'contract_id'   => 'nullable|exists:contracts,id',
            'company_id'    => 'nullable|exists:organizations,id',
        ]);

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
}
