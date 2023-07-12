<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        $customers = Customer::select('customer_name', 'join_date', 'expire_date', 'latitude', 'longitude', 'updated_at')->get();
        $totalCustomer = count($customers);
        // dd($customers);
        return view('home', [
            'customers' => $customers,
            'totalCustomers' => $totalCustomer
        ]);
    }
}
