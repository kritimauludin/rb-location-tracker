<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Distribution;
use App\Models\User;
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
        $distributions = Distribution::with(['courier'])
                            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
                            ->whereDate('created_at', Carbon::today())
                            ->orderBy('updated_at', 'DESC')
                            ->get(50);

        //count
        $totalAdmin = count($admins);
        $totalCourier = count($couriers);
        $totalCustomer = count($customers);

        return view('home', [
            'customers' => $customers,
            'totalAdmin' => $totalAdmin,
            'totalCourier' => $totalCourier,
            'totalCustomers' => $totalCustomer,
            'distributions' => $distributions
        ]);
    }

    public function myProfile(){
        return view('my-profile');
    }
}
