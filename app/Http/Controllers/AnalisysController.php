<?php

namespace App\Http\Controllers;

use App\Charts\CurrentGT11;
use App\Charts\VoltageChartGT;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Charts\CoolerFan as ChartsCoolerFan;
use App\Models\CoolerFan;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CoolerFanImport;

class AnalisysController extends Controller
{
    public function CorrectiveAnalisys(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');

        $equip = $request->name;

        $tablecorrectivefreq = DB::table('msf620')
            ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
            ->where([
                ['work_group', 'LIKE', '%TELECT%'],
                ['maint_type', '=', 'CR'],
                //['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->orderBy('total', 'desc')
            ->paginate(5);

        $tablecorrectiveyear = DB::table('msf620')
            ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 0')
            ->orderBy('total', 'desc')
            ->paginate(5);

        if ($request->name) {
            $tablecorrectivedetail = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['equip_no', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(5);

            $totalcorr = DB::table('msf620')
                ->select(DB::raw('DATE_FORMAT(creation_date, "%Y") as date'), DB::raw('COUNT(creation_date) as total'))
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['equip_no', 'like', '%' . $request->name . '%'],
                ])
                ->groupBy('date')
                ->pluck('total');

            $nameofyear = DB::table('msf620')
                ->select(DB::raw('DATE_FORMAT(creation_date, "%Y") as date'), DB::raw('COUNT(creation_date) as total'))
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['equip_no', 'like', '%' . $request->name . '%'],
                ])
                ->groupBy('date')
                ->pluck('date');
        } else {
            $tablecorrectivedetail = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['equip_no', 'like', '%000000000%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(5);
            $totalcorr = DB::table('msf620')
                ->select(DB::raw('DATE_FORMAT(creation_date, "%Y") as date'), DB::raw('COUNT(creation_date) as total'))
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['equip_no', 'like', '%00000000000000%'],
                ])
                ->groupBy('date')
                ->pluck('total');

