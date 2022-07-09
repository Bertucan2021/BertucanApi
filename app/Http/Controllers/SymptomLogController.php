<?php

namespace App\Http\Controllers;

use App\Models\SymptomLog;
use App\Http\Requests\StoreSymptomLogRequest;
use App\Http\Requests\UpdateSymptomLogRequest;
use Exception; 
use Symfony\Component\HttpFoundation\Response;
use App\Models\SymptomType; 
use Illuminate\Database\Eloquent\ModelNotFoundException; 

class SymptomLogController extends Controller
{
    private $modelName="Symptom log";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $symptomLogs = SymptomLog::where('status', '!=', 'deleted')
                ->orWhereNull('status')->get()
                ->each(function ($item, $key) {
                    $item->symptomType;
                });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $symptomLogs,
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
     * @param  \App\Http\Requests\StoreSymptomLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSymptomLogRequest $request)
    {
        try {
            $input = $request->all(); 
            $fetchedSymptomType = SymptomType::where('id',$request->id)->first();
            if (!$fetchedSymptomType) {
                return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_CREATED, "Symptom type does not exist.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                    Response::HTTP_NOT_FOUND
                );
            }
            $symptomLog= new SymptomLog($input);
            $symptomLog->symptom_type_id=$fetchedSymptomType->id;
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
     * @param  \App\Models\SymptomLog  $symptomLog
     * @return \Illuminate\Http\Response
     */
    public function show(SymptomLog $symptomLog)
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
