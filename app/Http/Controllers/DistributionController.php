<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistributionRequest;
use App\Http\Requests\UpdateDistributionRequest;
use App\Models\Customer;
use App\Models\Distribution;
use App\Models\User;
use App\Models\UserDistribution;

class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $distributions = Distribution::with(['courier'])
                            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
                            ->get();
        // dd($distributions);
        return view('distribution.distributions', [
            'distributions' => $distributions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $couriers = User::where('role_id', 3)->get();
        $customers = Customer::all();

        return view('distribution.create', [
            'couriers' => $couriers,
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDistributionRequest $request)
    {
        $validDistribution = $request->validate([
            'distribution_code' => 'required',
            'admin_code'        => 'required',
            'courier_code'      => 'required',
            'total_newspaper'   => 'required'
        ]);

        if($validDistribution){
            for($i=0; $i <count($request->customer_name); $i++){
                $validUserDistribution[$i] = [
                    'distribution_code' => $validDistribution['distribution_code'],
                    'customer_code' => $request->customer_code[$i],
                    'total' => $request->total[$i],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
            }
            Distribution::create($validDistribution);
            UserDistribution::insert($validUserDistribution);
        }

        return redirect('/distribution')->with('success', 'Alokasi distribusi kurir berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Distribution $distribution){

        $distribution = Distribution::with(['courier', 'user_distribution'])
                            ->where('distribution_code', $distribution->distribution_code)
                            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
                            ->get();

                            // dd($distribution);
        return view('distribution.show', [
            'distribution' => $distribution[0],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distribution $distribution)
    {
        $couriers = User::where('role_id', 3)->get();
        $customers = Customer::all();

        return view('distribution.update', [
            'distribution' => $distribution,
            'couriers'  => $couriers,
            'customers' => $customers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistributionRequest $request, Distribution $distribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distribution $distribution)
    {
        Distribution::where('distribution_code', $distribution->distribution_code)->delete();
        UserDistribution::where('distribution_code', $distribution->distribution_code)->delete();
        return redirect('/distribution')->with('success', 'Alokasi disribusi kode '.$distribution->distribution_code.' berhasil dihapus!');
    }
}
