<?php

namespace App\Http\Controllers;

use App\Models\LogInfo;
use App\Http\Requests\StoreLogInfoRequest;
use App\Http\Requests\UpdateLogInfoRequest;

class LogInfoController extends Controller
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
     * @param  \App\Http\Requests\StoreLogInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLogInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function show(LogInfo $logInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(LogInfo $logInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLogInfoRequest  $request
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogInfoRequest $request, LogInfo $logInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogInfo $logInfo)
    {
        //
    }
}
