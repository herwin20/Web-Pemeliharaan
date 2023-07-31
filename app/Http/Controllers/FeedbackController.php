<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    #code..
    public function index()
    {
        return view('feedback.feedback');
    }

    public function testpage()
    {
        $dboracle = DB::connection('oracle')->select(
            "SELECT *FROM 
            (SELECT
                WORK_ORDER,
                WO_DESC,
                CREATION_DATE,
                PLAN_STR_DATE,
                ACTUAL_START_DATE,
                CLOSED_DT,
                MAINT_TYPE,
                WORK_GROUP,
                WO_STATUS_M,
                EQUIP_NO,
                DSTRCT_WO
                FROM MSF620 
            WHERE (
                DSTRCT_CODE LIKE 'UPMT' AND 
                PLAN_STR_DATE LIKE '%202301%' AND
                WORK_GROUP = 'TELECT' AND
                MAINT_TYPE = 'PM'
                )
            ORDER BY CREATION_DATE DESC)"
        );

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TMECH'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
            ->orderBy('msf620.plan_fin_date', 'asc')
            ->get();


        //WHERE ROWNUM < 5 after ()

        dd($tablepmnotcomply);
    }
}
