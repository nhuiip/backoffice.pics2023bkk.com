<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Committee Management'],
        ];
        return view('committee.main', [
            'title' => 'Committee Management',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('committees.index'), 'name' => 'Committee Management'],
            ['route' => '', 'name' => 'Create Committee'],
        ];
        return view('committee.form', [
            'title' => 'Create Committee',
            'breadcrumbs' => $breadcrumbs,
            'nextSeq' => Committee::count() + 1
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $maxSeq = (int)Committee::count() + 1;
        $this->validate(
            $request,
            [
                'name' => 'required|max:100',
                'position' => 'required|max:100',
                'organization' => 'required|max:100',
                'seq' => 'required|integer|min:1|max:' . $maxSeq,
                'image' => 'mimes:jpeg,jpg,png,webp',
            ],
            [
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 100 characters.',
                'position.required' => 'Please enter position',
                'position.max' => 'Position cannot be longer than 100 characters.',
                'organization.required' => 'Please enter organization.',
                'organization.max' => 'Organization cannot be longer than 100 characters.',
                'seq.required' => 'Please enter seq',
                'seq.integer' => 'Please enter numbers only.',
                'seq.min' => 'Please enter at least 1 number.',
                'seq.max' => 'Please enter no more than ' . $maxSeq,
                'image.mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
            ]
        );

        $data = new Committee($request->all());
        $data->save();

        if ($request->hasfile('image')) {
            $image_url = $request->file('image')->store('committee', 'public');

            // !update image url
            $data->image_url = config('app.url') . "/storage/" . $image_url;
            $data->save();
        }


        return redirect()->route('committees.index')->with('toast_success', 'Create data succeed!');
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
            ['route' => route('committees.index'), 'name' => 'Committee Management'],
            ['route' => '', 'name' => 'Edit Committee'],
        ];
        return view('committee.form', [
            'title' => 'Edit Committee',
            'breadcrumbs' => $breadcrumbs,
            'data' => Committee::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maxSeq = (int)Committee::count() + 1;
        $this->validate(
            $request,
            [
                'name' => 'required|max:100',
                'position' => 'required|max:100',
                'organization' => 'required|max:100',
                'seq' => 'required|integer|min:1|max:' . $maxSeq,
                'image' => 'mimes:jpeg,jpg,png,webp',
            ],
            [
                'name.required' => 'Please enter nameใ',
                'name.max' => 'Name cannot be longer than 100 characters.',
                'position.required' => 'Please enter position',
                'position.max' => 'Position cannot be longer than 100 characters.',
                'organization.required' => 'Please enter organization.',
                'organization.max' => 'Organization cannot be longer than 100 characters.',
                'seq.required' => 'Please enter seq',
                'seq.integer' => 'Please enter numbers only.',
                'seq.min' => 'Please enter at least 1 number.',
                'seq.max' => 'Please enter no more than ' . $maxSeq,
                'image.mimes' => 'Only jpeg,jpg,png,webp file type is supported.',
            ]
        );

        $data = Committee::findOrFail($id);
        $data->update($request->all());
        $data->save();

        if ($request->hasfile('image')) {
            $image_url = $request->file('image')->store('committee', 'public');

            // !update image url
            $data->image_url = config('app.url') . "/storage/" . $image_url;
            $data->save();
        }

        return redirect()->route('committees.index')->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Committee::findOrFail($id);
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
            'image_url',
            'seq',
            'name',
            'position',
            'organization',
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

        $data = Committee::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%')->orWhere('position', 'LIKE', '%' . $keyword . '%')->orWhere('organization', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = Committee::select('id')->count();
        $recordsFiltered = Committee::select('id')
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->orWhere('name', 'LIKE', '%' . $keyword . '%')->orWhere('position', 'LIKE', '%' . $keyword . '%')->orWhere('organization', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->count();
        $resp = DataTables::of($data)
            ->editColumn('id', function ($data) {
                return str_pad($data->id, 5, "0", STR_PAD_LEFT);
            })
            ->editColumn('image_url', function ($data) {

                // return '<center><img class="rounded-circle" src="' . $data->image_url . '" alt="" style=""></center>';
                return '<center><div class="imgCommittee" style="background-image: url(' . $data->image_url . ');"></div></center>';
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('committee._action', compact('id'));
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
