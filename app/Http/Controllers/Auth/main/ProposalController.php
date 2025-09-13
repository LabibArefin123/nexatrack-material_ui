<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
{
    /**
     * Display a listing of the proposals.
     */
    public function index()
    {
        $proposals = Proposal::latest()->get();
        return view('content.pages.proposal.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new proposal.
     */
    public function create()
    {
        $clients = Customer::all();
        $projects = Project::all();
        $deals = Deal::all();
        $users = User::all();
        return view('content.pages.proposal.create', compact('clients', 'deals', 'users', 'projects'));
    }

    /**
     * Store a newly created proposal in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'date' => 'required|date',
            'open_till' => 'required|date',
            'client_id' => 'nullable|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'deal_id' => 'nullable|exists:deals,id',
            'currency' => 'nullable|string|max:10',
            'status' => 'nullable|string|max:50',
            'assigned_to' => 'nullable|json',
            'attachment' => 'nullable|file|max:51200', // 50 MB
            'tags' => 'nullable|json',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Ymd_His') . '_proposal.' . $extension;
            $file->move(public_path('uploads/proposals'), $filename);
            $data['attachment'] =  $filename;
        }

        Proposal::create($data);

        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
    }


    /**
     * Display the specified proposal.
     */
    public function show(Proposal $proposal)
    {
        return view('content.pages.proposal.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified proposal.
     */
    public function edit(Proposal $proposal)
    {
        $clients = Customer::all();
        $projects = Project::all();
        $deals = Deal::all();
        $users = User::all();
        return view('content.pages.proposal.edit', compact('proposal', 'clients', 'deals', 'users', 'projects'));
    }

    /**
     * Update the specified proposal in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'date' => 'required|date',
            'open_till' => 'required|date',
            'client_id' => 'nullable|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'deal_id' => 'nullable|exists:deals,id',
            'currency' => 'nullable|string|max:10',
            'status' => 'nullable|string|max:50',
            'assigned_to' => 'nullable|json',
            'attachment' => 'nullable|file|max:51200', // 50 MB
            'tags' => 'nullable|json',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($proposal->attachment && file_exists(public_path($proposal->attachment))) {
                unlink(public_path($proposal->attachment));
            }

            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = date('Ymd_His') . '_proposal.' . $extension;
            $file->move(public_path('uploads/proposals'), $filename);
            $data['attachment'] =  $filename;
        }

        $proposal->update($data);

        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }



    /**
     * Remove the specified proposal from storage.
     */
    public function destroy(Proposal $proposal)
    {
        // ✅ File delete logic same rakho update-er sathe
        if ($proposal->attachment && file_exists(public_path('uploads/proposals/' . $proposal->attachment))) {
            unlink(public_path('uploads/proposals/' . $proposal->attachment));
        }

        $proposal->delete();

        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }
}
