<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;
use Symfony\Component\HttpFoundation\Response;
class AddressController extends Controller
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
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    { 
            try {
                 
                $address = Address::create($request->all());
                if ($address->save()) {
                    return    response($address)
                    ->json(
                        HelperClass::responeObject(
                            $address,
                            true,
                            Response::HTTP_OK,
                            'Successfully fetched.',
                            "Article are fetched sucessfully.",
                            ""
                        ),
                        Response::HTTP_OK
                    );
                } else {
                    return ( response()
                    ->json(
                        HelperClass::responeObject(
                            $address,
                            true,
                            Response::HTTP_OK,
                            'Not Successfully fetched.',
                            "no are fetched sucessfully.",
                            ""
                        ),
                        Response::HTTP_OK
                    );
                }
            } catch (ModelNotFoundException $ex) { // User not found
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
            } catch (Exception $ex) { // Anything that went wrong
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal error occured.', "", $ex->getMessage()),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
            }
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddressRequest  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
