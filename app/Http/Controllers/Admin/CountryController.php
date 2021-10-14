<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::simplePaginate(12);

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryRequest $request)
    {
        Country::create([
            'name'  =>  $request->name,
            'code'  =>  $request->code,
        ]);

        return redirect()->route('countries.index')->with('success', 'Country created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update([
            'name'  =>  $request->name,
            'code'  =>  $request->code,
        ]);

        return redirect()->route('countries.index')->with('success', 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->route('countries.index')->with('success', 'Country deleted successfully');
    }
}
