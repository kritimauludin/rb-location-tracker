<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Distribution;
use App\Models\User;
use App\Models\UserDistribution;
use Carbon\Carbon;
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
        $admins = User::where('role_id', '2')->get();
        $couriers = User::where('role_id', '3')->get();
        $customers = Customer::select('customer_name', 'join_date', 'expire_date', 'latitude', 'longitude', 'updated_at')->get();
        $recentDistributions = UserDistribution::whereDate('created_at', Carbon::today())->with(['customer', 'distribution'])->get();
        // dd($recentDistributions);

        //count
        $totalAdmin = count($admins);
        $totalCourier = count($couriers);
        $totalCustomer = count($customers);
        $totalDistributionToday = count($recentDistributions);

        return view('home', [
            'customers' => $customers,
            'totalAdmin' => $totalAdmin,
            'totalCourier' => $totalCourier,
            'totalCustomers' => $totalCustomer,
            'totalDistributionToday' => $totalDistributionToday,
            'recentDistributions' => $recentDistributions
        ]);
    }

    public function myProfile(){
        return view('my-profile');
    }
}
