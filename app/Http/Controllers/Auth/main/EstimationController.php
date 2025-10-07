<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Estimation;
use App\Models\Project;
use App\Models\Organization;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;

class EstimationController extends Controller
{
    /**
     * Display a listing of the Estimations.
     */
    public function index(Request $request)
    {
        $query = Estimation::query()->with('company');

        // Filter by deal/company name
        if ($request->filled('deal_name')) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('name', $request->deal_name);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('estimate_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('expiry_date', '<=', $request->end_date);
        }

        // Get all company names for the filter dropdown
        $allNames = \App\Models\Organization::orderBy('name')->pluck('name');

        $estimateds = $query->latest()->paginate(15)->withQueryString();

        return view('content.pages.finance_management.estimation.index', compact('estimateds', 'allNames'));
    }

    /**
     * Show the form for creating a new Estimation.
     */
    public function create()
    {
        $clients = Organization::all();
        $projects = Project::all();
        $users = User::all();
        return view('content.pages.finance_management.estimation.create', compact('clients', 'users', 'projects'));
    }

    /**
     * Store a newly created Estimation in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:organizations,id',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'bill_to' => 'required|string|max:255',
            'ship_to' => 'required|string|max:255',
            'estimate_date' => 'required|date',
            'expiry_date' => 'required|date',
            'amount' => 'required|string|max:50',
            'currency' => 'required|string|max:10',
            'status' => 'required|string|max:50',
            'tags' => 'required|json',
            'attachment' => 'nullable|file|max:51200', // 50 MB
            'description' => 'required|string',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Ymd_His') . '_estimate.' . $extension;
            $file->move(public_path('uploads/estimation'), $filename);
            $data['attachment'] =  $filename;
        }

        Estimation::create($data);

        return redirect()->route('estimations.index')->with('success', 'Estimation created successfully.');
    }


    /**
     * Display the specified Estimation.
     */
    public function show(Estimation $estimation)
    {
        return view('content.pages.finance_management.estimation.show', compact('estimation'));
    }

    /**
     * Show the form for editing the specified Estimation.
     */
    public function edit(Estimation $estimation)
    {
        $clients = Organization::all();
        $projects = Project::all();
        $users = User::all();
        return view('content.pages.finance_management.estimation.edit', compact('estimation', 'clients', 'users', 'projects'));
    }

    /**
     * Update the specified Estimation in storage.
     */
    public function update(Request $request, Estimation $estimation)
    {
        $data = $request->validate([
            'company_id' => 'nullable|exists:organizations,id',
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'bill_to' => 'required|string|max:255',
            'ship_to' => 'required|string|max:255',
            'estimate_date' => 'required|date',
            'expiry_date' => 'required|date',
            'amount' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:10',
            'status' => 'nullable|string|max:50',
            'tags' => 'nullable|json',
            'attachment' => 'nullable|file|max:51200', // 50 MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($estimation->attachment && file_exists(public_path($estimation->attachment))) {
                unlink(public_path($estimation->attachment));
            }

            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Ymd_His') . '_estimate.' . $extension;
            $file->move(public_path('uploads/estimations'), $filename);
            $data['attachment'] =  $filename;
        }

        $estimation->update($data);

        return redirect()->route('estimations.index')->with('success', 'Estimation updated successfully.');
    }

    /**
     * Remove the specified Estimation from storage.
     */
    public function destroy(Estimation $estimation)
    {
        // ✅ File delete logic same rakho update-er sathe
        if ($estimation->attachment && file_exists(public_path('uploads/estimations/' . $estimation->attachment))) {
            unlink(public_path('uploads/estimations/' . $estimation->attachment));
        }

        $estimation->delete();

        return redirect()->route('estimations.index')
            ->with('success', 'Estimation deleted successfully.');
    }
}
