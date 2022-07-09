<?php

namespace App\Http\Controllers;

use App\Models\UserSymptomLog;
use App\Http\Requests\StoreUserSymptomLogRequest;
use App\Http\Requests\UpdateUserSymptomLogRequest;
use Exception; 
use Symfony\Component\HttpFoundation\Response;
use App\Models\SymptomLog; 
use App\Models\User; 
use Illuminate\Database\Eloquent\ModelNotFoundException; 

class UserSymptomLogController extends Controller
{
    private $modelName="User symptom log";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $userSymptomLogs = UserSymptomLog::where('status', '!=', 'deleted')
                ->orWhereNull('status')->get()
                ->each(function ($item, $key) {
                    $item->symptomLog;
                    $item->user_id;
                });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $userSymptomLogs,
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
     * @param  \App\Http\Requests\StoreUserSymptomLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserSymptomLogRequest $request)
    {
        try {
            $input = $request->all();
            $user = $request->user();
            $fetchedUser = User::where('id',$user->id)->first();
            if (!$fetchedUser) {
                return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_CREATED, "User does not exist.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                    Response::HTTP_NOT_FOUND
                );
            }
            $symptomLog = SymptomLog::where('id',$request->symptom_log_id)->first();
            if (!$symptomLog) {
                return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_CREATED, "symptomLogdoes not exist.", "$this->modelName must exist for $this->modelName to be recorded", ""),
                    Response::HTTP_NOT_FOUND
                );
            }
            $userSymptomLog= new UserSymptomLog($input);
            $userSymptomLog->user_id=$user->id;
            $userSymptomLog->symptom_log_id=$symptomLog->id;
            $userSymptomLog->status="active";
            if ($userSymptomLog->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject($userSymptomLog, true, Response::HTTP_CREATED, "$this->modelName is created.", "A $this->modelName is created.", ""),
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
     * @param  \App\Models\UserSymptomLog  $userSymptomLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserSymptomLog $userSymptomLog)
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
