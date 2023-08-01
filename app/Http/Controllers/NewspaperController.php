<?php

namespace App\Http\Controllers;

use App\Models\Newspaper;
use Illuminate\Http\Request;

class NewspaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newspapers = Newspaper::all();
        return view('newspaper.newspapers', [
            'newspapers' => $newspapers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('newspaper.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validNewspaper = $request->validate([
            'newspaper_code' => 'required',
            'edition'        => 'required',
            'description'    => 'required'
        ]);

        // dd($validNewspaper);
        Newspaper::create($validNewspaper);

        return redirect('/newspaper')->with('success', 'Data Koran berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Newspaper $newspaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Newspaper $newspaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Newspaper $newspaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newspaper $newspaper)
    {
        //
    }
}
