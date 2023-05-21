<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Association Management'],
        ];
        return view('association.main', [
            'title' => 'Association Management',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('associations.index'), 'name' => 'Association Management'],
            ['route' => '', 'name' => 'Create Association'],
        ];

        return view('association.form', [
            'title' => 'Create Association',
            'breadcrumbs' => $breadcrumbs,
            'countries' => array('' => 'Select country') + Country::select('nicename', 'id')->get()->pluck('nicename', 'id')->toArray()
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
                'countryId' => 'required',
                'name' => 'required|max:255',
            ],
            [
                'countryId.required' => 'Please select country',
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.'
            ]
        );

        $data = new Association($request->all());
        $data->save();

        return redirect()->route('associations.index')->with('toast_success', 'Create data succeed!');
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
            ['route' => route('associations.index'), 'name' => 'Association Management'],
            ['route' => '', 'name' => 'Edit Association'],
        ];
        return view('association.form', [
            'title' => 'Edit Association',
            'breadcrumbs' => $breadcrumbs,
            'countries' => array('' => 'Select country') + Country::select('nicename', 'id')->get()->pluck('nicename', 'id')->toArray(),
            'data' => Association::findOrFail($id)
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
                'countryId' => 'required',
                'name' => 'required|max:255',
            ],
            [
                'countryId.required' => 'Please select country',
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.'
            ]
        );

        $data = Association::findOrFail($id);
        $data->update($request->all());
        $data->save();

        return redirect()->route('associations.index')->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Association::findOrFail($id);
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
            'countryId',
            'name',
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

        $data = Association::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = Association::select('id')->count();
        $recordsFiltered = Association::select('id')
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
            ->editColumn('countryId', function ($data) {
                $data = Country::findOrFail($data->countryId);
                return $data->nicename;
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('association._action', compact('id'));
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
