<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Plan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function welcome()
    {
        return view('frontend.welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalBidTrackUsers = Customer::where('software', 'BidTrack')->count();
        $totalBidTrackPlanUsers = Plan::where('software', 'BidTrack')->count();
        $totalTimeTrackUsers = Customer::where('software', 'Timetrack')->count();
        $totalTimetracksPlanUsers = Plan::where('software', 'Timetrack')->count();
        $totalUsers = Customer::count();
        $totalPlanUsers = Plan::count();

        $otherUsers = Customer::whereNotIn('software', ['Bidtrack', 'Timetrack'])->count();
        $otherPlanUsers = Plan::whereNotIn('software', ['Bidtrack', 'Timetrack'])->count();


        return view('pages.dashboard', compact(
            'totalBidTrackUsers',
            'totalBidTrackPlanUsers',
            'totalTimetracksPlanUsers',
            'totalTimeTrackUsers',
            'otherUsers',
            'otherPlanUsers',
            'totalUsers',
            'totalPlanUsers'
        ));
    }


    public function contactList(Request $request)
    {
        // Get search query and sorting parameters, with defaults
        $q = $request->get('q');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        // Allowed columns for sorting to prevent SQL injection
        $allowedSorts = [
            'name',
            'email',
            'company_name',
            'software',
            'city',
            'country',
            'post_code',
            'area',
            'created_at',
        ];

        // Build query
        $query = Customer::query();

        // Search filter
        if ($q) {
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('company_name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%")
                    ->orWhere('area', 'like', "%{$q}%")
                    ->orWhere('country', 'like', "%{$q}%")
                    ->orWhere('software', 'like', "%{$q}%");
            });
        }

        // Sort
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Handle AJAX autocomplete suggestions (keep unchanged)
        if ($request->ajax() || $request->get('ajax') == 1) {
            if (!$q) {
                return response()->json([]);
            }

            $limit = 12;
            $fields = [
                'Software' => 'software',
                'Name' => 'name',
                'Email' => 'email',
                'Phone' => 'phone',
                'Company' => 'company_name',
                'Address' => 'area',
                'Area' => 'area',
                'City' => 'city',
                'Country' => 'country',
                'Post Code' => 'post_code',
                'Note' => 'note',
                'Source' => 'source',
            ];

            $groupedSuggestions = [];

            foreach ($fields as $type => $field) {
                $values = Customer::where($field, 'like', "%{$q}%")
                    ->distinct()
                    ->limit($limit)
                    ->pluck($field)
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                if (!empty($values)) {
                    $groupedSuggestions[$type] = $values;
                }
            }

            return response()->json($groupedSuggestions);
        }

        // Paginate results
        $allContacts = $query->paginate(25)->withQueryString();

        // Group paginated contacts by date string (e.g. '15 July 2025')
        $groupedContacts = $allContacts->getCollection()
            ->groupBy(function ($item) {
                return $item->created_at->format('d F Y'); // Format to group by full date
            });

        // Pass the grouped collection and paginator to the view
        return view('contact_list', [
            'groupedContacts' => $groupedContacts,
            'allContacts' => $allContacts,
        ]);
    }
}
