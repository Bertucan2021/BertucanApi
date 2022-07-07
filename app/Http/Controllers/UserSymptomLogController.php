<?php

namespace App\Http\Controllers;

use App\Models\UserSymptomLog;
use App\Http\Requests\StoreUserSymptomLogRequest;
use App\Http\Requests\UpdateUserSymptomLogRequest;

class UserSymptomLogController extends Controller
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
     * @param  \App\Http\Requests\StoreUserSymptomLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserSymptomLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSymptomLog  $userSymptomLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserSymptomLog $userSymptomLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSymptomLog  $userSymptomLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSymptomLog $userSymptomLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserSymptomLogRequest  $request
     * @param  \App\Models\UserSymptomLog  $userSymptomLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserSymptomLogRequest $request, UserSymptomLog $userSymptomLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSymptomLog  $userSymptomLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSymptomLog $userSymptomLog)
    {
        //
    }
}
