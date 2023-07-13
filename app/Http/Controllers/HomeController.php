<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
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

        //count
        $totalAdmin = count($admins);
        $totalCourier = count($couriers);
        $totalCustomer = count($customers);

        return view('home', [
            'customers' => $customers,
            'totalAdmin' => $totalAdmin,
            'totalCourier' => $totalCourier,
            'totalCustomers' => $totalCustomer
        ]);
    }

    public function myProfile(){
        return view('my-profile');
    }
}
