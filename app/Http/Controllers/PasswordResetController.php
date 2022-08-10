<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;

use App\Mail\NotifyMail;
use App\Models\PasswordReset;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetController extends Controller
{
    public function requestpasswordreset(PasswordResetRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $code = rand(10000, 99999);
            echo "Code", (string)$code;
            $pass_reset = new PasswordReset();
            $pass_reset->user_id = $user->id;
            $pass_reset->code = Hash::make($code);
            $pass_reset->save();
            //send email
            $this->sendemail($request->email, $code);
            return response()
                ->json(
                    HelperClass::responeObject(
                        "",
                        true,
                        Response::HTTP_OK,
                        'Password reset request successful.',
                        "Code sent to email.",
                        ""
                    ),
                    Response::HTTP_OK
                );
        } else {
            return response()
                ->json(
                    HelperClass::responeObject(
                        "",
                        true,
                        Response::HTTP_FORBIDDEN,
                        'User not found with this email.',
                        "User not found with this email.",
                        "User not found with this email."
                    ),
                    Response::HTTP_OK
                );
        }
    }

    public function resetpassword(PasswordResetRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $passwordReset = PasswordReset::where('user_id', $user->id)
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$passwordReset) {
                return response()
                    ->json(
                        HelperClass::responeObject(
                            "",
                            true,
                            Response::HTTP_FORBIDDEN,
                            'You did not request for password reset.',
                            'You did not request for password reset.',
                            'You did not request for password reset.'
                        ),
                        Response::HTTP_OK
                    );
            }
            if (Hash::check($request->input("code"), $passwordReset->code)) {
                $user->password = Hash::make($request->input("new_password"));
                $user->save();
                $passwordReset->status = 'removed';
                $passwordReset->save();
                return response()
                    ->json(
                        HelperClass::responeObject(
                            "",
                            true,
                            Response::HTTP_OK,
                            'Password reset successful.',
                            "Password reset successful.",
                            ""
                        ),
                        Response::HTTP_OK
                    );
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(
                            "",
                            true,
                            Response::HTTP_FORBIDDEN,
                            'Incorrect Reset Code.',
                            'Incorrect Reset Code.',
                            'Incorrect Reset Code.'
                        ),
                        Response::HTTP_OK
                    );
            }

        } else {
            return response()
                ->json(
                    HelperClass::responeObject(
                        "",
                        true,
                        Response::HTTP_FORBIDDEN,
                        'User not found with this email.',
                        "User not found with this email.",
                        "User not found with this email."
                    ),
                    Response::HTTP_OK
                );
        }
    }

    public function sendemail($email, $code)
    {
        Mail::to($email)->send(new NotifyMail($code));

        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        } else {
            return response()->success('Great! Successfully send in your mail');
        }
    }
}


