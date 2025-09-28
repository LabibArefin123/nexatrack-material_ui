<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Plan;
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

    public function planReport(Request $request)
    {
        $query = Plan::query();

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filter by software
        if ($request->filled('software')) {
            $query->where('software', $request->software);
        }

        // Filter by country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Main query with pagination
        $reportData = $query->orderBy('software', 'asc')
            ->paginate(10)
            ->appends($request->all());

        // Dropdown data
        $plans = Plan::select('plan')->whereNotNull('plan')->distinct()->orderBy('plan')->get();
        $sources = Plan::select('source')->whereNotNull('source')->distinct()->orderBy('source')->pluck('source');
        $softwares = Plan::select('software')->whereNotNull('software')->distinct()->orderBy('software')->pluck('software');
        $countries = Plan::select('country')->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');

        return view('content.pages.report.plan_report', compact('reportData', 'plans', 'sources', 'softwares', 'countries'));
    }

    // PDF Route Example
    public function planReportPDF(Request $request)
    {
        $query = Plan::query();

        // Same filters as above
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }
        if ($request->filled('software')) {
            $query->where('software', $request->software);
        }
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Fetch all (no pagination for PDF)
        $reportData = $query->orderBy('software', 'asc')->get();

        $pdf = Pdf::loadView('content.pages.report.pdf.plan_report_pdf', compact('reportData'))
            ->setPaper('a4', 'landscape'); // optional

        return $pdf->stream('plan_report.pdf');
    }
}
