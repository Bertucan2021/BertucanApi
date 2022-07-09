<?php

namespace App\Http\Controllers;

use App\Models\CycleHistory;
use App\Http\Requests\StoreCycleHistoryRequest;
use App\Http\Requests\UpdateCycleHistoryRequest;
use Exception; 
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; 
use Illuminate\Database\Eloquent\ModelNotFoundException; 


class CycleHistoryController extends Controller
{
    private $modelName="Cycle history";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $cycleHistories = CycleHistory::where('status', '!=', 'deleted')
                ->orWhereNull('status')->get()
                ->each(function ($item, $key) {
                    $item->user;
                });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $cycleHistories,
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
     * @param  \App\Http\Requests\StoreCycleHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCycleHistoryRequest $request)
    {
        try {
            $input = $request->all();
            $user = $request->user();
            $fetchedUser = User::where('id',$user->id)->first();
            if (!$fetchedUser) {
                return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_CREATED, "$this->modelName does not exist.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                    Response::HTTP_NOT_FOUND
                );
            }
            $cycleHistory= new CycleHistory($input);
            $cycleHistory->user_id=$user->id;
            $cycleHistory->status="active";
            if ($cycleHistory->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject($cycleHistory, true, Response::HTTP_CREATED, "$this->modelName is created.", "A $this->modelName is created.", ""),
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
     * @param  \App\Models\CycleHistory  $cycleHistory
     * @return \Illuminate\Http\Response
     */
    public function show(CycleHistory $cycleHistoryRequest)
    {
        try {
            $allCycleHistories = CycleHistory::where('id', $cycleHistoryRequest)->first();
            $allCycleHistories->user; 
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allCycleHistories,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "$this->modelName is fetched sucessfully.",
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
     * @param  \App\Models\CycleHistory  $cycleHistory
     * @return \Illuminate\Http\Response
     */ 

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
    public function destroy(CycleHistory $cycleHistoryRequest)
    {
        try {
            $user = $cycleHistoryRequest->user();
            $cycleHistoryValue = $cycleHistoryRequest->all();
            $cycleHistory= CycleHistory::where('id',$cycleHistoryRequest->id)->first();
            if (!$cycleHistory) {
                response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_NOT_FOUND, "Resource Not Found", '', "$this->modelName by this id doesnt exist."),
                        Response::HTTP_NOT_FOUND
                    );
            }
            $cycleHistory->status = 'deleted';
            $cycleHistory->save();
            return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_OK, 'Successfully deleted.', "$this->modelName is deleted sucessfully.", ""),
                    Response::HTTP_OK
                );
        } catch (ModelNotFoundException $ex) {
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
}