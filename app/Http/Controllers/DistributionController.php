<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistributionRequest;
use App\Http\Requests\UpdateDistributionRequest;
use App\Models\Customer;
use App\Models\Distribution;
use App\Models\User;
use App\Models\UserDistribution;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function getDistributionCode(){
        $distributionsToday = Distribution::whereDate('created_at', Carbon::today())->get();
        $last = count($distributionsToday) + 1;
        $code = 'DS' . date('Ymd') . $last;

        return $code;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $distributions = Distribution::with(['courier'])
            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
            ->orderBy('created_at', 'DESC')
            ->get();

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
        $customers = Customer::where('courier_code', null)->get();

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

        if ($validDistribution) {
            for ($i = 0; $i < count($request->customer_name); $i++) {
                $validUserDistribution[$i] = [
                    'distribution_code' => $validDistribution['distribution_code'],
                    'customer_code' => $request->customer_code[$i],
                    'total' => $request->total[$i],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => null,
                ];
            }
            Distribution::create($validDistribution);
            UserDistribution::insert($validUserDistribution);
        }

        return redirect('/distribution')->with('success', 'Alokasi distribusi kurir berhasil ditambahkan !');
    }

    /**
     * Auto generate newly created resource in storage.
     */
    public function autoGenerateDistribution()
    {
        $today = date("Ymd");
        // dd(env('LAST_GENERATE_DISTRIBUTION'));
        if ($today != env('LAST_GENERATE_DISTRIBUTION')) {
            $path = base_path('.env');
            $couriers = User::where('role_id', 3)->with('customer_handle')->get();

            if (file_exists($path)) {
                //Try to read the current content of .env
                $current = file_get_contents($path);

                //Store the key
                $original = [];
                if (preg_match('/^LAST_GENERATE_DISTRIBUTION=(.+)$/m', $current, $original)) {

                //Overwrite with new key
                    $current = preg_replace('/^LAST_GENERATE_DISTRIBUTION=.+$/m', "LAST_GENERATE_DISTRIBUTION=$today", $current);

                } else {
                //Append the key to the end of file
                    $current .= PHP_EOL."LAST_GENERATE_DISTRIBUTION=$today";
                }
                file_put_contents($path, $current);
            }

            foreach($couriers as $courier) {
                $validDistribution = [
                    'distribution_code' => $this->getDistributionCode(),
                    'admin_code'        => auth()->user()->user_code,
                    'courier_code'      => $courier->user_code,
                    'total_newspaper'   => 0
                ];

                if ($validDistribution) {
                    for ($i = 0; $i < count($courier->customer_handle); $i++){
                        $validUserDistribution = [
                            'distribution_code' => $validDistribution['distribution_code'],
                            'customer_code' => $courier->customer_handle[$i]->customer_code,
                            'total' => $courier->customer_handle[$i]->amount,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => null,
                        ];
                        $validDistribution['total_newspaper']+=$courier->customer_handle[$i]->amount;

                        UserDistribution::create($validUserDistribution);
                    }
                    Distribution::create($validDistribution);
                }
            }
            return redirect('/distribution')->with('success', 'Alokasi distribusi kurir berhasil ditambahkan !');
        } else {
            return redirect('/distribution')->with('success', 'Auto generate disable, anda telah melakukannya hari ini !');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Distribution $distribution)
    {

        $distribution = Distribution::with(['courier', 'user_distribution'])
            ->where('distribution_code', $distribution->distribution_code)
            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
            ->get();

        return view('distribution.show', [
            'distribution' => $distribution[0],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distribution $distribution)
    {
        $distribution = Distribution::with(['courier', 'user_distribution'])
            ->where('distribution_code', $distribution->distribution_code)
            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
            ->get();
        $couriers = User::where('role_id', 3)->get();
        $customers = Customer::where('courier_code', null)->get();

        return view('distribution.update', [
            'distribution' => $distribution[0],
            'couriers'  => $couriers,
            'customers' => $customers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistributionRequest $request, Distribution $distribution)
    {
        $validDistribution = $request->validate([
            'courier_code'      => 'required',
            'total_newspaper'   => 'required'
        ]);

        if ($validDistribution) {
            foreach ($distribution->user_distribution as $userDistribution) {
                $newCustomer = $request->customer_code[$userDistribution->id];
                $newTotal = $request->total[$userDistribution->id];
                $validUserDistribution = [
                    'distribution_code' =>  $distribution->distribution_code,
                    'customer_code' => $newCustomer,
                    'total' => $newTotal,
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
                UserDistribution::where('id', $userDistribution->id)->update($validUserDistribution);
            }
        }

        Distribution::where('distribution_code', $distribution->distribution_code)->update($validDistribution);
        return redirect('/distribution')->with('success', 'Alokasi distribusi kurir berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distribution $distribution)
    {
        Distribution::where('distribution_code', $distribution->distribution_code)->delete();
        UserDistribution::where('distribution_code', $distribution->distribution_code)->delete();
        return redirect('/distribution')->with('success', 'Alokasi disribusi kode ' . $distribution->distribution_code . ' berhasil dihapus!');
    }

    /**
     * Display a listing of the resource with query where.
     */
    public function todayDistribution()
    {
        $todayDistribution = Distribution::with(['courier', 'user_distribution'])
            ->where('courier_code', Auth::user()->user_code)
            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
            ->whereDate('created_at', Carbon::today())
            ->get();
        return view('courier.distribution-today', [
            'todayDistribution' => $todayDistribution
        ]);
    }

    public function updateStatus(Request $request)
    {
        if ($request->status == 'process') {
            UserDistribution::where('id', $request->id)->update(['process_at' => date("Y-m-d H:i:s"), 'status' => 201]);
        } else if ($request->status == 'finish') {
            UserDistribution::where('id', $request->id)->update(
                [
                    'received_at' => date("Y-m-d H:i:s"),
                    'courier_last_stamp' => $request->locationStamp,
                    'status' => 200
                ]);
        } else {
            return 500;
        }

        return redirect()->back()->with('success', 'Status berhasil diupdate !');
    }

    public function reportDistribution(Request $request)
    {
        if (isset($request->type)) {
            $type = $request->type;
            $courierCode = auth()->user()->user_code;

            if ($type == 'daily') {
                $distributions = UserDistribution::with(['customer', 'distribution' => function ($q) use ($courierCode) {
                    $q->where('courier_code', $courierCode);
                }])
                    ->whereDate('created_at', Carbon::today())
                    ->get();

                $pdf = Pdf::loadView('courier.pdf-template', [
                    'distributions' => $distributions->toArray()
                ]);
                return $pdf->stream('Report Distribution daily - ' . date('d-m-y') . '.pdf');
            } elseif ($type == 'weekly') {
                $thisWeek = Carbon::now()->subDays(7);
                $distributions = UserDistribution::with(['customer', 'distribution' => function ($q) use ($courierCode) {
                    $q->where('courier_code', $courierCode);
                }])
                    ->whereDate('created_at', '>=', $thisWeek)
                    ->get();

                $pdf = Pdf::loadView('courier.pdf-template', [
                    'distributions' => $distributions->toArray()
                ]);
                return $pdf->stream('Report Distribution weekly.pdf');
            } elseif ($type == 'monthly') {
                $distributions = UserDistribution::with(['customer', 'distribution' => function ($q) use ($courierCode) {
                    $q->where('courier_code', $courierCode);
                }])
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->get();

                $pdf = Pdf::loadView('courier.pdf-template', [
                    'distributions' => $distributions->toArray()
                ]);
                return $pdf->stream('Report Distribution monthly - ' . date('m-y') . '.pdf');
            } else {
                return abort(404);
            }
        } else {
            return view('courier.report-distribution');
        }
    }

    public function print(Request $request)
    {
        $distribution = Distribution::with(['courier', 'user_distribution'])
            ->where('distribution_code', $request->code)
            ->select('distribution_code', 'created_at', 'courier_code', 'total_newspaper')
            ->get();

        // dd($distribution);
        $pdf = Pdf::loadView('distribution.print', [
            'title' => 'Print ' . $request->code,
            'distribution' => $distribution[0],
        ]);

        return $pdf->stream('Alokasi ' . $request->code . '.pdf');
    }
}
