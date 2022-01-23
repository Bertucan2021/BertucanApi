<?php

namespace App\Http\Controllers;

use App\Models\AdDetail;
use App\Http\Requests\StoreAdDetailRequest;
use App\Http\Requests\UpdateAdDetailRequest;

class AdDetailController extends Controller
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
     * @param  \App\Http\Requests\StoreAdDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdDetail  $adDetail
     * @return \Illuminate\Http\Response
     */
    public function show(AdDetail $adDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdDetail  $adDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(AdDetail $adDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdDetailRequest  $request
     * @param  \App\Models\AdDetail  $adDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdDetailRequest $request, AdDetail $adDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdDetail  $adDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdDetail $adDetail)
    {
        //
    }
}
