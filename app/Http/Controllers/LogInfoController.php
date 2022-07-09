<?php

namespace App\Http\Controllers;

use App\Models\LogInfo;
use App\Http\Requests\StoreLogInfoRequest;
use App\Http\Requests\UpdateLogInfoRequest; 
use Exception; 
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; 
use Illuminate\Database\Eloquent\ModelNotFoundException; 


class LogInfoController extends Controller
{
    private $modelName="Log info";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $logInfos = LogInfo::where('status', '!=', 'deleted')
                ->orWhereNull('status')->get()
                ->each(function ($item, $key) {
                    $item->user;
                });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $logInfos,
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
     * @param  \App\Http\Requests\StoreLogInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLogInfoRequest $request)
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
            $logInfo= new LogInfo($input);
            $logInfo->user_id=$user->id;
            $logInfo->status="active";
            if ($logInfo->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject($logInfo, true, Response::HTTP_CREATED, "$this->modelName is created.", "A $this->modelName is created.", ""),
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
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $allLogInfo = LogInfo::where('id', $id)->first();
            $allLogInfo->user; 
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allLogInfo,
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLogInfoRequest  $request
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogInfoRequest $request, LogInfo $logInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogInfo  $logInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogInfo $logInfo)
    {
        //
    }
}
