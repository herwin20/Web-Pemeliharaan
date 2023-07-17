<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReliabilityWeibull extends Component
{
    public function render(Request $request)
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
                ->select(
                    'wo_desc',
                    'creation_date',
                    'closed_dt',
                    DB::raw('DATEDIFF(creation_date, "2019-01-01") AS total_hari'),
                    DB::raw('DATEDIFF(closed_dt, plan_str_date) AS Total'),
                )
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])->get();

            $countpku = DB::table('msf620')
                ->select(
                    'wo_desc',
                    'creation_date',
                    'closed_dt',
                    DB::raw('DATEDIFF(creation_date, "2019-01-01") AS total_hari'),
                    DB::raw('DATEDIFF(closed_dt, plan_str_date) AS Total'),
                )
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])->count();

            $closed_dt = DB::table('msf620')
                ->select(
                    'closed_dt',
                )
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])->limit(1)->orderBy('closed_dt', 'desc')
                ->pluck('closed_dt')[0];

            //TotalWorkDays
            $date = Carbon::parse('2019-01-01');
            $now = Carbon::now()->format('Y-m-d');
            $totaldayoperation = $date->diffInDays($now);

            //daysafterlastfault
            $after = Carbon::parse($closed_dt);
            $dayafter = $after->diffInDays($now);

            //Count of CR
            $countofcr = $pku->count();
            $countdaypku = $pku->sum('Total');

            //MTTR
            $mttr = round($countdaypku / $countofcr, 2);

            $runningtotal = 0;
            $x = 0;
            $y = 0;
            $median = 0;
            $sumxy = 0;
            $sumx = 0;
            $sumy = 0;
            $sumx2 = 0;
            $sumy2 = 0;
            $intercept = 0;
            $slope = 0;
            $num = 0;
            $eta = 0;
            $aa = 0;
        } else {

            $regexp = 'battery|batt|dc|charger|bank|inveter|ups';
            $regexpunit = 'gt11|gt 11';
            $namaequip = 'DC SYSTEMS';
            $option = 'DC SYSTEMS';

            $pku = DB::table('msf620')
                ->select(
                    'wo_desc',
                    'creation_date',
                    'closed_dt',
                    DB::raw('DATEDIFF(creation_date, "2019-01-01") AS total_hari'),
                    DB::raw('DATEDIFF(closed_dt, plan_str_date) AS Total'),
                )
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])->get();

            $countpku = DB::table('msf620')
                ->select(
                    'wo_desc',
                    'creation_date',
                    'closed_dt',
                    DB::raw('DATEDIFF(creation_date, "2019-01-01") AS total_hari'),
                    DB::raw('DATEDIFF(closed_dt, plan_str_date) AS Total'),
                )
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])->count();

            $closed_dt = DB::table('msf620')
                ->select(
                    'closed_dt',
                )
                ->where([
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'REGEXP', $regexp],
                    ['wo_desc', 'REGEXP', $regexpunit],
                ])->limit(1)->orderBy('closed_dt', 'desc')
                ->pluck('closed_dt')[0];

            //TotalWorkDays
            $date = Carbon::parse('2019-01-01');
            $now = Carbon::now()->format('Y-m-d');
            $totaldayoperation = $date->diffInDays($now);

            //daysafterlastfault
            $after = Carbon::parse($closed_dt);
            $dayafter = $after->diffInDays($now);

            //Count of CR
            $countofcr = $pku->count();
            $countdaypku = $pku->sum('Total');

            //MTTR
            $mttr = round($countdaypku / $countofcr, 2);

            $runningtotal = 0;
            $x = 0;
            $y = 0;
            $median = 0;
            $sumxy = 0;
            $sumx = 0;
            $sumy = 0;
            $sumx2 = 0;
            $sumy2 = 0;
            $intercept = 0;
            $slope = 0;
            $num = 0;
            $eta = 0;
            $aa = 0;
        }

        return view('livewire.reliability-weibull', [
            'pku' => $pku,
            'namaequip' => $namaequip,
            'option' => $option,
            'totaldayoperation' => $totaldayoperation,
            'runningtotal' => $runningtotal,
            'median' => $median,
            'x' => $x,
            'y' => $y,
            'sumxy' => $sumxy,
            'sumx' => $sumx,
            'sumy' => $sumy,
            'sumx2' => $sumx2,
            'sumy2' => $sumy2,
            'countpku' => $countpku,
            'intercept' => $intercept,
            'slope' => $slope,
            'num' => $num,
            'eta' => $eta,
            'mttr' => $mttr,
            'countofcr' => $countofcr,
            'countdaypku' => $countdaypku,
            'dayafter' => $dayafter,
            'closed_dt' => $closed_dt,
            'aa' => $aa,
        ]);
    }
}
