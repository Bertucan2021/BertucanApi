<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; 
use App\Models\User;
use App\Models\Address; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator; 
use App\Http\Requests\StoreUserRequest;
use App\Models\Media;

use function PHPUnit\Framework\fileExists;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = User::where('status', '!=', 'deleted')
                ->orWhereNull('status')->get()
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
            $user = User::where('email', $request->email)->first();
            if ($user) {
                 $line="73";
                if (Hash::check($request->password, $user->password)) {
                     $line="75";
                    $token = $user->createToken('Laravel Password Grant', [$user->role])->accessToken;
                     $line="77";
                    $user['remember_token'] = $token;
                    if ($user->save()) {
                        $user->address;
                        return response()
                            ->json(
                                HelperClass::responeObject($user, true, Response::HTTP_OK, 'User found', "User is succesfully logged in.", ""),
                                Response::HTTP_OK
                            );
                    } else {
                        return response()
                            ->json(
                                HelperClass::responeObject($user, true, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal Error', "", "An error occured while trying to log in."),
                                Response::HTTP_INTERNAL_SERVER_ERROR
                            );
                    }
                } else {
                    return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_UNAUTHORIZED, 'Password issue.', "Incorrect password.", ""),
                            Response::HTTP_UNAUTHORIZED
                        );
                }
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_UNAUTHORIZED, 'User doesnt exist.', "No registered user by this email.", ""),
                        Response::HTTP_UNAUTHORIZED
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
                    HelperClass::responeObject("There is some error.", false, RESPONSE::HTTP_INTERNAL_SERVER_ERROR, 'Internal server error.', "", $ex->getMessage()),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }
    public function logout(Request $request)
    {
        try {
            $token = $request->user()->token();
            $token->revoke();
            $user = User::where('id', $token->user_id)->first();
            $user->remember_token = '';
            if ($user->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, true, RESPONSE::HTTP_OK, 'Successfully logged out', "You have been successfully logged out!", ""),
                        Response::HTTP_OK
                    );
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, true, RESPONSE::HTTP_UNAUTHORIZED, 'logout failure.', "We could not successfully log out your account please try again!", ""),
                        Response::HTTP_UNAUTHORIZED
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

    public function store(StoreUserRequest $request)
    {
        try {
            $input = $request->all();
            $fileExist=false;
            if($request->hasFile('file')!=null){
                $fileExist=true;
            $file=$request->file('file');
                    $fileName=$file->getClientOriginalName();
                    $finalName= date('His') . $fileName;
                    $request->file('file')->storeAs('profilepic/',$finalName,'public');
            }
            $user = User::where('email', $request->email)->first(); 
            if (!$user) {
                $user = User::where('phone_number', $request->phone_number)->first(); 
                if ($user) {
                    return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_CONFLICT, 'User already exist.', "",  "A user already exist by this phonenumber "),
                            Response::HTTP_CONFLICT
                        );
                }  
                $user = new User($input); 
                $user->password = Hash::make($request->password);
                $user->role = "user";
                $user->remember_token  = $user->createToken('Laravel Password Grant', [$user->role])->accessToken;
                if ($request->address) {
                    $address = $request->address;
                    $address = Address::create($address);
                    $user->address_id = $address->id;
                }
                if($fileExist){ 
                    $user->profile_picture="profilepic/".$finalName;
                }
                //$user->status = "active"; 
                if ($user->save()) {
                    $user->address;
                    if($fileExist){
                    $media= new Media();
                    $media->url="profilepic/".$finalName;
                    $media->type='user';
                    $media->item_id=$user->id;
                    if(!$media->save()){                        
                        return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This media couldnt be saved."),
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                    }
                }

                    return response()
                        ->json(
                            HelperClass::responeObject($user, true, Response::HTTP_CREATED, 'User created.', "A user is created.", ""),
                            Response::HTTP_CREATED
                        );
                } else {
                    return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This user couldnt be saved."),
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                }
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_CONFLICT, 'User already exist.', "",  "A user already exist by this email."),
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
