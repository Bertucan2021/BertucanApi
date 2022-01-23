<?php

namespace App\Http\Controllers;

use App\Models\CycleHistory;
use App\Http\Requests\StoreCycleHistoryRequest;
use App\Http\Requests\UpdateCycleHistoryRequest;

class CycleHistoryController extends Controller
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
     * @param  \App\Http\Requests\StoreCycleHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCycleHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CycleHistory  $cycleHistory
     * @return \Illuminate\Http\Response
     */
    public function show(CycleHistory $cycleHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CycleHistory  $cycleHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(CycleHistory $cycleHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCycleHistoryRequest  $request
     * @param  \App\Models\CycleHistory  $cycleHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCycleHistoryRequest $request, CycleHistory $cycleHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CycleHistory  $cycleHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CycleHistory $cycleHistory)
    {
        //
    }
}
