<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allArticle = Article::where('status', 'active')->get()->each(function ($item, $key) {
                $item->user;
            });
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allArticle,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Article are fetched sucessfully.",
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

    public function fetchbylanguage($language)
    {
        try {
            $allArticle = [];
            if ($language === 'ALL') {
                $allArticle = Article::where('status', 'active')->get()->each(function ($item, $key) {
                    $item->user;
                });
            } else {
                $allArticle = Article::where('status', 'active')
                    ->where('language', $language)
                    ->get()->each(function ($item, $key) {
                        $item->user;
                    });
            }
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allArticle,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Article are fetched sucessfully.",
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
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        try {
            $input = $request->all();
            $fileExist = false;
            if ($request->hasFile('file') != null) {
                $fileExist = true;
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $finalName = date('His') . $fileName;
                $request->file('file')->storeAs('article/', $finalName, 'public');
            }

            if ($request->input('id')) {
                $article = Article::where('id', $request->input('id'))->first();
                $article->title = $request->input('title');
                $article->introduction = $request->input('introduction');
                $article->icon = $request->input('icon');
                $article->body = $request->input('body');
                $article->small_description = $request->input('small_description');
                $article->article_by = $request->input('article_by');
                $article->type = $request->input('type');
                $article->language = $request->input('language');
                $article->status = $request->input('status');
            } else {
                $article = new Article($input);
                $article->status = "active";
            }
            if ($fileExist) {
                $article->icon = "article/" . $finalName;
            }

            $response_message = "Article created.";
            if ($request->input('id') && $request->input('status') == 'removed') {
                echo "hrer";
                $response_message = "Article center removed.";
            } else if ($request->input('id')) {
                $response_message = "Article center updated.";
            }
            if ($article->save()) {
                return response()
                    ->json(
                        HelperClass::responeObject($article, true, Response::HTTP_CREATED, $response_message, "An " . $response_message, ""),
                        Response::HTTP_CREATED
                    );
            } else {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "", "This article couldnt be saved."),
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
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $allArticle = Article::where('id', $id)->first();
            $allArticle->user;
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allArticle,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Article is fetched sucessfully.",
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
     * @param \App\Http\Requests\UpdateArticleRequest $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            //$user = $request->user();
            if (!$article) {
                response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_NOT_FOUND, "Resource Not Found", '', "User by this id doesnt exist."),
                        Response::HTTP_NOT_FOUND
                    );
            }
            $article->status = 'deleted';
            $article->save();
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
