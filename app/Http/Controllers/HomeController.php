<?php

namespace App\Http\Controllers;

use App\Models\Member;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => '', 'name' => 'Dashboard Summary'],
        ];
        $count_member_all = Member::count();
        $count_member_paid = Member::where('payment_status', 2)->count();
        $count_member_pending = Member::where('payment_status', 1)->count();
        $paid_per_country = DB::table('members')->select('country', DB::raw('COUNT(country) as countCountry'))->where('payment_status', 2)->groupBy('country')->get();
        $paid_per_organization = DB::table('members')->select('organization', DB::raw('COUNT(organization) as countOrganization'))->where('payment_status', 2)->groupBy('organization')->get();
        // dd($paid_per_organization);
        return view('home', [
            'title' => 'Dashboard',
            'breadcrumbs' => $breadcrumbs,
            'count_member_all' => $count_member_all,
            'count_member_paid' => $count_member_paid,
            'count_member_pending' => $count_member_pending,
            'paid_per_country' => $paid_per_country,
            'paid_per_organization' => $paid_per_organization,
        ]);
    }
}
