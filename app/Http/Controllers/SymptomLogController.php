<?php

namespace App\Http\Controllers;

use App\Models\SymptomLog;
use App\Http\Requests\StoreSymptomLogRequest;
use App\Http\Requests\UpdateSymptomLogRequest;

class SymptomLogController extends Controller
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
     * @param  \App\Http\Requests\StoreSymptomLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSymptomLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SymptomLog  $symptomLog
     * @return \Illuminate\Http\Response
     */
    public function show(SymptomLog $symptomLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SymptomLog  $symptomLog
     * @return \Illuminate\Http\Response
     */
    public function edit(SymptomLog $symptomLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSymptomLogRequest  $request
     * @param  \App\Models\SymptomLog  $symptomLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSymptomLogRequest $request, SymptomLog $symptomLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SymptomLog  $symptomLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(SymptomLog $symptomLog)
    {
        //
    }
}
