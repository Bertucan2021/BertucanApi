<?php

namespace App\Http\Controllers;

use App\Models\AdType;
use App\Http\Requests\StoreAdTypeRequest;
use App\Http\Requests\UpdateAdTypeRequest;

class AdTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdType  $adType
     * @return \Illuminate\Http\Response
     */
    public function show(AdType $adType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdType  $adType
     * @return \Illuminate\Http\Response
     */
    public function edit(AdType $adType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdTypeRequest  $request
     * @param  \App\Models\AdType  $adType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdTypeRequest $request, AdType $adType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdType  $adType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdType $adType)
    {
        //
    }
}
