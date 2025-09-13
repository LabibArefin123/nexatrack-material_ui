<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Estimation;
use App\Models\Project;
use App\Models\Organization;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstimationController extends Controller
{
    /**
     * Display a listing of the Estimations.
     */
    public function index()
    {
        $estimateds = Estimation::latest()->get();
        return view('content.pages.estimation.index', compact('estimateds'));
    }

    /**
     * Show the form for creating a new Estimation.
     */
    public function create()
    {
        $clients = Organization::all();
        $projects = Project::all();
        $users = User::all();
        return view('content.pages.estimation.create', compact('clients', 'users', 'projects'));
    }

    /**
     * Store a newly created Estimation in storage.
     */
    public function store(Request $request)
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
        return view('content.pages.estimation.show', compact('estimation'));
    }

    /**
     * Show the form for editing the specified Estimation.
     */
    public function edit(Estimation $estimation)
    {
        $clients = Organization::all();
        $projects = Project::all();
        $users = User::all();
        return view('content.pages.estimation.edit', compact('estimation', 'clients', 'users', 'projects'));
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
