<?php

namespace App\Http\Controllers\Auth\main;

use App\Models\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the organizations.
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('content.pages.community_management.organization.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('content.pages.community_management.organization.create');
    }

    /**
     * Store a newly created organization in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name',
            'image' => 'required|file|max:5120',
            'icon'  => 'nullable|string',
        ]);

        $filePath = null;
        $destination = 'uploads/images/organization/';

        if (!file_exists(public_path($destination))) {
            mkdir(public_path($destination), 0777, true);
        }

        // Build filename -> 15 July 2025_200212_gallery.jpg
        $filename = now()->format('d_m_Y_His') . 'organization';

        // ✅ Priority: Edited image from Toast (icon)
        if ($request->icon && preg_match('/^data:image\/(\w+);base64,/', $request->icon, $type)) {
            $image = substr($request->icon, strpos($request->icon, ',') + 1);
            $image = base64_decode($image);
            $ext = strtolower($type[1]);

            $fullName = $filename . '.' . $ext;
            file_put_contents(public_path($destination . $fullName), $image);
            $filePath =  $fullName;
        }
        // ✅ Fallback: Normal file upload
        elseif ($request->hasFile('image')) {
            $file = $request->file('image');
            $fullName = $filename . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($destination), $fullName);
            $filePath =  $fullName;
        }

        Organization::create([
            'name' => $request->name,
            'image' => $filePath,
        ]);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    /**
     * Display the specified organization.
     */
    public function show(Organization $organization)
    {
        return view('content.pages.community_management.organization.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified organization.
     */
    public function edit(Organization $organization)
    {
        return view('content.pages.community_management.organization.edit', compact('organization'));
    }

    /**
     * Update the specified organization in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $organization->id,
            'image' => 'required|file|max:5120',
            'icon'  => 'nullable|string',
        ]);

        $filePath = $organization->image;
        $destination = 'uploads/images/organization/';

        if (!file_exists(public_path($destination))) {
            mkdir(public_path($destination), 0777, true);
        }

        $filename = now()->format('d_m_Y_His') . '_organization';

        // ✅ Priority: Edited image from Toast (icon)
        if ($request->icon && preg_match('/^data:image\/(\w+);base64,/', $request->icon, $type)) {
            if ($organization->image && file_exists(public_path($organization->image))) {
                unlink(public_path($organization->image));
            }

            $image = substr($request->icon, strpos($request->icon, ',') + 1);
            $image = base64_decode($image);
            $ext = strtolower($type[1]);

            $fullName = $filename . '.' . $ext;
            file_put_contents(public_path($destination . $fullName), $image);

            $filePath =  $fullName;
        }
        // ✅ Fallback: Normal file upload
        elseif ($request->hasFile('image')) {
            if ($organization->image && file_exists(public_path($organization->image))) {
                unlink(public_path($organization->image));
            }

            $file = $request->file('image');
            $fullName = $filename . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($destination), $fullName);

            $filePath =  $fullName;
        }

        $organization->update([
            'name' => $request->name,
            'image' => $filePath,
        ]);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    /**
     * Remove the specified organization from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organization.index')
            ->with('success', 'Organization deleted successfully.');
    }
}
