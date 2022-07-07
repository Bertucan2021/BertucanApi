<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Media;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        try{
        $file=$request->file('file');
        $fileName=$file->getClientOriginalName();
        $finalName= date('His') . $fileName;
        $request->file('file')->storeAs('file/',$finalName,'public');
        $media= new Media();
        $media->url=$finalName;
        $media->type=$request->type;
        if($media->save()){
            return response()
            ->json(
                HelperClass::responeObject($media, true, Response::HTTP_CREATED, 'Media created.', "A media is created.", ""),
                Response::HTTP_CREATED
            );
        }else{
            return response()
            ->json(
                HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This media couldnt be saved."),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        
                } catch (ModelNotFoundException $ex) { // User not found
                    return response()
                        ->json(
                            HelperClass::responeObject(null, false, RESPONSE::HTTP_UNPROCESSABLE_ENTITY, 'The model doesnt exist.', "", $ex->getMessage()),
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
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMediaRequest  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }
}