<?php

namespace App\Http\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allCompany = Company::where('status', 'active')->get();
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allCompany,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Company are fetched sucessfully.",
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
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        try{
            $input = $request->all();
            $company= new Company($input);
            $company->status="active";
            if($company->save()){
                return response()
                ->json(
                    HelperClass::responeObject($company, true, Response::HTTP_CREATED, 'Company created.', "A company is created.", ""),
                    Response::HTTP_CREATED
                );
            }else{
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This company couldnt be saved."),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
           }catch (Exception $ex) { // Anything that went wrong
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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $allCompany = Company::where('id',$id)->first();
            //->each(function($article, $key)){$article->media;};
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allCompany,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Company is fetched sucessfully.",
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}