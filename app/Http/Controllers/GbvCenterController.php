<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GbvCenter;
use App\Models\Address;
use App\Http\Requests\StoreGbvCenterRequest;
use App\Http\Requests\UpdateGbvCenterRequest;

class GbvCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allGbvCenter = GbvCenter::where('status', 'active')->get()->each(function ($item, $key) {
                $item->address;
            });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allGbvCenter,
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
     * @param \App\Http\Requests\StoreGbvCenterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGbvCenterRequest $request)
    {
        try {
            $input = $request->all();

            $fileExist = false;
            if ($request->hasFile('file') != null) {
                $fileExist = true;
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $finalName = date('His') . $fileName;
                $request->file('file')->storeAs('gbv/', $finalName, 'public');
            }
            $gbvCenter = new GbvCenter();
            if ($request->input('id')) {
                $gbvCenter = GbvCenter::where('id', $request->input('id'))->first();
                $gbvCenter->status = $request->input('status');
            } else {
                $gbvCenter->status = "active";
            }
            $gbvCenter->name = $input['name'];
            $gbvCenter->description = $input['description'];
            $gbvCenter->phone_number = $input['phone_number'];
            $gbvCenter->license = $input['license'];

            if ($fileExist) {
                $gbvCenter->logo = "gbv/" . $finalName;
            }
            if ($gbvCenter->save()) {
                $addressInput = json_decode($input['address']);

                $address = new Address();
                $address->country = $addressInput->country;
                $address->city = $addressInput->city;
                $address->type = $addressInput->type;
                $address->longitude = $addressInput->longitude;
                $address->latitude = $addressInput->latitude;
                $address->type = $addressInput->type;
                $address->status = 'active';

                $address->type = 'gbv';
                if (!$address->save()) {
                    return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, "GBV saved but Address couldn't be saved.", "", "GBV saved but Address couldn't be saved"),
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                }

                $gbvCenter->address_id = $address->id;
                $gbvCenter->save();

                return response()
                    ->json(
                        HelperClass::responeObject($gbvCenter, true, Response::HTTP_CREATED, 'GBV center created.', "A GBV center is created.", ""),
                        Response::HTTP_CREATED
                    );
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "", "This GBV center couldnt be saved."),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
            }
        } catch (Exception $ex) { // Anything that went wrong
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
     * @param \App\Models\GbvCenter $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $allGbvCenter = GbvCenter::where('id', $id)->first();
            $allGbvCenter->address;
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allGbvCenter,
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
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateGbvCenterRequest $request
     * @param \App\Models\GbvCenter $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGbvCenterRequest $request, GbvCenter $gBVCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\GbvCenter $gBVCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(GbvCenter $gBVCenter)
    {
        //
    }
}
