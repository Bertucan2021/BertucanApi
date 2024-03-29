<?php

namespace App\Http\Controllers;

use App\Models\GbvCenter;
use App\Models\Report;
use App\Models\AbuseType;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Address;
use App\Models\Media;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allReport = Report::where('status', 'active')
                ->get()
                ->each(function ($item, $key) {
                    $item->abuseType;
                    $item->gbvCenter;
                    $item->users;
                });
            return response()
                ->json(
                    HelperClass::responeObject(
                        $allReport,
                        true,
                        Response::HTTP_OK,
                        'Successfully fetched.',
                        "Report are fetched sucessfully.",
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
     * @param \App\Http\Requests\StoreReportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {
        try {
            $input = $request->all();
            $fileExist = false;
            if ($request->hasFile('file') != null) {
                $fileExist = true;
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $finalName = date('His') . $fileName;
                $request->file('file')->storeAs('report/', $finalName, 'public');
            }
            $abuseType = AbuseType::where('id', $request->abuse_types_id)->first();
            if (!$abuseType) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_CONFLICT, 'Abuse Type does not exist.', "", "An abuse type does not exist by this id."),
                        Response::HTTP_CONFLICT
                    );
            }

            $gbv_center = GbvCenter::where('id', $request->gbv_center)->first();
            if (!$gbv_center) {
                return response()
                    ->json(
                        HelperClass::responeObject(null, false, Response::HTTP_CONFLICT, 'GBV center does not exist.', "", "A GBV center does not exist by this id."),
                        Response::HTTP_CONFLICT
                    );
            }


            $report = new Report($input);
            $report->status = "active";
            $report->gbv_center = $request->gbv_center;
            $report->abuse_types_id = $request->abuse_types_id;
            $report->contact_phone_number = $request->contact_phone_number;
            $report->contact_address = $request->contact_address;

            $report->user_id = Auth::user()->id;
            echo $fileExist;
            if ($report->save()) {
                if ($fileExist) {

                    $media = new Media();
                    $media->url = "report/" . $finalName;
                    $media->type = 'report';
                    $media->item_id = $report->id;
                    $report->abuse_type = "report/" . $finalName;
                    $report->save();
                    if (!$media->save()) {
                        return response()
                            ->json(
                                HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "", "This media couldnt be saved."),
                                Response::HTTP_INTERNAL_SERVER_ERROR
                            );
                    }
                    return response()
                        ->json(
                            HelperClass::responeObject($report, true, Response::HTTP_CREATED, 'Report created.', "Report is created.", ""),
                            Response::HTTP_CREATED
                        );
                } else {
                    return response()
                        ->json(
                            HelperClass::responeObject(null, false, Response::HTTP_INTERNAL_SERVER_ERROR, 'Internal error', "", "This report couldnt be saved."),
                            Response::HTTP_INTERNAL_SERVER_ERROR
                        );
                }
            }
        } catch (Exception $ex) { // Anything that went wrong
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
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateReportRequest $request
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
