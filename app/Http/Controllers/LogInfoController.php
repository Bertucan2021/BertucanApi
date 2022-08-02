<?php

namespace App\Http\Controllers;

use App\Models\LogInfo;
use App\Http\Requests\StoreLogInfoRequest;
use App\Http\Requests\UpdateLogInfoRequest;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class LogInfoController extends Controller
{
    private $modelName = "Log info";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user_id = Auth::user()->id;
            $logInfos = LogInfo::where('status', '!=', 'deleted')
                ->where('user_id', '=', $user_id)
                ->get()
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
     * @param \App\Http\Requests\StoreLogInfoRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(StoreLogInfoRequest $request)
    {

        try {
            $listInput = $request->input('log_infos');
            $user = $request->user();
            if (!$user) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, true, Response::HTTP_CREATED, "$this->modelName does not exist.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                        Response::HTTP_NOT_FOUND
                    );
            }

            foreach ($listInput as $inLogInfo) {
                $logInfo = new LogInfo();

                $logInfo->startDate = $inLogInfo['startDate'];
                $logInfo->endDate = $inLogInfo['endDate'];
                $logInfo->pregnancyDate = $inLogInfo['pregnancyDate'];
                $logInfo->phaseChange = $inLogInfo['phaseChange'];
                $logInfo->status = 'active';
                $logInfo->user_id = $user->id;

                $logInfo->save();
            }
            return response()
                ->json(
                    HelperClass::responeObject($listInput, true, Response::HTTP_CREATED, "Log info created.", "Log info  created.", ""),
                    Response::HTTP_CREATED
                );
        } catch
        (ModelNotFoundException $ex) { // User not found
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
     * @param \App\Models\LogInfo $logInfo
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user_id = Auth::user()->id;
            $allLogInfo = LogInfo::where('id', $id)
                ->where('user_id', '=', $user_id)
                ->first();
            if ($allLogInfo) {
                $allLogInfo->user;
            };
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
     * @param \App\Http\Requests\UpdateLogInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogInfoRequest $request)
    {
        try {
            $input = $request->all();
            $fetchedUser = Auth::user();
            if (!$fetchedUser) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, true, Response::HTTP_CREATED, "$this->modelName does not exist.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                        Response::HTTP_NOT_FOUND
                    );
            }

            $logInfo = LogInfo::where('id', $request->input('id'))
                ->where('user_id', '=', $fetchedUser->id)
                ->first();
            if ($logInfo == null || $logInfo->user_id != $fetchedUser->id) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, true, Response::HTTP_CREATED, "$this->modelName does not belong to this user.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                        Response::HTTP_NOT_FOUND
                    );
            }
            $logInfo->startDate = $request->input('startDate');
            $logInfo->endDate = $request->input('endDate');
            $logInfo->pregnancyDate = $request->input('pregnancyDate');
            $logInfo->phaseChange = $request->input('phaseChange');
            $logInfo->status = $request->input('status');
            $logInfo->user_id = $fetchedUser->id;
            if ($logInfo->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject($logInfo, true, Response::HTTP_CREATED, "$this->modelName is updated.", "A $this->modelName is updated.", ""),
                        Response::HTTP_CREATED
                    );
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "", "This $this->modelName couldnt be updated."),
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
     * Remove the specified resource from storage.
     *
     * @param \App\Models\LogInfo $logInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogInfo $logInfo)
    {
        //
    }
}
