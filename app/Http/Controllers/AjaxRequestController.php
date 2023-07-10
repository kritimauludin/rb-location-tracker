<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AjaxRequestController extends Controller
{
    public function getNewCode(Request $request)
    {
        $customers = Customer::all();
        $last = count($customers) + 1;
        $idCard = 'C' . $request->postal_code . $last;

        return json_encode($idCard);
    }
}
