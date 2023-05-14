<?php

namespace App\Http\Controllers;

use App\Models\RegistrantGroup;
use App\Models\RegistrantType;
use App\Models\RegistrationFee;
use App\Models\RegistrationRate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegistrationFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($registrantGroupId)
    {
        $registration = RegistrantGroup::findOrFail($registrantGroupId);
        $breadcrumbs = [
            ['route' => route('registrations.index'), 'name' => 'Registration Management'],
            ['route' => '', 'name' => 'Registration Fee Management'],
        ];
        return view('registrations-fee.main', [
            'title' => $registration->name . ' Registration Fee Management',
            'breadcrumbs' => $breadcrumbs,
            'registration' => $registration
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($registrantGroupId)
    {
        $registration = RegistrantGroup::findOrFail($registrantGroupId);
        $breadcrumbs = [
            ['route' => route('registrations.index'), 'name' => 'Registration'],
            ['route' => route('registrations-fee.index', ['registrantGroupId' => $registration->id]), 'name' => 'Registration Fee'],
            ['route' => '', 'name' => 'Create Registration Fee'],
        ];
        $rate = array('' => 'Select rate') + RegistrationRate::select('name', 'id')->get()->pluck('name', 'id')->toArray();
        $type = array('' => 'Select type') + RegistrantType::select('name', 'id')->get()->pluck('name', 'id')->toArray();
        return view('registrations-fee.form', [
            'title' => $registration->name . ' Registration Fee Management',
            'breadcrumbs' => $breadcrumbs,
            'registration' => $registration,
            'rate' => $rate,
            'type' => $type,
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
                'registrationRateId' => 'required',
                'registrantTypeId' => 'required',
                'price' => 'required',
            ],
            [
                'registrationRateId.required' => 'Please select rate',
                'registrantTypeId.required' => 'Please select type',
                'price.required' => 'Please enter price',
            ]
        );

        $data = new RegistrationFee($request->all());
        $data->save();

        return redirect()->route('registrations-fee.index', ['registrantGroupId' => $data->registrantGroupId])->with('toast_success', 'Create data succeed!');
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
        $data = RegistrationFee::findOrFail($id);
        // 'data' => RegistrantGroup::findOrFail($id)
        $registration = RegistrantGroup::findOrFail($data->registrantGroupId);
        $breadcrumbs = [
            ['route' => route('registrations.index'), 'name' => 'Registration'],
            ['route' => route('registrations-fee.index', ['registrantGroupId' => $registration->id]), 'name' => 'Registration Fee'],
            ['route' => '', 'name' => 'Edit Registration Fee'],
        ];
        $rate = array('' => 'Select rate') + RegistrationRate::select('name', 'id')->get()->pluck('name', 'id')->toArray();
        $type = array('' => 'Select type') + RegistrantType::select('name', 'id')->get()->pluck('name', 'id')->toArray();
        return view('registrations-fee.form', [
            'title' => $registration->name . ' Registration Fee Management',
            'breadcrumbs' => $breadcrumbs,
            'registration' => $registration,
            'rate' => $rate,
            'type' => $type,
            'data' => $data
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
                'registrationRateId' => 'required',
                'registrantTypeId' => 'required',
                'price' => 'required',
            ],
            [
                'registrationRateId.required' => 'Please select rate',
                'registrantTypeId.required' => 'Please select type',
                'price.required' => 'Please enter price',
            ]
        );

        $data = RegistrationFee::findOrFail($id);
        $data->update($request->all());
        $data->save();

        return redirect()->route('registrations-fee.index', ['registrantGroupId' => $data->registrantGroupId])->with('toast_success', 'Update data succeed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = RegistrationFee::findOrFail($id);
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

        $registrantGroupId = $request->get('registrantGroupId');


        $columnorder = array(
            'id',
            'registrationRateId',
            'registrantTypeId',
            'price',
            'created_at',
            'updated_at',
            'action',
        );

        if (empty($order)) {
            $sort = 'registrationRateId';
            $dir = 'asc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
        // query
        $keyword = trim($search['value']);

        $data = RegistrationFee::when($registrantGroupId, function ($query, $registrantGroupId) {
            if (!empty($registrantGroupId)) {
                return $query->where('registrantGroupId', $registrantGroupId);
            }
        })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = RegistrationFee::select('id')->when($registrantGroupId, function ($query, $registrantGroupId) {
            if (!empty($registrantGroupId)) {
                return $query->where('registrantGroupId', $registrantGroupId);
            }
        })->count();
        $recordsFiltered = RegistrationFee::select('id')
            ->when($registrantGroupId, function ($query, $registrantGroupId) {
                if (!empty($registrantGroupId)) {
                    return $query->where('registrantGroupId', $registrantGroupId);
                }
            })
            ->count();
        $resp = DataTables::of($data)
            ->editColumn('id', function ($data) {
                return str_pad($data->id, 5, "0", STR_PAD_LEFT);
            })
            ->editColumn('registrationRateId', function ($data) {
                $data = RegistrationRate::findOrFail($data->registrationRateId);
                return $data->name;
            })
            ->editColumn('registrantTypeId', function ($data) {
                $data = RegistrantType::findOrFail($data->registrantTypeId);
                return $data->name;
            })
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->editColumn('updated_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->updated_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->updated_at)) . '</small>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                return view('registrations-fee._action', compact('id'));
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
