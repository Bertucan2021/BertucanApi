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
