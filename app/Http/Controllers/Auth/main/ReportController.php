<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Contract;
use App\Models\Lead;
use App\Models\Campaign;
use Barryvdh\DomPDF\Facade\Pdf; // Add this

class ReportController extends Controller
{
    public function customerReport(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('customer_id')) {
            $query->where('id', $request->customer_id);
        }

        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', "%{$request->company_name}%");
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $reportData = $query->orderBy('company_name', 'asc')->paginate(10);

        $customers = Customer::orderBy('name')->get();

        return view('content.pages.report.customer_report', compact('reportData', 'customers'));
    }

    // PDF Route Example
    public function customerReportPDF(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('customer_id')) {
            $query->where('id', $request->customer_id);
        }

        if ($request->filled('company_name')) {
            $query->where('company_name', 'like', "%{$request->company_name}%");
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $reportData = $query->orderBy('created_at', 'desc')->get();

        $pdf = PDF::loadView('content.pages.report.pdf.customer_report_pdf', compact('reportData'));
        return $pdf->stream('customer_report.pdf');
    }
}
