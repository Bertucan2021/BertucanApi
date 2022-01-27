<?php

namespace App\Http\Controllers;
 
use Exception;
use Illuminate\Http\Request;  
use Symfony\Component\HttpFoundation\Response; 
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\Address;
use App\Models\Membership; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreUserRequest;
class UserController extends Controller
{ 
    public function index()
    {
        try {
            $user = User::where('status', '!=', 'deleted')
                ->orWhereNull('log_status')->get()
                ->each(function ($item, $key) {
                    $item->address;
                    $item->membership;
                    $item->remember_token = "";
                });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $user,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Users are fetched sucessfully.",
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
     
    public function login(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [ 
                'email' => ['required'],
                'password' => ['required']
            ]);
            if ($validatedData->fails()) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_BAD_REQUEST, "Validation failed check JSON request", "", $validatedData->errors()),
                        Response::HTTP_BAD_REQUEST
                    );
            }
            $user = User::where('email', $request->email)->where('status','!=','blocked')->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Bertucan access token', [$user->type])->accessToken;
                    $user['remember_token'] = $token;
                    if ($user->save()) {
                        $user->address; 
                        return response()
                    ->json(
                        HelperClass::responeObject($user, true, Response::HTTP_OK,'User found',"User is succesfully loged in.",""),
                        Response::HTTP_OK
                    );
                    }else{
                        return response()
                        ->json(
                            HelperClass::responeObject($user, true, Response::HTTP_INTERNAL_SERVER_ERROR,'Internal Error',"","An error occured while trying to log in."),
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }                    
                } else {
                    return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'Password issue.',"The password doesnt match the email.",""),
                        Response::HTTP_CONFLICT
                    );
                }
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_NOT_FOUND,'User doesnt exist.',"The is no registered user by this email.",""),
                        Response::HTTP_NOT_FOUND
                    );
            }
        
        }catch (ModelNotFoundException $ex) { // User not found
                return response()
                    ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
        } catch (Exception $ex) { // Anything that went wrong
            return response()
                ->json(
                    HelperClass::responeObject(null, false, RESPONSE::HTTP_INTERNAL_SERVER_ERROR, 'Internal server error.', "", $ex->getMessage()),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }
    public function logout(Request $request)
    {
        try{
        $token = $request->user()->token(); 
        $token->revoke();
        $user = User::where('id', $token->user_id)->first();
        $user['remember_token'] = '';
        if($user->save()){ 
        return response()
        ->json(
            HelperClass::responeObject(null, true, RESPONSE::HTTP_OK, 'Successfully logged out', "You have been successfully logged out!", ""),
            Response::HTTP_OK
        );
    }else{
        return response()
        ->json(
            HelperClass::responeObject(null, true, RESPONSE::HTTP_INTERNAL_SERVER_ERROR, 'logout failure.', "We could not successfully log out your account please try again!", ""),
            Response::HTTP_INTERNAL_SERVER_ERROR
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
            HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
}} 
    public function store(StoreUserRequest $request)
    {
        try {
        $input = $request->all();
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::where('phone_number', $request->phone_number)->first();
            if($user){
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'User already exist.', "",  "A user already exist by this phonenumber "),
                    Response::HTTP_CONFLICT
                );
            }
            /* $membership = Membership::where('id', $request->membership_id)->where('status','=','active')->first();
            if(!$membership){
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'Membership doesnt exist.', "",  "Membership doesnt exist."),
                    Response::HTTP_CONFLICT
                );
            } */
            $user = new User($input);
            $user->password = Hash::make($request->password);
            $user->remember_token  = $user->createToken('Bertucan access token')->accessToken;
            if($request->address){
                $address = $request->address;
                $address = Address::create($address);            
                $user->address_id = $address->id; 
            }                       
                //$user->status = "active";
                if($user->save()){                     
                    $user->address;
                    return response()
                ->json(
                    HelperClass::responeObject($user, true, Response::HTTP_CREATED,'User created.',"A user is created.",""),
                    Response::HTTP_CREATED
                );
                }else{
                    return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR,'Internal error', "",  "This user couldnt be saved."),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                } 
        } else {
            return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_CONFLICT,'User already exist.', "",  "A user already exist by this email."),
                    Response::HTTP_CONFLICT
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
                HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'Internal server error.', "", $ex->getMessage()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
    }
    }


    public function destroy(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_NOT_FOUND, "Resource Not Found", '', "User by this id doesnt exist."),
                        Response::HTTP_NOT_FOUND
                    );
            }
            $user->status = 'deleted';
            $user->save();
            return response()
                ->json(
                    HelperClass::responeObject(null, true, Response::HTTP_OK, 'Successfully deleted.', "User is deleted sucessfully.", ""),
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
