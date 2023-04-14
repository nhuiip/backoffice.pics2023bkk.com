<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Banner Management'],
        ];
        return view('banner.main', [
            'title' => 'Banner Management',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('banners.index'), 'name' => 'Banner Management'],
            ['route' => '', 'name' => 'Create Banner'],
        ];

        return view('banner.form', [
            'title' => 'Create Banner',
            'breadcrumbs' => $breadcrumbs,
            'nextSeq' => Banner::count() + 1,
            'type' => array('' => 'Select type', 1 => 'Image', 2 => 'Video')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $maxSeq = (int)Banner::count() + 1;
        $this->validate(
            $request,
            [
                'type' => 'required',
                'seq' => 'required|integer|min:1|max:' . $maxSeq,
                'image' => 'required_if:type,==,1|mimes:jpeg,jpg,png,webp',
                'url' => 'required_if:type,==,2',
            ],
            [
                'type.required' => 'Please select type',
                'seq.required' => 'Please enter seq',
                'seq.integer' => 'Please enter numbers only.',
                'seq.min' => 'Please enter at least 1 number.',
                'seq.max' => 'Please enter no more than ' . $maxSeq,
                'image.required_if' => 'Please select image.',
                'image.mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
                'url.required_if' => 'Please enter url.',
            ]
        );

        $data = new Banner($request->all());
        $data->save();

        if ($request->hasfile('image')) {
            $image_url = $request->file('image')->store('banner', 'public');

            // !update image url
            $data->url = config('app.url') . "/storage/" . $image_url;
            $data->save();
        }


        return redirect()->route('banners.index')->with('toast_success', 'Create data succeed!');
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
            ['route' => route('banners.index'), 'name' => 'Banner Management'],
            ['route' => '', 'name' => 'Edit Banner'],
        ];
        return view('banner.form', [
            'title' => 'Edit Banner',
            'breadcrumbs' => $breadcrumbs,
            'type' => array('' => 'Select type', 1 => 'Image', 2 => 'Video'),
            'data' => Banner::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maxSeq = (int)Banner::count() + 1;
        $this->validate(
            $request,
            [
                'type' => 'required',
                'seq' => 'required|integer|min:1|max:' . $maxSeq,
                'image' => 'required_if:type,==,1|mimes:jpeg,jpg,png,webp',
                'url' => 'required_if:type,==,2',
            ],
            [
                'type.required' => 'Please select type',
                'seq.required' => 'Please enter seq',
                'seq.integer' => 'Please enter numbers only.',
                'seq.min' => 'Please enter at least 1 number.',
                'seq.max' => 'Please enter no more than ' . $maxSeq,
                'image.required_if' => 'Please select image.',
                'image.mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
                'url.required_if' => 'Please enter url.',
            ]
        );

        $data = Banner::findOrFail($id);
        $data->update($request->all());
        $data->save();

        if ($request->hasfile('image')) {
            $image_url = $request->file('image')->store('banner', 'public');

            // !update image url
            $data->url = config('app.url') . "/storage/" . $image_url;
            $data->save();
        }

        return redirect()->route('banners.index')->with('toast_success', 'Create data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Banner::findOrFail($id);
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
            'seq',
            'type',
            'url',
            'created_at',
            'updated_at',
            'action',
        );

        if (empty($order)) {
            $sort = 'seq';
            $dir = 'asc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
        // query
        $keyword = trim($search['value']);

        $data = Banner::offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = Banner::select('id')->count();
        $recordsFiltered = Banner::select('id')
            ->count();
        $resp = DataTables::of($data)
            ->editColumn('id', function ($data) {
                return str_pad($data->id, 5, "0", STR_PAD_LEFT);
            })
            ->editColumn('type', function ($data) {
                switch ($data->type) {
                    case 2:
                        $type = 'Video';
                        break;

                    default:
                        $type = 'Image';
                        break;
                }
                return $type;
            })
            ->editColumn('url', function ($data) {
                return '<a href="' . $data->url . '" target="_blank">' . $data->url . '</a>';
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('banner._action', compact('id'));
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
