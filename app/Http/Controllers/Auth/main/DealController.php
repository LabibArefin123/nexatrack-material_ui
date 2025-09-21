<?php

namespace App\Http\Controllers\Auth\main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Deal;
use App\Models\Customer;
use App\Models\User;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $deals = Deal::query();

            $allowedFilters = [
                'name',
                'deal_stage',
                'currency',
                'deal_type',
                'source',
                'client_option',
                'company_option',
            ];

            // Apply field filter
            if ($request->filled('filter_field') && $request->filled('filter_value')) {
                $field = $request->filter_field;
                $value = $request->filter_value;
                if (in_array($field, $allowedFilters)) {
                    $deals->where($field, 'like', "%{$value}%");
                }
            }

            // Apply global search
            if ($request->filled('q')) {
                $search = $request->q;
                $deals->where(function ($q) use ($search, $allowedFilters) {
                    foreach ($allowedFilters as $field) {
                        $q->orWhere($field, 'like', "%{$search}%");
                    }
                });
            }

            $data = $deals->get()->map(function ($deal, $index) {
                $responsibles = is_array($deal->responsibles)
                    ? implode(', ', \App\Models\User::whereIn('id', $deal->responsibles)->pluck('name')->toArray())
                    : '-';

                $observers = '-';
                if (is_array($deal->observer)) {
                    $names = [];
                    foreach ($deal->observer as $obs) {
                        if (str_starts_with($obs, 'user_')) {
                            $id = str_replace('user_', '', $obs);
                            $user = \App\Models\User::find($id);
                            if ($user) $names[] = "User: {$user->name}";
                        } elseif (str_starts_with($obs, 'customer_')) {
                            $id = str_replace('customer_', '', $obs);
                            $customer = \App\Models\Customer::find($id);
                            if ($customer) $names[] = $customer->name;
                        }
                    }
                    if ($names) $observers = implode(', ', $names);
                }

                $editUrl = route('deals.edit', $deal->id);
                $deleteUrl = route('deals.destroy', $deal->id);
                $action = '
                <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            ';

                return [
                    'id' => $index + 1,
                    'name' => $deal->name,
                    'deal_stage' => $deal->deal_stage,
                    'amount' => number_format($deal->amount, 2),
                    'currency' => $deal->currency,
                    'start_date' => $deal->start_date,
                    'end_date' => $deal->end_date,
                    'client_option' => $deal->client_option,
                    'company_option' => $deal->company_option,
                    'deal_type' => $deal->deal_type,
                    'source' => $deal->source,
                    'responsibles' => $responsibles,
                    'observer' => $observers,
                    'comment' => strip_tags($deal->comment),
                    'action' => $action,
                ];
            });

            return response()->json(['data' => $data]);
        }

        // Default page load
        $deals = Deal::all();
        return view('content.pages.business_management.deal.index', compact('deals'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Customer::select('name')->distinct()->orderBy('name')->get();
        $customers = Customer::select('id', 'name', 'company_name')->get();

        $companiesByClient = [];
        foreach ($customers as $customer) {
            $clientName = $customer->name;
            $companyName = $customer->company_name;
            $companiesByClient[$clientName] ??= [];
            if (!in_array($companyName, $companiesByClient[$clientName])) {
                $companiesByClient[$clientName][] = $companyName;
            }
        }

        $users = User::all();

        // 👇 include customers also
        return view('content.pages.business_management.deal.create', compact('clients', 'users', 'companiesByClient', 'customers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deal_stage' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:5',
            'end_date' => 'required|date',
            'client_option' => 'required|string|max:255',
            'company_option' => 'nullable|string|max:255',
            'deal_type' => 'required|string',
            'source' => 'required|string|max:255',
            'source_information' => 'nullable|string',
            'start_date' => 'required|date',

            // responsible IDs (users only)
            'responsibles' => 'nullable|array',
            'responsibles.*' => 'nullable|integer|exists:users,id',

            // observers (can be "user_1" or "customer_5") → so string
            'observers' => 'nullable|array',
            'observers.*' => 'nullable|string',

            'comment' => 'nullable|string',
        ]);

        $deal = Deal::create([
            'name' => $request->name,
            'deal_stage' => $request->deal_stage,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'end_date' => $request->end_date,
            'client_option' => $request->client_option,
            'company_option' => $request->company_option,
            'deal_type' => $request->deal_type,
            'source' => $request->source,
            'source_information' => $request->source_information,
            'start_date' => $request->start_date,
            'responsibles' => $request->responsibles ?? [],
            'observer' => $request->observers ?? [],
            'comment' => $request->comment,
        ]);


        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $deal = Deal::findOrFail($id);

        $clients = Customer::select('name')->distinct()->get();
        $customers = Customer::select('id', 'name', 'company_name')->get();

        $companiesByClient = [];
        foreach ($customers as $customer) {
            $companiesByClient[$customer->name][] = $customer->company_name;
        }

        $users = User::all();

        return view('content.pages.business_management.deal.edit', compact(
            'deal',
            'clients',
            'companiesByClient',
            'users',
            'customers'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deal_stage' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:5',
            'end_date' => 'required|date',
            'client_option' => 'required|string|max:255',
            'company_option' => 'nullable|string|max:255',
            'deal_type' => 'required|string',
            'source' => 'required|string|max:255',
            'source_information' => 'nullable|string',
            'start_date' => 'required|date',

            // ✅ responsibles must exist (user IDs only)
            'responsibles'   => 'nullable|array',
            'responsibles.*' => 'nullable|integer|exists:users,id',

            // ✅ observers can be user_X or customer_Y (string)
            'observers'   => 'nullable|array',
            'observers.*' => 'nullable|string',

            'comment' => 'nullable|string',
        ]);

        $deal->update([
            'name' => $request->name,
            'deal_stage' => $request->deal_stage,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'end_date' => $request->end_date,
            'client_option' => $request->client_option,
            'company_option' => $request->company_option,
            'deal_type' => $request->deal_type,
            'source' => $request->source,
            'source_information' => $request->source_information,
            'start_date' => $request->start_date,

            // ✅ save as JSON arrays (thanks to $casts in model)
            'responsibles' => $request->responsibles ?? [],
            'observer'     => $request->observers ?? [],

            'comment' => $request->comment,
        ]);

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->delete();
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }
}
