<?php


namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\ContactStage;
use Illuminate\Http\Request;

class ContactStageController extends Controller
{
    public function index()
    {
        $stages = ContactStage::latest()->paginate(15);
        return view('content.pages.business_management.contact_stages.index', compact('stages'));
    }

    public function create()
    {
        return view('content.pages.business_management.contact_stages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:contact_stages,title', // ঠিক করা হলো
            'status' => 'required|in:Active,Inactive',
        ]);

        ContactStage::create($request->only('title', 'status'));

        return redirect()->route('contact_stages.index')->with('success', 'Contact stage created successfully.');
    }


    public function show(ContactStage $contact_stage)
    {
        return view('content.pages.business_management.contact_stages.show', compact('contact_stage'));
    }

    public function edit(ContactStage $contact_stage)
    {
        return view('content.pages.business_management.contact_stages.edit', compact('contact_stage'));
    }

    public function update(Request $request, ContactStage $contact_stage)
    {
        $request->validate([
            'title' => 'required|string|unique:contact_stages,title,' . $contact_stage->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $contact_stage->update($request->only('title', 'status'));

        return redirect()->route('contact_stages.index')->with('success', 'Contact stage updated successfully.');
    }


    public function destroy(ContactStage $contact_stage)
    {
        $contact_stage->delete();
        return redirect()->route('contact_stages.index')->with('success', 'Contact stage deleted successfully.');
    }
}
