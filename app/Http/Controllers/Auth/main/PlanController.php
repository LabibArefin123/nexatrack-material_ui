<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PlanMemo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    /** 
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = $this->applyFilters($request);

        // Always order latest first
        $allContacts = $query->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        // Unique filter dropdown values
        $countries = Plan::whereNotNull('country')->distinct()->pluck('country');
        $plans     = Plan::whereNotNull('plan')->distinct()->pluck('plan');
        $softwares = Plan::whereNotNull('software')->distinct()->pluck('software');
        $sources   = Plan::whereNotNull('source')->distinct()->pluck('source');

        return view(
            'content.pages.business_management.plan.index',
            compact('allContacts', 'countries', 'plans', 'softwares', 'sources')
        );
    }

    public function exportPdf(Request $request)
    {
        $plans = $this->applyFilters($request)->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('content.pages.business_management.plan.pdf.plan', compact('plans'));

        return $pdf->stream('plans_report.pdf');
    }

    public function exportExcel(Request $request)
    {
        $contacts = $this->applyFilters($request)->orderBy('created_at', 'desc')->get();

        $filename = 'plans_filtered_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Software',
            'Name',
            'Email',
            'Phone',
            'Company',
            'Address',
            'Area',
            'City',
            'Country',
            'Post Code',
            'Plan',
            'Source',
            'Created At',
        ];

        $callback = function () use ($contacts, $columns) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel

            fputcsv($file, $columns);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->software,
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->company_name,
                    $contact->address,
                    $contact->area,
                    $contact->city,
                    $contact->country,
                    $contact->post_code,
                    $contact->plan,
                    $contact->source,
                    $contact->created_at?->format('d M Y, h:i A'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 🔹 Reusable Filter Logic
     */
    private function applyFilters(Request $request)
    {
        $query = Plan::query();

        // Dashboard style filter
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $value = $request->filter_value;

            if ($field === 'software' && strtolower($value) === 'other') {
                $query->whereNotIn('software', ['Bidtrack', 'Timetracks']);
            } else {
                $query->where($field, $value);
            }
        }

        // Normal filters
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }
        if ($request->filled('software')) {
            if (strtolower($request->software) === 'other') {
                $query->whereNotIn('software', ['Bidtrack', 'Timetracks']);
            } else {
                $query->where('software', $request->software);
            }
        }
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        return $query;
    }

    public function create()
    {
        return view('content.pages.business_management.plan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'software' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:100',
            'address' => 'required|string',
            'area' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'post_code' => 'required|string|max:25',
            'plan' => 'required|string',
            'source' => 'required|string|max:100',
        ]);

        Plan::create($request->all());

        return redirect()->route('plans.index')->with('success', 'Customer Plan added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Plan::findOrFail($id);

        $customerMemos = PlanMemo::with('plan')
            ->where('plan_id', $id)
            ->get()
            ->map(function ($memo) {
                return [
                    'remarks' => $memo->remarks,
                    'date' => $memo->date ? \Carbon\Carbon::parse($memo->date)->format('d M, Y') : 'N/A',
                    'time' => $memo->created_at ? \Carbon\Carbon::parse($memo->created_at)->format('h:i A') : 'N/A',
                ];
            });

        return view('content.pages.business_management.plan.show', compact('customer', 'customerMemos'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('content.pages.business_management.plan.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'software'      => 'nullable|string|max:255',
            'source'        => 'nullable|string|max:255',
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'company_name'  => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'area'          => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'post_code'     => 'nullable|string|max:20',
            'plan'          => 'nullable|string',
        ]);

        $customer = Plan::findOrFail($id);

        $customer->update([
            'software'      => $request->software,
            'name'          => $request->name,
            'email'         => $request->email,
            'company_name'  => $request->company_name,
            'address'       => $request->address,
            'area'          => $request->area,
            'city'          => $request->city,
            'country'       => $request->country,
            'post_code'     => $request->post_code,
            'plan'          => $request->plan,
            'source'        => $request->source,
        ]);

        // Store updated customer id in session
        return redirect()->route('plans.index')
            ->with('success', 'Customer plan updated successfully.')
            ->with('highlight', $customer->id); // <--- here
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Plan::findOrFail($id);

        $customer->delete();

        // If you want to redirect (normal request)
        return redirect()->route('plans.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function memo($id)
    {
        $customerMemos = PlanMemo::with('plan')
            ->where('plan_id', $id)
            ->orderByDesc('date') // show latest date first
            ->get();

        return view('content.pages.business_management.plan.memo.memo', compact('customerMemos', 'id'));
    }

    public function memoStore(Request $request, $id)
    {
        $customer = Plan::findOrFail($id);

        $request->validate([
            'remarks' => 'required|string',
        ]);

        PlanMemo::create([
            'plan_id' => $customer->id,
            'remarks'     => $request->remarks,
            'date'        => now()->toDateString(), // store only the date automatically
        ]);

        return redirect()->route('plan_memos.memo', $id)
            ->with('success', 'Customer plan memo uploaded successfully.');
    }

    public function memoEdit($id)
    {
        $editMemo = PlanMemo::findOrFail($id);
        return view('content.pages.business_management.plan.memo.memo_edit', compact('editMemo'));
    }

    public function memoUpdate(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string',
        ]);

        $memo = PlanMemo::findOrFail($id);
        $memo->update([
            'remarks' => $request->remarks,
            'date'    => now()->toDateString(), // update date to today automatically
        ]);

        return redirect()->route('plan_memos.memo', $memo->plan_id)
            ->with('success', 'Customer plan memo updated successfully.');
    }

    public function memoDestroy($id)
    {
        $memo = PlanMemo::findOrFail($id);
        $customerId = $memo->plan_id; // get the correct customer id
        $memo->delete();

        return redirect()->route('plan_memos.memo', $customerId) // use customer id here
            ->with('success', 'Customer plan memo deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:plans,id'
        ]);

        Plan::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Selected customer plan deleted successfully.']);
    }

    public function markRead(Plan $plan)
    {
        // Only superadmin can mark as read
        if (auth()->user()->hasRole('superadmin')) {
            $plan->is_read = 1;
            $plan->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }
}
