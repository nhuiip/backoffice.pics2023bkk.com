<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Program Management'],
        ];
        return view('program.main', [
            'title' => 'Program Management',
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('programs.index'), 'name' => 'Program Management'],
            ['route' => '', 'name' => 'Create News'],
        ];
        return view('program.form', [
            'title' => 'Create Program',
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
                'room' => 'required|max:255',
                'date' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
            ],
            [
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.',
                'room.required' => 'Please enter room',
                'room.max' => 'Room cannot be longer than 255 characters.',
                'date.required' => 'Please enter date',
                'startTime.required' => 'Please enter start time',
                'endTime.required' => 'Please enter end time',
            ]
        );

        $data = new Program($request->all());
        $data->save();

        return redirect()->route('programs.index')->with('toast_success', 'Create data succeed!');
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
            ['route' => route('programs.index'), 'name' => 'Program Management'],
            ['route' => '', 'name' => 'Edit News'],
        ];
        return view('program.form', [
            'title' => 'Edit Program',
            'breadcrumbs' => $breadcrumbs,
            'data' => Program::findOrFail($id)
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
                'room' => 'required|max:255',
                'date' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
            ],
            [
                'name.required' => 'Please enter name',
                'name.max' => 'Name cannot be longer than 255 characters.',
                'room.required' => 'Please enter room',
                'room.max' => 'Room cannot be longer than 255 characters.',
                'date.required' => 'Please enter date',
                'startTime.required' => 'Please enter start time',
                'endTime.required' => 'Please enter end time',
            ]
        );

        $data = Program::findOrFail($id);
        $data->update($request->all());
        $data->save();

        if ($request->is_highlight == null) {
            $data->is_highlight = false;
            $data->save();
        }

        return redirect()->route('programs.index')->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Program::findOrFail($id);
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
            'room',
            'date',
            'endTime',
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

        $data = Program::when($keyword, function ($query, $keyword) {
            return $query->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
            });
        })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = Program::select('id')->count();
        $recordsFiltered = Program::select('id')
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
            ->editColumn('date', function ($data) {
                return date('d/m/Y', strtotime($data->date)) . '<br><small><i class="far fa-clock"></i> ' . date('h:i', strtotime($data->startTime)).' - '.date('h:i', strtotime($data->endTime)) . '</small>';
            })
            ->editColumn('is_highlight', function ($data) {
                return $data->is_highlight ? '<i class="text-success"><u><b>Yes</b></u></i>' : '<i class="text-danger"><u><b>No</b></u></i>';
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('program._action', compact('id'));
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
