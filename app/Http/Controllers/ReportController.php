<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Address;

class ReportController extends Controller
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
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {
        try{
            $input = $request->all();
            $report= new Report($input);
            $report->status="active";
            if($report->save()){
                $address = $request->address;
                $address = new Address($address);
                $address->type='report';
                if (!$address->save()) {
                    return  response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, "Report saved but Address couldn't be saved.", "",  "Report saved but Address couldn't be saved"),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    );
                }
                return response()
                ->json(
                    HelperClass::responeObject($report, true, Response::HTTP_CREATED, 'Report created.', "Report is created.", ""),
                    Response::HTTP_CREATED
                );
            }else{
                return response()
                ->json(
                    HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "",  "This report couldnt be saved."),
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
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
