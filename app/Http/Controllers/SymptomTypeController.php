<?php

namespace App\Http\Controllers;

use App\Models\SymptomType;
use App\Http\Requests\StoreSymptomTypeRequest;
use App\Http\Requests\UpdateSymptomTypeRequest;
use Exception; 
use Symfony\Component\HttpFoundation\Response; 
use Illuminate\Database\Eloquent\ModelNotFoundException; 

class SymptomTypeController extends Controller
{
    private $modelName="Symptom type";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $symptomTypes = SymptomType::where('status', '!=', 'deleted')
                ->orWhereNull('status')->get();
            return response()
                ->json(
                    HelperClass::responeObject(
                        $symptomTypes,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "$this->modelName are fetched sucessfully.",
                        ""
                    ),
                    Response::HTTP_OK
                );
        } catch (ModelNotFoundException $ex) { // User not found
            return response()
                ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
        } catch (Exception $ex) { // Anything that went wrong
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
     * @param  \App\Http\Requests\StoreSymptomTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSymptomTypeRequest $request)
    {
        try {
            $input = $request->all();  
            $symptomLog= new SymptomType($input); 
            $symptomLog->status="active";
            if ($symptomLog->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject($symptomLog, true, Response::HTTP_CREATED, "$this->modelName is created.", "A $this->modelName is created.", ""),
                        Response::HTTP_CREATED
                    );
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This $this->modelName couldnt be saved."),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
            }
        } catch (ModelNotFoundException $ex) { // User not found
            return response()
                ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, "The $this->modelName doesnt exist.", "", $ex->getMessage()),
                    Response::HTTP_UNPROCESSABLE_ENTITY
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
