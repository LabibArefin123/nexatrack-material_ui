<?php


namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        $sources = Source::orderBy('created_at', 'desc')->paginate(15);
        return view('content.pages.business_management.source.index', compact('sources'));
    }

    public function create()
    {
        return view('content.pages.business_management.source.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:sources,title', // ঠিক করা হলো
            'status' => 'required|in:Active,Inactive',
        ]);

        Source::create($request->only('title', 'status'));

        return redirect()->route('sources.index')->with('success', 'Source created successfully.');
    }


    public function show(Source $source)
    {
        return view('content.pages.business_management.source.show', compact('source'));
    }

    public function edit(Source $source)
    {
        return view('content.pages.business_management.source.edit', compact('source'));
    }

    public function update(Request $request, Source $source)
    {
        $request->validate([
            'title' => 'required|string|unique:sources,title,' . $source->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $source->update($request->only('title', 'status'));

        return redirect()->route('sources.index')->with('success', 'Source updated successfully.');
    }


    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->route('sources.index')->with('success', 'Source deleted successfully.');
    }
}
