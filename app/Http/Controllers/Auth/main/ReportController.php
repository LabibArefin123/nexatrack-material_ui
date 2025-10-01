<?php

namespace App\Http\Controllers\Auth\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Deal;
use App\Models\Contract;
use App\Models\Lead;
use App\Models\User;
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
        $reportData = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->all());

        // Dropdown data
        $plans = Plan::select('plan')->whereNotNull('plan')->distinct()->orderBy('plan')->get();
        $sources = Plan::select('source')->whereNotNull('source')->distinct()->orderBy('source')->pluck('source');
        $softwares = Plan::select('software')->whereNotNull('software')->distinct()->orderBy('software')->pluck('software');
        $countries = Plan::select('country')->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');

        return view('content.pages.report.plan_report', compact('reportData', 'plans', 'sources', 'softwares', 'countries'));
    }

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

    // -- Start of Contract Report Part -- //
    public function contractReport(Request $request)
    {
        $query = Contract::with(['customer']);

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by Customer
        if ($request->filled('customer_id')) {
            $query->where('client_id', $request->customer_id);
        }


        // Date filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $reportData = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->all());

        // Dropdown data
        $types = Contract::select('type')->whereNotNull('type')->distinct()->pluck('type');
        $customers = Contract::with('customer')->whereNotNull('client_id')->get()->pluck('customer.name', 'client_id')->unique();

        return view('content.pages.report.contract_report', compact('reportData', 'types', 'customers'));
    }

    public function contractReportPDF(Request $request)
    {
        $query = Contract::with(['customer']);

        // Same filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('customer_id')) {
            $query->where('client_id', $request->customer_id);
        }
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $reportData = $query->orderBy('id', 'asc')->get();

        $pdf = Pdf::loadView('content.pages.report.pdf.contract_report_pdf', compact('reportData'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('contract_report.pdf');
    }
    // -- End of Contract Report Part -- //

    // -- Start of Deal Report Part -- //

    public function dealReport(Request $request)
    {
        $query = Deal::query();

        // Filter by stage
        if ($request->filled('deal_stage')) {
            $query->where('deal_stage', $request->deal_stage);
        }

        // Filter by type
        if ($request->filled('deal_type')) {
            $query->where('deal_type', $request->deal_type);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
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
        $deals = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->all());

        // Dropdown data
        $stages = Deal::select('deal_stage')->whereNotNull('deal_stage')->distinct()->orderBy('deal_stage')->pluck('deal_stage');
        $types = Deal::select('deal_type')->whereNotNull('deal_type')->distinct()->orderBy('deal_type')->pluck('deal_type');
        $sources = Deal::select('source')->whereNotNull('source')->distinct()->orderBy('source')->pluck('source');

        return view('content.pages.report.deal_report', compact('deals', 'stages', 'types', 'sources'));
    }

    public function dealReportPDF(Request $request)
    {
        $query = Deal::query();

        if ($request->filled('deal_stage')) {
            $query->where('deal_stage', $request->deal_stage);
        }
        if ($request->filled('deal_type')) {
            $query->where('deal_type', $request->deal_type);
        }
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $reportData = $query->orderBy('id', 'asc')->get();

        $pdf = Pdf::loadView('content.pages.report.pdf.deal_report_pdf', compact('reportData'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('deal_report.pdf');
    }

    // -- End of Deal Report Part -- //

    // -- Start of Lead Report Part -- //

    public function leadReport(Request $request)
    {
        $query = Lead::with(['customer', 'assignedUser']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        // Filter by assigned_to
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
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
        $leads = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->all());

        // Dropdown data
        $statuses = Lead::select('status')->whereNotNull('status')->distinct()->orderBy('status')->pluck('status');
        $plans = Lead::select('plan')->whereNotNull('plan')->distinct()->orderBy('plan')->pluck('plan');
        $assignedUsers = User::select('id', 'name')->orderBy('name')->get();

        return view('content.pages.report.lead_report', compact('leads', 'statuses', 'plans', 'assignedUsers'));
    }

    public function leadReportPDF(Request $request)
    {
        $query = Lead::with(['customer', 'assignedUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $reportData = $query->orderBy('id', 'asc')->get();

        $pdf = Pdf::loadView('content.pages.report.pdf.lead_report_pdf', compact('reportData'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('lead_report.pdf');
    }

    // -- End of Lead Report Part -- //
}
