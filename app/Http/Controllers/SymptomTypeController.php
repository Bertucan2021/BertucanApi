<?php

namespace App\Http\Controllers;

use App\Models\SymptomType;
use App\Http\Requests\StoreSymptomTypeRequest;
use App\Http\Requests\UpdateSymptomTypeRequest;

class SymptomTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreSymptomTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSymptomTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SymptomType  $symptomType
     * @return \Illuminate\Http\Response
     */
    public function show(SymptomType $symptomType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SymptomType  $symptomType
     * @return \Illuminate\Http\Response
     */
    public function edit(SymptomType $symptomType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSymptomTypeRequest  $request
     * @param  \App\Models\SymptomType  $symptomType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSymptomTypeRequest $request, SymptomType $symptomType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SymptomType  $symptomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SymptomType $symptomType)
    {
        //
    }
}
