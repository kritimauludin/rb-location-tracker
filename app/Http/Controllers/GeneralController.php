<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function landingPage(){
        $customers = Customer::all();

        return view('landing-page',[
            'customers' => $customers
        ]);
    }
}
