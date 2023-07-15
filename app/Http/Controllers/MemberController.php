<?php

namespace App\Http\Controllers;

use App\Mail\InfoMail;
use App\Mail\RemindMail;
use App\Models\Member;
use Illuminate\Http\Request;
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
            ['route' => '', 'name' => 'Member Management'],
        ];
        return view('member.main', [
            'title' => 'Member Management',
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Member::findOrFail($id);
        $data->update($request->all());
        $data->save();

        return true;
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
}
