<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Gate; 
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HelperClass
{

    public static function uploadFile($fileToBeUploaded, $filename, $location)
    {
        return $fileToBeUploaded->move($location, $filename);
    }
    public function imageUpload(Request $request){
        $file=$request->file('file');
        $fileName=$file->getClientOriginalName();
        $finalName= date('His') . $fileName;
        $request->file('file')->storeAs('file/',$finalName,'public');
        return response()
                    ->json(
                        HelperClass::responeObject($finalName, true, Response::HTTP_CREATED, "Validation failed check JSON request", "WORKED","WORKED"),
                        Response::HTTP_CREATED
                    );
    }
    
     public static function responeObject($data,$success,$status,$title,$message,$error){
         return [
            'data' => $data,
            'success' => $success,
            'content' => [
                [
                    'status' => $status,
                    'title' => $title,
                    'message' => $message,
                    'error'=> $error
                ],
            ]
            ];
     }
}
