<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function bootstrap()
    {
        //
    }

    public function jquery()
    {
        return view('pages.datatable.jquery');
    }

    public function yajra()
    {
        if (request()->ajax()) {
            $posts = Post::with('category', 'createdBy', 'updatedBy')->orderBy('name', 'asc');

            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            // Apply Date Filter
            if (!empty($dateFrom) && !empty($dateTo)) {
                $posts->whereBetween('date', [$dateFrom, $dateTo]);
            } elseif ($dateFrom) {
                $posts->whereDate('date', '>=', $dateFrom);
            } elseif ($dateTo) {
                $posts->whereDate('date', '<=', $dateTo);
            }

            return DataTables::of($posts)
                ->addIndexColumn()
                ->editColumn('date', function ($post) {
                    return Carbon::parse($post->date)->format('d M Y');
                })
                ->editColumn('category_id', function ($post) {
                    return $post->category ? $post->category->name : 'N/A';
                })
                ->filterColumn('category_id', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('created_by', function ($post) {
                    return $post->createdBy ? $post->createdBy->name : 'N/A';
                })
                ->editColumn('updated_by', function ($post) {
                    return $post->updatedBy ? $post->updatedBy->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('posts.show', $row->id);
                    $editUrl = route('posts.edit', $row->id);
                    $deleteUrl = route('posts.destroy', $row->id);
                    $pdfDownloadUrl = route('pdfDownload', ['modelType' => 'post', 'id' => $row->id]);

                    return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger deleteData" data-id="' . $row->id . '" data-url="' . $deleteUrl . '" title="Delete"><i class="fas fa-trash"></i></button>
                        <a href="' . $pdfDownloadUrl . '" class="btn btn-sm btn-primary" title="Download PDF"><i class="fas fa-download"></i></a>';
                })
                ->make(true);
        }

        return view('pages.datatable.yajra');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
