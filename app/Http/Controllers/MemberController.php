<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use App\Mail\InfoMail;
use App\Mail\PaymentMail;
use App\Mail\RemindMail;
use App\Models\Association;
use App\Models\Country;
use App\Models\Member;
use App\Models\RegistrantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Registrant Management'],
        ];
        return view('member.main', [
            'title' => 'Registrant Management',
            'breadcrumbs' => $breadcrumbs,
            'countries' => Member::select('country')->distinct()->get(),
            'registrant_groups' => Member::select('registrant_group')->distinct()->get(),
            'registration_types' => Member::select('registration_type')->distinct()->get(),
        ]);
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
    public function edit(string $id, string $formType)
    {
        $breadcrumbs = [
            ['route' => route('members.index'), 'name' => 'Registrant Management'],
            ['route' => '', 'name' => 'Edit Registrant'],
        ];

        $data = Member::findOrFail($id);
        $registrationType = RegistrantType::where('name', $data->registration_type)->first();
        $registrantTypeId = $registrationType->id;

        $countries = null;
        $countAssociations = Association::where('registrantTypeId', $registrantTypeId)->count();

        if ($countAssociations == 0) {
            $countries = Country::all();
        } else {
            $countries = Country::whereHas('associations', function ($query) use ($registrantTypeId) {
                $query->where('registrantTypeId', $registrantTypeId);
            })->get();
        }

        return view('member.form', [
            'title' => 'Edit Registrant',
            'breadcrumbs' => $breadcrumbs,
            'formType' => $formType,
            'registrantTypeId' => $registrantTypeId,
            'countries' => array('' => 'Select data') + $countries->pluck('nicename', 'nicename')->toArray(),
            'hasAssociation' => $countAssociations > 0 ? true : false,
            'associations' => Association::select('name')->where('name', $data->organization)->count() != 0 ? Association::select('name')->where('name', $data->organization)->get()->pluck('name', 'name')->toArray() : null,
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->formType == 'upload') {
            if ($request->action == 'upload_receipt') {
                $this->validate(
                    $request,
                    [
                        'receipt' => 'required|mimes:jpeg,jpg,png,webp,pdf',
                    ],
                    [
                        'receipt.required' => 'Please select receipt.',
                        'receipt.mimes' => 'Only jpeg,jpg,png,webp, pdf file type is supported.',
                    ]
                );

                if ($request->hasfile('receipt')) {
                    $filename = $request->file('receipt')->getClientOriginalName();
                    $file_url = env('APP_URL') . "/receipt/" . $filename;
                    Storage::disk('public')->put($file_url, file_get_contents($request->file('receipt')));

                    $data = Member::findOrFail($id);
                    $data->receipt = $file_url;
                    $data->save();
                }

                return redirect()->route('members.index')->with('toast_success', 'Upload receipt succeed!');
            }
            $data = Member::findOrFail($id);
            $data->update($request->all());
            $data->save();

            if (isset($request->payment_status) && $request->payment_status == 2) {
                // send email
                Mail::to($data->email)->send(new PaymentMail($data));
            }

            return true;
        } else {
            $this->validate(
                $request,
                [
                    'email' => 'required|email|max:255|unique:members,email,' . $id,
                    'email_secondary' => 'required|email|max:255',
                    'title' => 'required|max:255',
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'address' => 'required|max:255',
                    'address_2' => 'max:255',
                    'city' => 'required|max:255',
                    'city_code' => 'required|max:255',
                    'country' => 'required',
                    'phone' => 'required|max:255',
                    'phone_mobile' => 'required|max:255',
                    'organization' => 'required|max:255',
                    'profession_title' => 'required|max:255',
                    'tax_id' => 'required|max:255',
                    'tax_phone' => 'required|max:255',
                    'dietary_restrictions' => 'max:255',
                    'special_requirements' => 'max:255',
                ]
            );

            $data = Member::findOrFail($id);
            $data->update($request->all());
            $data->save();

            return redirect()->route('members.index')->with('toast_success', 'Update data succeed!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendemail(Request $request)
    {
        // dd($request->all());
        $member = Member::findOrFail($request->id);
        switch ($request->type) {
            case 'remind':
                // send email
                Mail::to($member->email)->send(new RemindMail($member));
                break;

            default:
                Mail::to($member->email)->send(new InfoMail($member));
                break;
        }

        return true;
    }

    public function export()
    {
        return Excel::download(new MemberExport, 'registrant.xlsx');
    }

    public function jsontable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');
        $order = $request->get('order');

        // dd('draw: ' . $draw . ' | start: ' . $start . ' | length: ' . $length . ' | search: ' . $search . ' | order: ' . $order);

        // filter
        $country = $request->get('country');
        $organization = $request->get('organization');
        $registrant_group = $request->get('registrant_group');
        $registration_type = $request->get('registration_type');
        $payment_method = $request->get('payment_method');
        $payment_status = $request->get('payment_status');

        $columnorder = array(
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
            'action',
        );

        if (empty($order)) {
            $sort = 'id';
            $dir = 'asc';
        } else {
            $sort = $columnorder[$order[0]['column']];
            $dir = $order[0]['dir'];
        }
        // query
        $keyword = trim($search['value']);

        $data = Member::when($country, function ($query, $country) {
            return $query->where('country', $country);
        })
            ->when($organization, function ($query, $organization) {
                return $query->where('organization', $organization);
            })
            ->when($registrant_group, function ($query, $registrant_group) {
                return $query->where('registrant_group', $registrant_group);
            })
            ->when($registration_type, function ($query, $registration_type) {
                return $query->where('registration_type', $registration_type);
            })
            ->when($payment_method, function ($query, $payment_method) {
                return $query->where('payment_method', $payment_method);
            })
            ->when($payment_status, function ($query, $payment_status) {
                return $query->where('payment_status', $payment_status);
            })
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->orWhere('reference', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email_secondary', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('middle_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('address', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('city', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('city_code', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('country', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('phone_mobile', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('organization', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('profession_title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('registrant_group', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('registration_type', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_id', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('dietary_restrictions', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('special_requirements', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('total', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($sort, $dir)
            ->get();
        $recordsTotal = Member::select('id')
            ->when($country, function ($query, $country) {
                return $query->where('country', $country);
            })
            ->when($organization, function ($query, $organization) {
                return $query->where('organization', $organization);
            })
            ->when($registrant_group, function ($query, $registrant_group) {
                return $query->where('registrant_group', $registrant_group);
            })
            ->when($registration_type, function ($query, $registration_type) {
                return $query->where('registration_type', $registration_type);
            })
            ->when($payment_method, function ($query, $payment_method) {
                return $query->where('payment_method', $payment_method);
            })
            ->when($payment_status, function ($query, $payment_status) {
                return $query->where('payment_status', $payment_status);
            })
            ->count();
        $recordsFiltered = Member::select('id')
            ->when($country, function ($query, $country) {
                return $query->where('country', $country);
            })
            ->when($organization, function ($query, $organization) {
                return $query->where('organization', $organization);
            })
            ->when($registrant_group, function ($query, $registrant_group) {
                return $query->where('registrant_group', $registrant_group);
            })
            ->when($registration_type, function ($query, $registration_type) {
                return $query->where('registration_type', $registration_type);
            })
            ->when($payment_method, function ($query, $payment_method) {
                return $query->where('payment_method', $payment_method);
            })
            ->when($payment_status, function ($query, $payment_status) {
                return $query->where('payment_status', $payment_status);
            })
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->orWhere('reference', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email_secondary', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('middle_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('address', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('city', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('city_code', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('country', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('phone_mobile', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('organization', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('profession_title', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('registrant_group', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('registration_type', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_id', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('tax_phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('dietary_restrictions', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('special_requirements', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('total', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->count();
        $resp = DataTables::of($data)
            ->editColumn('created_at', function ($data) {
                return '<small>' . date('d/m/Y', strtotime($data->created_at)) . '<br><i class="far fa-clock"></i> ' . date('h:i A', strtotime($data->created_at)) . '</small>';
            })
            ->addColumn('name', function ($data) {
                return $data->title . ' ' . $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name;
            })
            ->addColumn('registration', function ($data) {
                return $data->registration_type . ', ' . $data->registrant_group;
            })
            ->addColumn('payment_method', function ($data) {
                $method = '';
                $color = 'info';
                switch ($data->payment_method) {
                    case 1:
                        $method = 'Credit Card';
                        break;
                    case 2:
                        $method = 'Bank Transfer';
                        break;
                }
                return '<span class="badge badge-' . $color . '">' . $method . '</span>';
            })
            ->addColumn('payment_status', function ($data) {
                $status = '';
                $color = '';
                switch ($data->payment_status) {
                    case 1:
                        $status = 'Pending';
                        $color = 'warning';
                        break;
                    case 2:
                        $status = 'Paid';
                        $color = 'success';
                        break;
                    case 3:
                        $status = 'Cancelled';
                        $color = 'danger';
                        break;
                    default:
                        $status = '';
                        $color = 'info';
                        break;
                }

                return '<span class="badge badge-' . $color . '">' . $status . '</span>';
            })
            ->addColumn('action', function ($data) {
                $id = $data->id;
                $payment_method = $data->payment_method;
                $payment_status = $data->payment_status;
                return view('member._action', compact('id', 'payment_method', 'payment_status'));
            })
            ->setTotalRecords($recordsTotal)
            ->setFilteredRecords($recordsFiltered)
            ->escapeColumns([])
            ->skipPaging()
            ->addIndexColumn()
            ->make(true);
        return $resp;
    }

    public function getassociations(Request $request)
    {
        $country = $request->country;
        $registrantTypeId = $request->registrantTypeId;

        $countryId = Country::where('nicename', $country)->first()->id;
        $data = Association::where(['countryId' => $countryId, 'registrantTypeId' => $registrantTypeId])->get();
        return $data;
    }
}
