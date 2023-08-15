<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Newspaper;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        return view('customer.customers', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newspapers = Newspaper::all();

        return view('customer.create', [
            'newspapers' => $newspapers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $validCustomer = $request->validate([
            'customer_code'     => 'required',
            'newspaper_code'    => 'required',
            'customer_name'     => 'required',
            'email'             => 'required|email:dns|unique:customers',
            'phone_number'      => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
            'join_date'         => 'required',
            'expire_date'       => 'required',
            'amount'            => 'required',
            'address'           => 'required',
            'latitude'          => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude'         => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
        ]);

        Customer::create($validCustomer);

        return redirect('/customer')->with('success', 'Pelanggan berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.update',[
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        // dd($request);
        $validCustomer = $request->validate([
            'customer_code' => 'required',
            'customer_name' => 'required',
            'email' => 'required|email:dns',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
            'join_date' => 'required',
            'expire_date' => 'required',
            'address' => 'required',
            'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
        ]);

        Customer::where('customer_code', $customer->customer_code)->update($validCustomer);

        return redirect('/customer')->with('success', 'Data pelanggan '.$customer->customer_code.' berhasil diubah !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        Customer::where('customer_code', $customer->customer_code)->delete();
        return redirect('/customer')->with('success', 'Pelanggan kode '.$customer->customer_code.' berhasil dihapus!');
    }

    /**
     * Print the specified resource from storage.
     */
    public function generateReport()
    {
        $customers = Customer::all();
        // dd($customers);
        $pdf = Pdf::loadView('customer.generate-report', [
            'customers' => $customers->toArray()
        ]);
        return $pdf->stream('Customer'.date('d-m-y').'pdf');
    }
}
