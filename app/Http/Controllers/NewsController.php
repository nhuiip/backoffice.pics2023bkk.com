<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // echo phpinfo();
        // die;
        $breadcrumbs = [
            ['route' => '', 'name' => 'News Management'],
        ];
        return view('news.main', [
            'title' => 'News Management',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('news.index'), 'name' => 'News Management'],
            ['route' => '', 'name' => 'Create News'],
        ];
        return view('news.form', [
            'title' => 'Create News',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:255',
                'content' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png,webp',
            ],
            [
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.',
                'content.required' => 'Please enter content',
                'image.required' => 'Please select name.',
                'image.mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
            ]
        );

        $data = new News($request->all());
        $data->save();

        if ($request->hasfile('image')) {
            $image_url = $request->file('image')->store('news', 'public');

            // !update image url
            $data->image_url = config('app.url') . "/storage/" . $image_url;
            $data->save();
        }


        return redirect()->route('news.index')->with('toast_success', 'Create data succeed!');
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
        $breadcrumbs = [
            ['route' => route('news.index'), 'name' => 'News Management'],
            ['route' => '', 'name' => 'Edit News'],
        ];
        return view('news.form', [
            'title' => 'Edit User',
            'breadcrumbs' => $breadcrumbs,
            'data' => News::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|max:255',
                'content' => 'required',
                'image' => 'mimes:jpeg,jpg,png,webp',
            ],
            [
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.',
                'content.required' => 'Please enter content',
                'image.mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
            ]
        );

        $data = News::findOrFail($id);
        $data->update($request->all());
        $data->save();

        if ($request->is_announcement == null) {
            $data->is_announcement = false;
            $data->save();
        }

        if ($request->hasfile('image')) {
            $image_url = $request->file('image')->store('news', 'public');

            // !update image url
            $data->image_url = config('app.url') . "/storage/" . $image_url;
            $data->save();
        }

        return redirect()->route('news.index')->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = News::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Delete data succeed!');
    }

    public function jsontable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');


        $columnorder = array(
            'id',
            'name',
            'is_announcement',
            'visit',
            'favorite',
            'created_at',
            'updated_at',
            'action',
        );

        if (empty($order)) {
            $sort = 'name';
            $dir = 'asc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
        // query
        $keyword = trim($search['value']);

        $data = News::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = News::select('id')->count();
        $recordsFiltered = News::select('id')
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->count();
        $resp = DataTables::of($data)
            ->editColumn('id', function ($data) {
                return str_pad($data->id, 5, "0", STR_PAD_LEFT);
            })
            ->editColumn('is_announcement', function ($data) {
                return $data->is_announcement ? '<i class="text-success"><u><b>Yes</b></u></i>' : '<i class="text-danger"><u><b>No</b></u></i>';
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('news._action', compact('id'));
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);
        return $resp;
    }
}
