<?php


namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\LostReason;
use Illuminate\Http\Request;

class LostReasonController extends Controller
{
    public function index()
    {
        $reasons = LostReason::latest()->paginate(15);
        return view('content.pages.business_management.lost_reason.index', compact('reasons'));
    }

    public function create()
    {
        return view('content.pages.business_management.lost_reason.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:lost_reasons,title', // ঠিক করা হলো
            'status' => 'required|in:Active,Inactive',
        ]);

        LostReason::create($request->only('title', 'status'));

        return redirect()->route('lost_reasons.index')->with('success', 'Reason created successfully.');
    }


    public function show(LostReason $lost_reason)
    {
        return view('content.pages.business_management.lost_reason.show', compact('lost_reason'));
    }

    public function edit(LostReason $lost_reason)
    {
        return view('content.pages.business_management.lost_reason.edit', compact('lost_reason'));
    }

    public function update(Request $request, LostReason $lost_reason)
    {
        $request->validate([
            'title' => 'required|string|unique:lost_reasons,title,' . $lost_reason->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $lost_reason->update($request->only('title', 'status'));

        return redirect()->route('lost_reasons.index')->with('success', 'Reason updated successfully.');
    }


    public function destroy(LostReason $lost_reason)
    {
        $lost_reason->delete();
        return redirect()->route('lost_reasons.index')->with('success', 'Reason deleted successfully.');
    }
}
