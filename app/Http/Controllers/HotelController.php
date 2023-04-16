<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Hotel Management'],
        ];
        return view('hotel.main', [
            'title' => 'Hotel Management',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('hotels.index'), 'name' => 'Hotel Management'],
            ['route' => '', 'name' => 'Create Hotel'],
        ];
        return view('hotel.form', [
            'title' => 'Create Hotel',
            'breadcrumbs' => $breadcrumbs,
            'nextSeq' => Hotel::count() + 1
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $maxSeq = (int)Hotel::count() + 1;
        $this->validate(
            $request,
            [
                'seq' => 'required|integer|min:1|max:' . $maxSeq,
                'ranging' => 'required|integer|min:1|max:5',
                'name' => 'required|max:255',
                'description' => 'max:255',
                'tel' => 'required|max:100',
                'email' => 'required|max:100',
                'address' => 'required|max:255',
                'roomrate' => 'required|max:255',
                'google_map' => 'max:255',
                'remark' => 'max:255',
            ],
            [
                'seq.required' => 'Please enter seq.',
                'seq.integer' => 'Please enter numbers only.',
                'seq.min' => 'Please enter at least 1 number.',
                'seq.max' => 'Please enter no more than ' . $maxSeq,
                'ranging.required' => 'Please enter ranging',
                'ranging.integer' => 'Please enter numbers only.',
                'ranging.min' => 'Please enter at least 1 number.',
                'ranging.max' => 'Please enter no more than 5',
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.',
                'description.max' => 'Description cannot be longer than 255 characters.',
                'tel.required' => 'Please enter tel.',
                'tel.max' => 'Tel cannot be longer than 100 characters.',
                'email.required' => 'Please enter email.',
                'email.max' => 'Email cannot be longer than 100 characters.',
                'address.required' => 'Please enter address.',
                'address.max' => 'Adderss cannot be longer than 255 characters.',
                'roomrate.required' => 'Please enter roomrate.',
                'roomrate.max' => 'Room rate cannot be longer than 255 characters.',
                'google_map.max' => 'Google map cannot be longer than 255 characters.',
                'remark.max' => 'Remark cannot be longer than 255 characters.',
            ]
        );

        $data = new Hotel($request->all());
        $data->save();

        return redirect()->route('hotels.index')->with('toast_success', 'Create data succeed!');
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
            ['route' => route('hotels.index'), 'name' => 'Hotel Management'],
            ['route' => '', 'name' => 'Edit Hotel'],
        ];
        return view('hotel.form', [
            'title' => 'Edit Hotel',
            'breadcrumbs' => $breadcrumbs,
            'data' => Hotel::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maxSeq = (int)Hotel::count() + 1;
        $this->validate(
            $request,
            [
                'seq' => 'required|integer|min:1|max:' . $maxSeq,
                'ranging' => 'required|integer|min:1|max:5',
                'name' => 'required|max:255',
                'description' => 'max:255',
                'tel' => 'required|max:100',
                'email' => 'required|max:100',
                'address' => 'required|max:255',
                'roomrate' => 'required|max:255',
                'google_map' => 'max:255',
                'remark' => 'max:255',
            ],
            [
                'seq.required' => 'Please enter seq.',
                'seq.integer' => 'Please enter numbers only.',
                'seq.min' => 'Please enter at least 1 number.',
                'seq.max' => 'Please enter no more than ' . $maxSeq,
                'ranging.required' => 'Please enter ranging',
                'ranging.integer' => 'Please enter numbers only.',
                'ranging.min' => 'Please enter at least 1 number.',
                'ranging.max' => 'Please enter no more than 5',
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.',
                'description.max' => 'Description cannot be longer than 255 characters.',
                'tel.required' => 'Please enter tel.',
                'tel.max' => 'Tel cannot be longer than 100 characters.',
                'email.required' => 'Please enter email.',
                'email.max' => 'Email cannot be longer than 100 characters.',
                'address.required' => 'Please enter address.',
                'address.max' => 'Adderss cannot be longer than 255 characters.',
                'roomrate.required' => 'Please enter roomrate.',
                'roomrate.max' => 'Room rate cannot be longer than 255 characters.',
                'google_map.max' => 'Google map cannot be longer than 255 characters.',
                'remark.max' => 'Remark cannot be longer than 255 characters.',
            ]
        );

        $data = Hotel::findOrFail($id);
        $data->update($request->all());
        $data->save();

        return redirect()->route('hotels.index')->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Hotel::findOrFail($id);
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
            'name',
            'ranging',
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

        $data = Hotel::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = Hotel::select('id')->count();
        $recordsFiltered = Hotel::select('id')
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
            ->editColumn('ranging', function ($data) {
                $checked = '<span class="fa fa-star checked"></span>';
                $uncheck = '<span class="fa fa-star"></span>';
                $html = '';
                for($i = 1; $i <= 5; $i++){
                    $html .= $data->ranging >= $i ? $checked : $uncheck;
                }
                return $html;
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('hotel._action', compact('id'));
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
