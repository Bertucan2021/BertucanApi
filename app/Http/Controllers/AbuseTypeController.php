<?php

namespace App\Http\Controllers;

use App\Models\AbuseType;
use App\Http\Requests\StoreAbuseTypeRequest;
use App\Http\Requests\UpdateAbuseTypeRequest;
use Symfony\Component\HttpFoundation\Response;
use Exception;
class AbuseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $abuseTypes = AbuseType::where('status', 'active')->get()->each( function ($item, $key){
                $item->address;          
            });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $abuseTypes,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Active Abuse Types are fetched sucessfully.",
                        ""
                    ),
                    Response::HTTP_OK
                );
        } catch (Exception $ex) {
            return response()
                ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
        }
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
     * @param  \App\Http\Requests\StoreAbuseTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbuseTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AbuseType  $abuseType
     * @return \Illuminate\Http\Response
     */
    public function show(AbuseType $abuseType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AbuseType  $abuseType
     * @return \Illuminate\Http\Response
     */
    public function edit(AbuseType $abuseType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbuseTypeRequest  $request
     * @param  \App\Models\AbuseType  $abuseType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbuseTypeRequest $request, AbuseType $abuseType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AbuseType  $abuseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbuseType $abuseType)
    {
        //
    }
}
