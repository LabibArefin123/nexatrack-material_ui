<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerMemo;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\FilteredCustomersExport;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedFields = [
            'software',
            'name',
            'email',
            'phone',
            'company_name',
            'address',
            'area',
            'city',
            'country',
            'post_code',
            'note',
            'source',
            'created_at'
        ];

        $highlightId = session('highlight');

        $query = Customer::query();

        // Highlight updated customer on top
        if ($highlightId) {
            $query->orderByRaw("id = ? DESC", [$highlightId]);
        }

        // Apply field filter
        if ($request->filled('filter_field') && $request->filled('filter_value')) {
            $field = $request->filter_field;
            $value = trim($request->filter_value);
            if (in_array($field, $allowedFields)) {
                if ($field === 'software' && strtolower($value) === 'other') {
                    $query->whereNotIn('software', ['Bidtrack', 'Timetrack']);
                } else {
                    $query->where($field, $value);
                }
            }
        }

        // Global search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search, $allowedFields) {
                foreach ($allowedFields as $field) {
                    if ($field !== 'created_at') {
                        $q->orWhere($field, 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        // After filters, keep highlight at top
        if ($highlightId) {
            $query->orderByRaw("id = ? DESC", [$highlightId]);
        }

        // Always order latest created at
        $query->orderBy('created_at', 'desc');

        // DataTables AJAX
        if ($request->ajax()) {
            return DataTables::of($query)
                ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('d M Y, h:i A') : '')
                ->addColumn('actions', function ($row) {
                    $editUrl = route('customers.edit', $row->id);
                    $deleteUrl = route('customers.destroy', $row->id);
                    $memoUrl = route('customer_memos.memo', $row->id);

                    $buttons = '<a href="' . $editUrl . '" class="btn  btn-primary">Edit</a> ';
                    if (auth()->user()->hasRole('superadmin')) {
                        $buttons .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn  btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form> ';
                    }
                    $buttons .= '<a href="' . $memoUrl . '" class="btn  btn-primary"><i class="fas fa-sticky-note"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        // Page load
        $allContacts = $query->paginate(10)->withQueryString();
        return view('content.pages.community_management.customer.index', compact('allContacts'));
    }

    protected function getFilteredData(Request $request)
    {
        $allowedFields = [
            'software',
            'name',
            'email',
            'phone',
            'company_name',
            'address',
            'area',
            'city',
            'country',
            'post_code',
            'note',
            'source',
            'created_at',
        ];

        $query = Customer::query();

        /**
         * Global Search
         */
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search, $allowedFields) {
                foreach ($allowedFields as $field) {
                    if ($field !== 'created_at') {
                        $q->orWhere($field, 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        /**
         * Field Filter with 'other' logic
         */
        $field = $request->query('filter_field');
        $value = $request->query('filter_value');
        if ($field && $value && in_array($field, $allowedFields)) {
            if ($field === 'software' && $value === 'other') {
                $query->whereNotIn('software', ['Bidtrack', 'Timetrack']);
            } else {
                $query->where($field, $value);
            }
        }

        /**
         * Sorting
         */
        $sortColumn = $request->query('sort_by', 'created_at');
        $sortDirection = strtolower($request->query('sort_dir', 'desc'));
        if (in_array($sortColumn, $allowedFields) && in_array($sortDirection, ['asc', 'desc'])) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->latest();
        }

        return $query->get(); // For export/reports
    }

    public function create()
    {
        return view('content.pages.community_management.customer.create');
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
            'note' => 'required|string',
            'source' => 'required|string|max:100',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    public function filter(Request $request)
    {
        if ($request->ajax()) {
            $query = Customer::query();

            // Apply dynamic field filter
            if ($request->filled('filter_field') && $request->filled('filter_value')) {
                $field = $request->filter_field;
                $value = $request->filter_value;

                // Sanitize field to prevent SQL injection (must be a known field)
                $allowedFields = ['area', 'city', 'country', 'source', 'software'];
                if (in_array($field, $allowedFields)) {
                    $query->where($field, 'like', '%' . $value . '%');
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }

        return view('content.pages.community_management.customer.index');
    }

    public function exportPdf(Request $request)
    {
        $allowedFields = [
            'software',
            'name',
            'email',
            'phone',
            'company_name',
            'address',
            'area',
            'city',
            'country',
            'post_code',
            'note',
            'source',
            'created_at',
        ];

        $query = Customer::query();

        // Get filter params
        $field = $request->query('filter_field');
        $value = $request->query('filter_value');

        if ($field && $value && in_array($field, $allowedFields)) {
            if ($field === 'software' && $value === 'other') {
                $query->whereNotIn('software', ['Bidtrack', 'Timetrack']);
            } else {
                $query->where($field, $value);
            }
        }

        // Apply global search if present
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search, $allowedFields) {
                foreach ($allowedFields as $field) {
                    if ($field !== 'created_at') {
                        $q->orWhere($field, 'LIKE', "%{$search}%");
                    }
                }
            });
        }

        // Get filtered customers
        $customers = $query->get();

        // Generate PDF
        $pdf = Pdf::loadView('content.pages.community_management.customer.pdf.customer', compact('customers'));

        return $pdf->stream('customers_report.pdf');
    }


    public function exportExcel(Request $request)
    {
        $contacts = $this->getFilteredData($request);

        $filename = 'customers_filtered_' . now()->format('Ymd_His') . '.csv';

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
            'Note',
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
                    $contact->note,
                    $contact->source,
                    $contact->created_at?->format('d M Y, h:i A'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        $customerMemos = CustomerMemo::with('customer')
            ->where('customer_id', $id)
            ->get()
            ->map(function ($memo) {
                return [
                    'remarks' => $memo->remarks,
                    'date' => $memo->date ? \Carbon\Carbon::parse($memo->date)->format('d M, Y') : 'N/A',
                    'time' => $memo->created_at ? \Carbon\Carbon::parse($memo->created_at)->format('h:i A') : 'N/A',
                ];
            });

        return view('content.pages.community_management.customer.show', compact('customer', 'customerMemos'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('content.pages.community_management.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'software'      => 'nullable|string|max:255',
            'name'          => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'company_name'  => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'area'          => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'post_code'     => 'nullable|string|max:20',
            'note'          => 'nullable|string',
            'source'        => 'nullable|string|max:255',
        ]);

        $customer = Customer::findOrFail($id);

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
            'note'          => $request->note,
            'source'        => $request->source,
        ]);

        // Store updated customer id in session
        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.')
            ->with('highlight', $customer->id); // <--- here
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        // If you want to redirect (normal request)
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function memo($id)
    {
        $customerMemos = CustomerMemo::with('customer')
            ->where('customer_id', $id)
            ->orderByDesc('date') // show latest date first
            ->get();

        return view('content.pages.community_management.customer.memo.memo', compact('customerMemos', 'id'));
    }

    public function memoStore(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'remarks' => 'required|string',
        ]);

        // Create memo
        CustomerMemo::create([
            'customer_id' => $customer->id,
            'remarks'     => $request->remarks,
            'date'        => now()->toDateString(), // store only the date automatically
        ]);

        // ✅ Mark customer as unread again
        $customer->is_read = 0;
        $customer->save();

        return redirect()->route('customer_memos.memo', $id)
            ->with('success', 'Customer memo uploaded successfully.');
    }


    public function memoEdit($id)
    {
        $editMemo = CustomerMemo::findOrFail($id);
        return view('content.pages.community_management.customer.memo.memo_edit', compact('editMemo'));
    }

    public function memoUpdate(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string',
        ]);

        $memo = CustomerMemo::findOrFail($id);
        $memo->update([
            'remarks' => $request->remarks,
            'date'    => now()->toDateString(), // update date to today automatically
        ]);

        return redirect()->route('customer_memos.memo', $memo->customer_id)
            ->with('success', 'Customer memo updated successfully.');
    }

    public function memoDestroy($id)
    {
        $memo = CustomerMemo::findOrFail($id);
        $customerId = $memo->customer_id; // get the correct customer id
        $memo->delete();

        return redirect()->route('customer_memos.memo', $customerId) // use customer id here
            ->with('success', 'Memo deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:customers,id'
        ]);

        Customer::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => 'Selected customers deleted successfully.']);
    }

    public function markRead(Customer $customer)
    {
        if (auth()->user()->hasRole('superadmin')) {
            $customer->is_read = 1;
            $customer->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 403);
    }
}
