<?php

namespace App\Http\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GBVCenter;
use App\Http\Requests\StoreGBVCenterRequest;
use App\Http\Requests\UpdateGBVCenterRequest;

class GBVCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allGBVCenter = GBVCenter::where('status', 'active')->get();
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allGBVCenter,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Active GBV centers are fetched sucessfully.",
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGBVCenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGBVCenterRequest $request)
    {
        try{
            $input = $request->all();
            $gbvCenter= new GBVCenter($input);
            $gbvCenter->status="active";
            if($gbvCenter->save()){
                return response()
                ->json(
                    HelperClass::responeObject($gbvCenter, true, Response::HTTP_CREATED, 'GBV center created.', "A GBV center is created.", ""),
                    Response::HTTP_CREATED
                );
            }else{
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This GBV center couldnt be saved."),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
           }catch (Exception $ex) { // Anything that went wrong
               return response()
                   ->json(
                       HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
                       Response::HTTP_UNPROCESSABLE_ENTITY
                   );
               }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GBVCenter  $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $allGBVCenter = GBVCenter::where('id', $id)->first();
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allGBVCenter,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Active GBV center is fetched sucessfully.",
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GBVCenter  $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(GBVCenter $gBVCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGBVCenterRequest  $request
     * @param  \App\Models\GBVCenter  $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGBVCenterRequest $request, GBVCenter $gBVCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GBVCenter  $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(GBVCenter $gBVCenter)
    {
        //
    }
}