            $nameofyear = DB::table('msf620')
                ->select(DB::raw('DATE_FORMAT(creation_date, "%Y") as date'), DB::raw('COUNT(creation_date) as total'))
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['equip_no', 'like', '%0000000000000%'],
                ])
                ->groupBy('date')
                ->pluck('date');
        }

        return view('analisis/corrective', [
            'tablecorrectivefreq' => $tablecorrectivefreq,
            'thisyear' => $thisyear,
            'tablecorrectiveyear' => $tablecorrectiveyear,
            'totalcorr' => $totalcorr,
            'nameofyear' => $nameofyear,
            'tablecorrectivedetail' => $tablecorrectivedetail,
            'equip' => $equip,
        ]);
    }

    public function ILSAnalisys(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');

        $equip = $request->name;

        $tableilsfreq = DB::table('msf541')
            ->select('equip_no', 'short_desc', 'raised_date', DB::raw('COUNT(equip_no) AS total'))
            /*->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                //['creation_date', 'LIKE', '%' . $thisyear . '%']
            ]) */
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->orderBy('total', 'desc')
            ->paginate(5);

        $tableilsyear = DB::table('msf541')
            ->select('equip_no', 'short_desc', 'raised_date', DB::raw('COUNT(equip_no) AS total'))
            ->where([
                ['raised_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 0')
            ->orderBy('total', 'desc')
            ->paginate(5);

        if ($request->name) {
            $totalils = DB::table('msf541')
                ->select(DB::raw('DATE_FORMAT(raised_date, "%Y") as date'), DB::raw('COUNT(raised_date) as total'))
                ->where([
                    ['equip_no', 'like', '%' . $request->name . '%'],
                ])
                ->groupBy('date')
                ->pluck('total');

            $nameofyear = DB::table('msf541')
                ->select(DB::raw('DATE_FORMAT(raised_date, "%Y") as date'), DB::raw('COUNT(raised_date) as total'))
                ->where([
                    ['equip_no', 'like', '%' . $request->name . '%'],
                ])
                ->groupBy('date')
                ->pluck('date'); //Pluck untuk membuat 1 data sesuai perintah

            $tableilsdetail = DB::table('msf541')
                ->where([
                    ['equip_no', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('raised_date', 'desc')
                ->paginate(5);
            //dd($jsontotal);
        } else {
            $tableilsdetail = DB::table('msf541')
                ->where([
                    ['equip_no', 'like', '%000000000%']
                ])
                ->orderBy('raised_date', 'desc')
                ->paginate(5);

            $totalils = DB::table('msf541')
                ->select(DB::raw('DATE_FORMAT(raised_date, "%Y") as date'), DB::raw('COUNT(raised_date) as total'))
                ->where([
                    ['equip_no', 'like', '%000000000%'],
                ])
                ->groupBy('date')
                ->get();

            $nameofyear = DB::table('msf541')
                ->select(DB::raw('DATE_FORMAT(raised_date, "%Y") as date'), DB::raw('COUNT(raised_date) as total'))
                ->where([
                    ['equip_no', 'like', '%000000000%'],
                ])
                ->groupBy('date')
                ->get();
        }

        return view('analisis/ils-analisis', [
            'tableilsfreq' => $tableilsfreq,
            'thisyear' => $thisyear,
            'tableilsyear' => $tableilsyear,
            'totalils' => $totalils,
            'nameofyear' => $nameofyear,
            'tableilsdetail' => $tableilsdetail,
            'equip' => $equip,
        ]);
    }

    /* public function generator(CurrentGT11 $chart, VoltageChartGT $chart2)
    {
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

        $gt11var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt11varfix = number_format((float)$gt11var, 2, '.', '');

        $gt12var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt12varfix = number_format((float)$gt12var, 2, '.', '');

        $gt13var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt13varfix = number_format((float)$gt13var, 2, '.', '');

        $st14var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '14MKA10CE606 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $st14varfix = number_format((float)$st14var, 2, '.', '');

        $freq = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE103 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $freqfix = number_format((float)$freq, 2, '.', '');

        $ntwkvolt = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKY30CE643 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $ntwkvolfix = number_format((float)$ntwkvolt, 2, '.', '');

        $testdata = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(20)->pluck('value');

        //dd($testdata);

        return view('analisis/generator', [
            'gt11power' => $gt11powerfix,
            'gt11var' => $gt11varfix,
            'gt12power' => $gt12powerfix,
            'gt12var' => $gt12varfix,
            'gt13power' => $gt13powerfix,
            'gt13var' => $gt13varfix,
            'st14power' => $st14powerfix,
            'st14var' => $st14varfix,
            'freqfix' => $freqfix,
            'ntwkvoltfix' => $ntwkvolfix,
            'chart' => $chart->build(),
            'chart2' => $chart2->build(),
        ]);
    } */

    public function pltguindex(Request $request, CurrentGT11 $chart, VoltageChartGT $chart2)
    {
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

        //dd($gt12power);

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

        /* $gt21power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '21MKA10CE902 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt21powerfix = number_format((float)$gt21power, 2, '.', '');

        $gt22power = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '21MKA10CE902 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt22powerfix = number_format((float)$gt22power, 2, '.', ''); */

        $gt11var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt11varfix = number_format((float)$gt11var, 2, '.', '');

        $gt12var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt12varfix = number_format((float)$gt12var, 2, '.', '');


        $gt13var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt13varfix = number_format((float)$gt13var, 2, '.', '');

        /*$gt21var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '21MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt21varfix = number_format((float)$gt21var, 2, '.', '');

        $gt22var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '22MKA10CE606 XQ51')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $gt22varfix = number_format((float)$gt22var, 2, '.', ''); */

        $st14var = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '14MKA10CE606 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $st14varfix = number_format((float)$st14var, 2, '.', '');

        $freq = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE103 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $freqfix = number_format((float)$freq, 2, '.', '');

        $ntwkvolt = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKY30CE643 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $ntwkvolfix = number_format((float)$ntwkvolt, 2, '.', '');

        $excgt11 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKY20CE032 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $excgt11fix = number_format((float)$excgt11, 2, '.', '');

        $excgt12 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKY20CE032 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $excgt12fix = number_format((float)$excgt12, 2, '.', '');

        $excgt13 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKY20CE032 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $excgt13fix = number_format((float)$excgt13, 2, '.', '');

        $excst14 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '14MKY20CE032 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        $excst14fix = number_format((float)$excst14, 2, '.', '');

        $voltageGT12L1 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE104 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(1)->pluck('value')[0];
        
        $HVCB = $voltageGT12L1 * 31.25;
        $HVCBfix = number_format((float)$HVCB, 2, '.', '');

        $testdata = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(20)->pluck('value');

        //dd($testdata);

        if ($request->ajax()) {
            return response()->json(
                [
                    'gt11power' => $gt11powerfix,
                    'gt11var' => $gt11varfix,
                    'gt12power' => $gt12powerfix,
                    'gt12var' => $gt12varfix,
                    'gt13power' => $gt13powerfix,
                    'gt13var' => $gt13varfix,
                    'st14power' => $st14powerfix,
                    'st14var' => $st14varfix,
                    //'ntwkvoltfix' => $ntwkvolfix,
                    'freqfix' => $freqfix,
                    'HVCBfix' => $HVCBfix,
                    'excgt11' => $excgt11fix,
                    'excgt12' => $excgt12fix,
                    'excgt13' => $excgt13fix,
                    'excst14' => $excst14fix,
                ]
            );
        }

        return view('analisis.pltgu', [
            'gt11power' => $gt11powerfix,
            'gt11var' => $gt11varfix,
            'gt12power' => $gt12powerfix,
            'gt12var' => $gt12varfix,
            'gt13power' => $gt13powerfix,
            'gt13var' => $gt13varfix,
            //'gt21power' => $gt21powerfix,
            //'gt21var' => $gt21varfix,
            //'gt22power' => $gt22powerfix,
            //'gt22var' => $gt22varfix,
            'st14power' => $st14powerfix,
            'st14var' => $st14varfix,
            'freqfix' => $freqfix,
            'ntwkvoltfix' => $ntwkvolfix,
            'HVCBfix' => $HVCBfix,
            'chart' => $chart->build(),
            'chart2' => $chart2->build(),
            'excgt11' => $excgt11fix,
            'excgt12' => $excgt12fix,
            'excgt13' => $excgt13fix,
            'excst14' => $excst14fix,
        ]);
    }

    public function motorindex(ChartsCoolerFan $coolerFan)
    {
        $c1f1 = CoolerFan::where([
            ['unit', '=', 'GT11'],
            ['equipment', '=', 'C1F1'],
        ])->paginate(5);

        return view('analisis.motor', [
            'c1f1' => $c1f1,
            'chart' => $coolerFan->build(),
        ]);
    }

    public function pkuindex(Request $request)
    {

        if ($request->equip) {

            $option = $request->equip;

            if ($request->equip == 'GENERATOR') {
                $regexp = 'generator|bearing 3|bearing 4|bearing generator|brush|vibrasi';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'GENERATOR';
            }

            if ($request->equip == 'DC SYSTEMS') {
                $regexp = 'battery|batt|dc|charger|bank|inveter|ups';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'DC SYSTEMS';
            }

            if ($request->equip == 'TRANSFORMATOR') {
                $regexp = 'transf|trafo|transformator';
                $regexpunit = 'gt11|gt 11|gt12|gt 12';
                $namaequip = 'TRANSFORMATOR';
            }

            if ($request->equip == 'HV SYSTEMS') {
                $regexp = 'bja|bja10|bja20|bja30|bja40|bja50|bja60|bja70|low voltage|incomer|coupling';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'HV SYSTEMS';
            }

            if ($request->equip == 'EXCITATION') {
                $regexp = 'exc|excitation';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'EXCITATION';
            }

            if ($request->equip == 'EGATROL') {
                $regexp = 'crc|oms';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'EGATROL';
            }

            if ($request->equip == 'AIR INTAKE') {
                $regexp = 'air intake';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'AIR INTAKE';
            }

            if ($request->equip == 'LUBE OIL') {
                $regexp = 'elop|main lube|lube oil|jacking|barring|power oil|lube oil tank';
                $regexpunit = 'gt11|gt 11';
                $namaequip = 'LUBE OIL';
            }

            $pku = DB::table('msf620')
                ->select('wo_desc', 'plan_str_date', 'closed_dt', DB::raw('DATEDIFF(closed_dt, plan_str_date) AS Total'))
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])
                ->limit(5)
                ->orderBy('plan_str_date', 'desc');

            //Table    
            $tablepku = $pku->paginate(5);
            //Count Days CR
            $countdaypku = $pku->get()->sum('Total');
            //TotalWorkDays
            $date = Carbon::parse('2019-01-01');
            $now = Carbon::now()->format('Y-m-d');
            $totaldayoperation = $date->diffInDays($now);
            //Count of CR
            $countofcr = $pku->count();
            //Function Reliability
            $mtbf = round((($totaldayoperation - ($countofcr * $countdaypku)) / $countofcr), 0);
            $failurerate = round((1 / $mtbf) * 100, 2);
            $mttr = round($countdaypku / $countofcr, 2);
            $repairrate =  round((1 / $mttr) * 100, 0);
            $reliability = round(exp((- ($totaldayoperation)) / $mtbf) * 100, 2);
            $availibility = round(($mtbf / ($mtbf + $mttr)) * 100, 2);
            $maintainability = round((1 - (exp(- ($totaldayoperation / $reliability)))) * 100, 2);

            $reliability1 = round(exp((- (1)) / $mtbf) * 100, 2);
            $reliability2 = round(exp((- (100)) / $mtbf) * 100, 2);
            $reliability3 = round(exp((- (200)) / $mtbf) * 100, 2);
            $reliability4 = round(exp((- (400)) / $mtbf) * 100, 2);
            $reliability5 = round(exp((- (600)) / $mtbf) * 100, 2);
            $reliability6 = round(exp((- (800)) / $mtbf) * 100, 2);
            $reliability7 = round(exp((- (1000)) / $mtbf) * 100, 2);
            $reliability8 = round(exp((- (1200)) / $mtbf) * 100, 2);
            $reliability9 = round(exp((- (1400)) / $mtbf) * 100, 2);
            $reliability10 = round(exp((- ($totaldayoperation)) / $mtbf) * 100, 2);
        } else {
            $namaequip = 'DC SYSTEMS';
            $option = 'DC SYSTEMS';
            $pku = DB::table('msf620')
                ->select('wo_desc', 'plan_str_date', 'closed_dt', DB::raw('DATEDIFF(closed_dt, plan_str_date) AS Total'))
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', 'battery|batt|dc|charger|bank'],
                    ['wo_desc', 'REGEXP', 'gt11|gt 11'],
                ])
                ->limit(5)
                ->orderBy('plan_str_date', 'desc');

            //Table    
            $tablepku = $pku->paginate(5);
            //Count Days CR
            $countdaypku = $pku->get()->sum('Total');
            //TotalWorkDays
            $date = Carbon::parse('2019-01-01');
            $now = Carbon::now()->format('Y-m-d');
            $totaldayoperation = $date->diffInDays($now);
            //Count of CR
            $countofcr = $pku->count();
            //Function Reliability
            $mtbf = round((($totaldayoperation - ($countofcr * $countdaypku)) / $countofcr), 0);
            $failurerate = round((1 / $mtbf) * 100, 2);
            $mttr = round($countdaypku / $countofcr, 0);
            $repairrate =  round((1 / $mttr) * 100, 2);
            $reliability = round(exp((- ($totaldayoperation)) / $mtbf) * 100, 2);
            $availibility = round(($mtbf / ($mtbf + $mttr)) * 100, 2);
            $maintainability = round((1 - (exp(- ($totaldayoperation / $reliability)))) * 100, 2);

            $reliability1 = round(exp((- (1)) / $mtbf) * 100, 2);
            $reliability2 = round(exp((- (100)) / $mtbf) * 100, 2);
            $reliability3 = round(exp((- (200)) / $mtbf) * 100, 2);
            $reliability4 = round(exp((- (400)) / $mtbf) * 100, 2);
            $reliability5 = round(exp((- (600)) / $mtbf) * 100, 2);
            $reliability6 = round(exp((- (800)) / $mtbf) * 100, 2);
            $reliability7 = round(exp((- (1000)) / $mtbf) * 100, 2);
            $reliability8 = round(exp((- (1200)) / $mtbf) * 100, 2);
            $reliability9 = round(exp((- (1400)) / $mtbf) * 100, 2);
            $reliability10 = round(exp((- ($totaldayoperation)) / $mtbf) * 100, 2);
        }

        return view('analisis.pku', [
            'tablepku' => $tablepku,
            'namaequip' => $namaequip,
            'option' => $option,
            'totaldayoperation' => $totaldayoperation,
            'countofcr' => $countofcr,
            'mtbf' => $mtbf,
            'countdaypku' => $countdaypku,
            'mttr' => $mttr,
            'failurerate' => $failurerate,
            'repairrate' => $repairrate,
            'reliability' => $reliability,
            'availibility' => $availibility,
            'maintainability' => $maintainability,

            'reliability1' => $reliability1,
            'reliability2' => $reliability2,
            'reliability3' => $reliability3,
            'reliability4' => $reliability4,
            'reliability5' => $reliability5,
            'reliability6' => $reliability6,
            'reliability7' => $reliability7,
            'reliability8' => $reliability8,
            'reliability9' => $reliability9,
            'reliability10' => $reliability10,
        ]);
    }

    public function importcooler()
    {
        Excel::import(new CoolerFanImport, request()->file('file'));  ##Cooler Fan Import Harus bikin dulu php artisan make:import
        return redirect('motor')->with('success', 'File has been added succesfully!');
    }
}
