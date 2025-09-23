<?php


namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use App\Models\Call;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index()
    {
        $calls = Call::orderBy('created_at', 'desc')->paginate(15);
        return view('content.pages.call.index', compact('calls'));
    }

    public function create()
    {
        return view('content.pages.call.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:calls,title', // ঠিক করা হলো
            'status' => 'required|in:Active,Inactive',
        ]);

        Call::create($request->only('title', 'status'));

        return redirect()->route('calls.index')->with('success', 'Call created successfully.');
    }


    public function show(Call $call)
    {
        return view('content.pages.call.show', compact('call'));
    }

    public function edit(Call $call)
    {
        return view('content.pages.call.edit', compact('call'));
    }

    public function update(Request $request, Call $call)
    {
        $request->validate([
            'title' => 'required|string|unique:calls,title,' . $call->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $call->update($request->only('title', 'status'));

        return redirect()->route('calls.index')->with('success', 'Call updated successfully.');
    }


    public function destroy(Call $call)
    {
        $call->delete();
        return redirect()->route('calls.index')->with('success', 'Call deleted successfully.');
    }
}
