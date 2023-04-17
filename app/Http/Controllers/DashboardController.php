<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart1;
use App\Models\Calendar;
use Carbon\Carbon;
use App\Models\WrenchTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

class DashboardController extends Controller
{
    public function Index(DashboardChart1 $dashboardChart1, Request $request)
    {
        $thisyear = Carbon::now()->format('Y');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');

        $jumlahwopmclosedyear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmopenyear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $pmcompliance = (($jumlahwopmclosedyear / $jumlahwopmopenyear) * 100);
        $pmcompliancefix = number_format((float)$pmcompliance, 2, ',', '');

        $jumlahwocryear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoyear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $reactivework = ($jumlahwocryear / $jumlahwoyear) * 100;
        $reactiveworkfix = number_format((float)$reactivework, 2, '.', '');

        $jumlahreworkyear = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $rework = ($jumlahreworkyear / $jumlahwocryear) * 100;
        $reworkfix = number_format((float)$rework, 2, '.', '');

        $handrepair = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $thisyear . '%'],
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');

        $timeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $thisyear . '%'],
            ['work_group', '=', 'TELECT'],
        ])->sum('time_to_repairs');

        $wrenchtime = ($handrepair / $timeonrepairs) * 100;
        $wrenchtimefix = number_format((float)$wrenchtime, 2, '.', '');

        $jumlahwopmclosedyear3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmopenyear3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $pmcompliance3 = (($jumlahwopmclosedyear3 / $jumlahwopmopenyear3) * 100);
        $pmcompliancefix3 = number_format((float)$pmcompliance3, 2, ',', '');

        $jumlahwocryear3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoyear3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $reactivework3 = ($jumlahwocryear3 / $jumlahwoyear3) * 100;
        $reactiveworkfix3 = number_format((float)$reactivework3, 2, '.', '');

        $jumlahreworkyear3 = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $rework3 = ($jumlahreworkyear3 / $jumlahwocryear3) * 100;
        $reworkfix3 = number_format((float)$rework3, 2, '.', '');

        $handrepair3 = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $thisyear . '%'],
            ['work_group', '=', 'TELECT3'],
        ])->sum('on_hand_repairs');

        $timeonrepairs3 = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $thisyear . '%'],
            ['work_group', '=', 'TELECT3'],
        ])->sum('time_to_repairs');

        $wrenchtime3 = ($handrepair3 / $timeonrepairs3) * 100;
        $wrenchtimefix3 = number_format((float)$wrenchtime3, 2, '.', '');

        /*if ($request->ajax()) {
            $data = Calendar::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        } */

        $kerjaan = array();
        //$event = Calendar::all();
        // We Change with PM an CR
        $event = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orWhere([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'asc')
            ->get();

        foreach ($event as $event) {
            # code...
            $color = null;
            if ($event->maint_type == 'PM') {
                $color = '#0254ad';
            }
            if ($event->maint_type == 'CR') {
                $color = '#d65324';
            }

            $kerjaan[] = [
                'title' => $event->wo_desc,
                'start' => $event->plan_str_date . ' 08:00:00',
                'end' => $event->plan_fin_date . ' 16:00:00',
                'color' => $color,
                'textColor' => 'white',
            ];
        }
        //return response()->json($kerjaan);

        #Data MW
        $gt11power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE902 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt11powerfix = number_format((float)$gt11power, 2, '.', '');

        $gt12power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE902 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt12powerfix = number_format((float)$gt12power, 2, '.', '');

        $gt13power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE902 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt13powerfix = number_format((float)$gt13power, 2, '.', '');

        $st14power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '14MKA10CE609 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $st14powerfix = number_format((float)$st14power, 2, '.', '');

        $gt21power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '21MKA10CE609_XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt21powerfix = number_format((float)$gt21power, 2, '.', '');

        $gt22power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '22MKA10CE609_XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt22powerfix = number_format((float)$gt22power, 2, '.', '');

        if ($request->ajax()) {
            return response()->json(
                [
                    'gt11power' => $gt11powerfix,
                    'gt12power' => $gt12powerfix,
                    'gt13power' => $gt13powerfix,
                    'st14power' => $st14powerfix,
                    'gt21power' => $gt21powerfix,
                    'gt22power' => $gt22powerfix,
                ]
            );
        }

        #21MKA10CE609_XQ50
        #22MKA10CE609_XQ50

        return view('dashboard', [
            'pmcompliancefix' => $pmcompliancefix,
            'reactiveworkfix' => $reactiveworkfix,
            'reworkfix' => $reworkfix,
            'wrenchtimefix' => $wrenchtimefix,

            'pmcompliancefix3' => $pmcompliancefix3,
            'reactiveworkfix3' => $reactiveworkfix3,
            'reworkfix3' => $reworkfix3,
            'wrenchtimefix3' => $wrenchtimefix3,
            'dashboardChart1' => $dashboardChart1->build(),
            'kerjaan' => $kerjaan,
            'gt11power' => $gt11powerfix,
            'gt12power' => $gt12powerfix,
            'gt13power' => $gt13powerfix,
            'st14power' => $st14powerfix,
            'gt21power' => $gt21powerfix,
            'gt22power' => $gt22powerfix,
        ]);
    }

    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $event = Calendar::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json($event);
                break;
            case 'update':
                $event = Calendar::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json($event);
                break;
            case 'delete':
                $event = Calendar::find($request->id)->delete();
                return response()->json($event);
                break;
            default:
                # code...
                break;
        }
    }
}
