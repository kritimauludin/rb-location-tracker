<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Distribution;
use App\Models\Newspaper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxRequestController extends Controller
{
    public function getNewCode(Request $request)
    {
        if($request->type == 'admin'){
            //code for admin
            $admin = User::where('role_id', '2')->get();
            $last = count($admin) + 1;
            $code = 'A' . $request->postal_code . $last;
        } else if($request->type == 'courier'){
            //code for courier
            $courier = User::where('role_id', '3')->get();
            $last = count($courier) + 1;
            $code = 'CR' . $request->postal_code . $last;
        } else if($request->type == 'customer'){
            //code for customer
            $customers = Customer::all();
            $last = count($customers) + 1;
            $code = 'C' . $request->postal_code . $last;
        } else if($request->type == 'distribution'){
            //code for customer
            $distributionsToday = Distribution::whereDate('created_at', Carbon::today())->get();
            $last = count($distributionsToday) + 1;
            $code = 'DS' . date('Ymd') . $last;
        } elseif ($request->type == 'newspaper'){
            $newspapers = Newspaper::all();
            $last = count($newspapers) + 1;
            $code = 'NS'. date('Ymd') . $last;
        }
        else {
            $code = 404;
        }

        return json_encode($code);
    }

    public function addCourierHandle(Request $request) {
        Customer::where('customer_code', $request->customerCode)->update(['courier_code' => $request->courierCode, 'updated_at' => date("Y-m-d H:i:s")]);
        return true;
    }

    public function unhandleCourier(Request $request) {
        Customer::where('customer_code', $request->customerCode)->update(['courier_code' => null, 'updated_at' => date("Y-m-d H:i:s")]);
        return redirect()->back();
    }
}
