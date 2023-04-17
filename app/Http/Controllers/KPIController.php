<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KPIController extends Controller
{
    public function Index()
    {
        return view('kpi.pmcompliancedashboard');
    }

    public function IndexReactiveWork()
    {
        return view('kpi.reactiveworkdashboard');
    }

    public function IndexReWork()
    {
        return view('kpi.reworkdashboard');
    }

    public function PMCompliance(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        /*$test = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TELECT'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
                ['msf620.plan_fin_date', 'LIKE', '%2023-01%']
            ])
            ->orderBy('msf620.plan_fin_date')
            ->get();

        dd($test->toJson()); */

        $option = 'TELECT';
        $namaunit = 'Listrik 1-2';

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TELECT') {
                $namaunit = 'Listrik 1-2';
            }
            if ($request->bidang == 'TELECT3') {
                $namaunit = 'Listrik 3-4';
            }
            if ($request->bidang == 'TELECT5') {
                $namaunit = 'Listrik 5';
            }

            $tablepmnotcomply = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                ])
                ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
                ->whereNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'asc')
                ->get();

            $jumlahwopmyear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjan == 0) {
                $jumlahwopmjan = 0.001;
            }

            $pmcompliancejan = ($jumlahwopmclosedjan / $jumlahwopmjan) * 100;
            $pmcompliancejanfix = number_format((float)$pmcompliancejan, 2, '.', '');

            $jumlahwopmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmfeb == 0) {
                $jumlahwopmfeb = 0.001;
            }

            $pmcompliancefeb = ($jumlahwopmclosedfeb / $jumlahwopmfeb) * 100;
            $pmcompliancefebfix = number_format((float)$pmcompliancefeb, 2, '.', '');

            $jumlahwopmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmar == 0) {
                $jumlahwopmmar = 0.001;
            }

            $pmcompliancemar = ($jumlahwopmclosedmar / $jumlahwopmmar) * 100;
            $pmcompliancemarfix = number_format((float)$pmcompliancemar, 2, '.', '');

            $jumlahwopmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmapr == 0) {
                $jumlahwopmapr = 0.001;
            }

            $pmcomplianceapr = ($jumlahwopmclosedapr / $jumlahwopmapr) * 100;
            $pmcomplianceaprfix = number_format((float)$pmcomplianceapr, 2, '.', '');

            $jumlahwopmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmay == 0) {
                $jumlahwopmmay = 0.001;
            }

            $pmcompliancemay = ($jumlahwopmclosedmay / $jumlahwopmmay) * 100;
            $pmcompliancemayfix = number_format((float)$pmcompliancemay, 2, '.', '');

            $jumlahwopmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjun == 0) {
                $jumlahwopmjun = 0.001;
            }

            $pmcompliancejun = ($jumlahwopmclosedjun / $jumlahwopmjun) * 100;
            $pmcompliancejunfix = number_format((float)$pmcompliancejun, 2, '.', '');

            $jumlahwopmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjul == 0) {
                $jumlahwopmjul = 0.001;
            }

            $pmcompliancejul = ($jumlahwopmclosedjul / $jumlahwopmjul) * 100;
            $pmcompliancejulfix = number_format((float)$pmcompliancejul, 2, '.', '');

            $jumlahwopmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmaug == 0) {
                $jumlahwopmaug = 0.001;
            }

            $pmcomplianceaug = ($jumlahwopmclosedaug / $jumlahwopmaug) * 100;
            $pmcomplianceaugfix = number_format((float)$pmcomplianceaug, 2, '.', '');

            $jumlahwopmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmsep == 0) {
                $jumlahwopmsep = 0.001;
            }

            $pmcompliancesep = ($jumlahwopmclosedsep / $jumlahwopmsep) * 100;
            $pmcompliancesepfix = number_format((float)$pmcompliancesep, 2, '.', '');

            $jumlahwopmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmoct == 0) {
                $jumlahwopmoct = 0.001;
            }

            $pmcomplianceoct = ($jumlahwopmclosedoct / $jumlahwopmoct) * 100;
            $pmcomplianceoctfix = number_format((float)$pmcomplianceoct, 2, '.', '');

            $jumlahwopmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmnov == 0) {
                $jumlahwopmnov = 0.001;
            }

            $pmcompliancenov = ($jumlahwopmclosednov / $jumlahwopmnov) * 100;
            $pmcompliancenovfix = number_format((float)$pmcompliancenov, 2, '.', '');

            $jumlahwopmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmdes == 0) {
                $jumlahwopmdes = 0.001;
            }

            $pmcompliancedes = ($jumlahwopmcloseddes / $jumlahwopmdes) * 100;
            $pmcompliancedesfix = number_format((float)$pmcompliancedes, 2, '.', '');

            // Total KPI Persen
            $totalkpi = ($pmcompliancejanfix + $pmcompliancefebfix + $pmcompliancemarfix + $pmcomplianceaprfix + $pmcompliancemayfix
                + $pmcompliancejunfix + $pmcompliancejulfix + $pmcomplianceaugfix + $pmcompliancesepfix + $pmcomplianceoctfix
                + $pmcompliancenovfix + $pmcompliancedesfix) / 12;

            $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

            $sevenyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sevenyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $sixyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sixyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fiveyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fiveyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fouryearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fouryearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $threeyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $threeyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $twoyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $oneyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $oneyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $nowyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])

                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
        } else {
            $option = 'TELECT';
            $namaunit = 'Listrik 1-2';

            $tablepmnotcomply = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C']

                ])
                ->whereNull('msf623.completion_comment')
                ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
                ->orderBy('msf620.plan_fin_date', 'asc')
                ->get();

            $jumlahwopmyear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjan == 0) {
                $jumlahwopmjan = 0.001;
            }

            $pmcompliancejan = ($jumlahwopmclosedjan / $jumlahwopmjan) * 100;
            $pmcompliancejanfix = number_format((float)$pmcompliancejan, 2, '.', '');

            $jumlahwopmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmfeb == 0) {
                $jumlahwopmfeb = 0.001;
            }

            $pmcompliancefeb = ($jumlahwopmclosedfeb / $jumlahwopmfeb) * 100;
            $pmcompliancefebfix = number_format((float)$pmcompliancefeb, 2, '.', '');

            $jumlahwopmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmar == 0) {
                $jumlahwopmmar = 0.001;
            }

            $pmcompliancemar = ($jumlahwopmclosedmar / $jumlahwopmmar) * 100;
            $pmcompliancemarfix = number_format((float)$pmcompliancemar, 2, '.', '');

            $jumlahwopmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmapr == 0) {
                $jumlahwopmapr = 0.001;
            }

            $pmcomplianceapr = ($jumlahwopmclosedapr / $jumlahwopmapr) * 100;
            $pmcomplianceaprfix = number_format((float)$pmcomplianceapr, 2, '.', '');

            $jumlahwopmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmay == 0) {
                $jumlahwopmmay = 0.001;
            }

            $pmcompliancemay = ($jumlahwopmclosedmay / $jumlahwopmmay) * 100;
            $pmcompliancemayfix = number_format((float)$pmcompliancemay, 2, '.', '');

            $jumlahwopmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjun == 0) {
                $jumlahwopmjun = 0.001;
            }

            $pmcompliancejun = ($jumlahwopmclosedjun / $jumlahwopmjun) * 100;
            $pmcompliancejunfix = number_format((float)$pmcompliancejun, 2, '.', '');

            $jumlahwopmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjul == 0) {
                $jumlahwopmjul = 0.001;
            }

            $pmcompliancejul = ($jumlahwopmclosedjul / $jumlahwopmjul) * 100;
            $pmcompliancejulfix = number_format((float)$pmcompliancejul, 2, '.', '');

            $jumlahwopmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmaug == 0) {
                $jumlahwopmaug = 0.001;
            }

            $pmcomplianceaug = ($jumlahwopmclosedaug / $jumlahwopmaug) * 100;
            $pmcomplianceaugfix = number_format((float)$pmcomplianceaug, 2, '.', '');

            $jumlahwopmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmsep == 0) {
                $jumlahwopmsep = 0.001;
            }

            $pmcompliancesep = ($jumlahwopmclosedsep / $jumlahwopmsep) * 100;
            $pmcompliancesepfix = number_format((float)$pmcompliancesep, 2, '.', '');

            $jumlahwopmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmoct == 0) {
                $jumlahwopmoct = 0.001;
            }

            $pmcomplianceoct = ($jumlahwopmclosedoct / $jumlahwopmoct) * 100;
            $pmcomplianceoctfix = number_format((float)$pmcomplianceoct, 2, '.', '');

            $jumlahwopmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmnov == 0) {
                $jumlahwopmnov = 0.001;
            }

            $pmcompliancenov = ($jumlahwopmclosednov / $jumlahwopmnov) * 100;
            $pmcompliancenovfix = number_format((float)$pmcompliancenov, 2, '.', '');

            $jumlahwopmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmdes == 0) {
                $jumlahwopmdes = 0.001;
            }

            $pmcompliancedes = ($jumlahwopmcloseddes / $jumlahwopmdes) * 100;
            $pmcompliancedesfix = number_format((float)$pmcompliancedes, 2, '.', '');

            // Total KPI Persen
            $totalkpi = ($pmcompliancejanfix + $pmcompliancefebfix + $pmcompliancemarfix + $pmcomplianceaprfix + $pmcompliancemayfix
                + $pmcompliancejunfix + $pmcompliancejulfix + $pmcomplianceaugfix + $pmcompliancesepfix + $pmcomplianceoctfix
                + $pmcompliancenovfix + $pmcompliancedesfix) / 12;

            $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

            $sevenyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sevenyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $sixyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sixyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fiveyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fiveyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fouryearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fouryearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $threeyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $threeyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%'],
                    ['msf620.wo_status_m', '=', 'C'],
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $oneyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $oneyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $nowyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])

                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
        }

        return view(
            'kpi/pmcompliance',
            [
                'thisyear' => $thisyear,
                'jumlahwopmyear' => $jumlahwopmyear,
                'jumlahwopmjan' => $jumlahwopmjan,
                'jumlahwopmclosedjan' => $jumlahwopmclosedjan,
                'pmcompliancejanfix' => $pmcompliancejanfix,
                'jumlahwopmfeb' => $jumlahwopmfeb,
                'jumlahwopmclosedfeb' => $jumlahwopmclosedfeb,
                'pmcompliancefebfix' => $pmcompliancefebfix,
                'jumlahwopmmar' => $jumlahwopmmar,
                'jumlahwopmclosedmar' => $jumlahwopmclosedmar,
                'pmcompliancemarfix' => $pmcompliancemarfix,
                'jumlahwopmapr' => $jumlahwopmapr,
                'jumlahwopmclosedapr' => $jumlahwopmclosedapr,
                'pmcomplianceaprfix' => $pmcomplianceaprfix,
                'jumlahwopmmay' => $jumlahwopmmay,
                'jumlahwopmclosedmay' => $jumlahwopmclosedmay,
                'pmcompliancemayfix' => $pmcompliancemayfix,
                'jumlahwopmjun' => $jumlahwopmjun,
                'jumlahwopmclosedjun' => $jumlahwopmclosedjun,
                'pmcompliancejunfix' => $pmcompliancejunfix,
                'jumlahwopmjul' => $jumlahwopmjul,
                'jumlahwopmclosedjul' => $jumlahwopmclosedjul,
                'pmcompliancejulfix' => $pmcompliancejulfix,
                'jumlahwopmaug' => $jumlahwopmaug,
                'jumlahwopmclosedaug' => $jumlahwopmclosedaug,
                'pmcomplianceaugfix' => $pmcomplianceaugfix,
                'jumlahwopmsep' => $jumlahwopmsep,
                'jumlahwopmclosedsep' => $jumlahwopmclosedsep,
                'pmcompliancesepfix' => $pmcompliancesepfix,
                'jumlahwopmoct' => $jumlahwopmoct,
                'jumlahwopmclosedoct' => $jumlahwopmclosedoct,
                'pmcomplianceoctfix' => $pmcomplianceoctfix,
                'jumlahwopmnov' => $jumlahwopmnov,
                'jumlahwopmclosednov' => $jumlahwopmclosednov,
                'pmcompliancenovfix' => $pmcompliancenovfix,
                'jumlahwopmdes' => $jumlahwopmdes,
                'jumlahwopmcloseddes' => $jumlahwopmcloseddes,
                'pmcompliancedesfix' => $pmcompliancedesfix,
                'totalkpifix' => $totalkpifix,
                'sevenyearagowopm' => $sevenyearagowopm,
                'sixyearagowopm' => $sixyearagowopm,
                'fiveyearagowopm' => $fiveyearagowopm,
                'fouryearagowopm' => $fouryearagowopm,
                'threeyearagowopm' => $threeyearagowopm,
                'twoyearagowopm' => $twoyearagowopm,
                'oneyearagowopm' => $oneyearagowopm,
                'sevenyearagowopmclosed' => $sevenyearagowopmclosed,
                'sixyearagowopmclosed' => $sixyearagowopmclosed,
                'fiveyearagowopmclosed' => $fiveyearagowopmclosed,
                'fouryearagowopmclosed' => $fouryearagowopmclosed,
                'threeyearagowopmclosed' => $threeyearagowopmclosed,
                'twoyearagowopmclosed' => $twoyearagowopmclosed,
                'oneyearagowopmclosed' => $oneyearagowopmclosed,
                'nowyearagowopmclosed' => $nowyearagowopmclosed,
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
                'option' => $option,
                'namaunit' => $namaunit,
                'tablepmnotcomply' => $tablepmnotcomply,
            ]
        );
    }

    public function ReactiveWork(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $option = 'TELECT';
        $namaunit = 'Listrik 1-2';

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TELECT') {
                $namaunit = 'Listrik 1-2';
            }
            if ($request->bidang == 'TELECT3') {
                $namaunit = 'Listrik 3-4';
            }
            if ($request->bidang == 'TELECT5') {
                $namaunit = 'Listrik 5';
            }

            $jumlahwocryear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'],
                    ['msf623.creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwocrjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaljan = $jumlahwonotcrpmjan + $jumlahwopmclosedjan;

            if ($totalwotacticaljan < 1) {
                $jumlahwocrjan = 0;
                $totalwotacticaljan = 0.01;
            }

            $reactiveworkjan = ($jumlahwocrjan / $totalwotacticaljan) * 100;
            $reactiveworkjanfix = number_format((float)$reactiveworkjan, 2, '.', '');

            $jumlahwocrfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalfeb = $jumlahwonotcrpmfeb + $jumlahwopmclosedfeb;

            if ($totalwotacticalfeb < 1) {
                $jumlahwocrfeb = 0;
                $totalwotacticalfeb = 0.01;
            }

            $reactiveworkfeb = ($jumlahwocrfeb / $totalwotacticalfeb) * 100;
            $reactiveworkfebfix = number_format((float)$reactiveworkfeb, 2, '.', '');

            $jumlahwocrmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalmar = $jumlahwonotcrpmmar + $jumlahwopmclosedmar;

            if ($totalwotacticalmar < 0) {
                $jumlahwocrmar = 0;
                $totalwotacticalmar = 0.01;
            }

            $reactiveworkmar = ($jumlahwocrmar / $totalwotacticalmar) * 100;
            $reactiveworkmarfix = number_format((float)$reactiveworkmar, 2, '.', '');

            $jumlahwocrapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalapr = $jumlahwonotcrpmapr + $jumlahwopmclosedapr;

            if ($totalwotacticalapr < 1) {
                $jumlahwocrapr = 0;
                $totalwotacticalapr = 0.01;
            }

            $reactiveworkapr = ($jumlahwocrapr / $totalwotacticalapr) * 100;
            $reactiveworkaprfix = number_format((float)$reactiveworkapr, 2, '.', '');

            $jumlahwocrmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalmay = $jumlahwonotcrpmmay + $jumlahwopmclosedmay;

            if ($totalwotacticalmay < 1) {
                $jumlahwocrmay = 0;
                $totalwotacticalmay = 0.01;
            }

            $reactiveworkmay = ($jumlahwocrmay / $totalwotacticalmay) * 100;
            $reactiveworkmayfix = number_format((float)$reactiveworkmay, 2, '.', '');

            $jumlahwocrjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaljun = $jumlahwonotcrpmjun + $jumlahwopmclosedjun;

            if ($totalwotacticaljun < 1) {
                $jumlahwocrjun = 0;
                $totalwotacticaljun = 0.01;
            }

            $reactiveworkjun = ($jumlahwocrjun / $totalwotacticaljun) * 100;
            $reactiveworkjunfix = number_format((float)$reactiveworkjun, 2, '.', '');

            $jumlahwocrjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaljul = $jumlahwonotcrpmjul + $jumlahwopmclosedjul;

            if ($totalwotacticaljul < 1) {
                $jumlahwocrjul = 0;
                $totalwotacticaljul = 0.01;
            }

            $reactiveworkjul = ($jumlahwocrjul / $totalwotacticaljul) * 100;
            $reactiveworkjulfix = number_format((float)$reactiveworkjul, 2, '.', '');

            $jumlahwocraug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalaug = $jumlahwonotcrpmaug + $jumlahwopmclosedaug;

            if ($totalwotacticalaug < 1) {
                $jumlahwocraug = 0;
                $totalwotacticalaug = 0.01;
            }

            $reactiveworkaug = ($jumlahwocraug / $totalwotacticalaug) * 100;
            $reactiveworkaugfix = number_format((float)$reactiveworkaug, 2, '.', '');

            $jumlahwocrsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalsep = $jumlahwonotcrpmsep + $jumlahwopmclosedsep;

            if ($totalwotacticalsep < 1) {
                $jumlahwocrsep = 0;
                $totalwotacticalsep = 0.01;
            }

            $reactiveworksep = ($jumlahwocrsep / $totalwotacticalsep) * 100;
            $reactiveworksepfix = number_format((float)$reactiveworksep, 2, '.', '');

            $jumlahwocroct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaloct = $jumlahwonotcrpmoct + $jumlahwopmclosedoct;

            if ($totalwotacticaloct < 1) {
                $jumlahwocroct = 0;
                $totalwotacticaloct = 0.01;
            }

            $reactiveworkoct = ($jumlahwocroct / $totalwotacticaloct) * 100;
            $reactiveworkoctfix = number_format((float)$reactiveworkoct, 2, '.', '');

            $jumlahwocrnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalnov = $jumlahwonotcrpmnov + $jumlahwopmclosednov;

            if ($totalwotacticalnov < 1) {
                $jumlahwocrnov = 0;
                $totalwotacticalnov = 0.01;
            }

            $reactiveworknov = ($jumlahwocrnov / $totalwotacticalnov) * 100;
            $reactiveworknovfix = number_format((float)$reactiveworknov, 2, '.', '');

            $jumlahwocrdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaldes = $jumlahwonotcrpmdes + $jumlahwopmcloseddes;

            if ($totalwotacticaldes < 1) {
                $jumlahwocrdes = 0;
                $totalwotacticaldes = 0.01;
            }

            $reactiveworkdes = ($jumlahwocrdes / $totalwotacticaldes) * 100;
            $reactiveworkdesfix = number_format((float)$reactiveworkdes, 2, '.', '');

            $year1 = Carbon::now()->subYears(7)->format('Y');
            $year2 = Carbon::now()->subYears(6)->format('Y');
            $year3 = Carbon::now()->subYears(5)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');
            $year5 = Carbon::now()->subYears(3)->format('Y');
            $year6 = Carbon::now()->subYears(2)->format('Y');
            $year7 = Carbon::now()->subYears(1)->format('Y');

            // Total KPI Persen
            $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
                + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
                + $reactiveworknovfix + $reactiveworkdesfix) / 12;

            $totalreactiveworkfix = number_format((float)$totalreactivework, 2, '.', '');

            $totalwotactical = number_format((float)($totalwotacticaljan + $totalwotacticalfeb + $totalwotacticalmar + $totalwotacticalapr +
                $totalwotacticalmay + $totalwotacticaljun + $totalwotacticaljul + $totalwotacticalaug +
                $totalwotacticalsep + $totalwotacticaloct + $totalwotacticalnov + $totalwotacticaldes
            ), 0, '', '');

            $totalwonontactical = ($jumlahwocrjan + $jumlahwocrfeb + $jumlahwocrmar + $jumlahwocrapr +
                $jumlahwocrmay + $jumlahwocrjun + $jumlahwocrjul + $jumlahwocraug +
                $jumlahwocrsep + $jumlahwocroct + $jumlahwocrnov + $jumlahwocrdes
            );

            $fiveyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $fiveyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['creation_date', 'LIKE', '%' . $year3 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $fiveyearagoreactive = ($fiveyearagowocr / $fiveyearagowo) * 100;
            $fiveyearagoreactivefix = number_format((float)$fiveyearagoreactive, 2, '.', '');

            $fouryearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $fouryearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['creation_date', 'LIKE', '%' . $year4 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $fouryearagoreactive = ($fouryearagowocr / $fouryearagowo) * 100;
            $fouryearagoreactivefix = number_format((float)$fouryearagoreactive, 2, '.', '');


            $threeyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $threeyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['creation_date', 'LIKE', '%' . $year5 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $threeyearagoreactive = ($threeyearagowocr / $threeyearagowo) * 100;
            $threeyearagoreactivefix = number_format((float)$threeyearagoreactive, 2, '.', '');

            $twoyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $twoyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['creation_date', 'LIKE', '%' . $year6 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $twoyearagoreactive = ($twoyearagowocr / $twoyearagowo) * 100;
            $twoyearagoreactivefix = number_format((float)$twoyearagoreactive, 2, '.', '');

            $oneyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $oneyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();


            $oneyearagoreactive = ($oneyearagowocr / $oneyearagowo) * 100;
            $oneyearagoreactivefix = number_format((float)$oneyearagoreactive, 2, '.', '');

            $nowyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
        } else {

            $option = 'TELECT';
            $namaunit = 'Listrik 1-2';

            $jumlahwocryear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'],
                    ['msf623.creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwocrjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaljan = $jumlahwonotcrpmjan + $jumlahwopmclosedjan;

            if ($totalwotacticaljan < 1) {
                $jumlahwocrjan = 0;
                $totalwotacticaljan = 0.01;
            }

            $reactiveworkjan = ($jumlahwocrjan / $totalwotacticaljan) * 100;
            $reactiveworkjanfix = number_format((float)$reactiveworkjan, 2, '.', '');

            $jumlahwocrfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalfeb = $jumlahwonotcrpmfeb + $jumlahwopmclosedfeb;

            if ($totalwotacticalfeb < 1) {
                $jumlahwocrfeb = 0;
                $totalwotacticalfeb = 0.01;
            }

            $reactiveworkfeb = ($jumlahwocrfeb / $totalwotacticalfeb) * 100;
            $reactiveworkfebfix = number_format((float)$reactiveworkfeb, 2, '.', '');

            $jumlahwocrmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalmar = $jumlahwonotcrpmmar + $jumlahwopmclosedmar;

            if ($totalwotacticalmar < 1) {
                $jumlahwocrmar = 0;
                $totalwotacticalmar = 0.01;
            }

            $reactiveworkmar = ($jumlahwocrmar / $totalwotacticalmar) * 100;
            $reactiveworkmarfix = number_format((float)$reactiveworkmar, 2, '.', '');

            $jumlahwocrapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalapr = $jumlahwonotcrpmapr + $jumlahwopmclosedapr;

            if ($totalwotacticalapr < 1) {
                $jumlahwocrapr = 0;
                $totalwotacticalapr = 0.01;
            }

            $reactiveworkapr = ($jumlahwocrapr / $totalwotacticalapr) * 100;
            $reactiveworkaprfix = number_format((float)$reactiveworkapr, 2, '.', '');

            $jumlahwocrmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalmay = $jumlahwonotcrpmmay + $jumlahwopmclosedmay;

            if ($totalwotacticalmay < 1) {
                $jumlahwocrmay = 0;
                $totalwotacticalmay = 0.01;
            }

            $reactiveworkmay = ($jumlahwocrmay / $totalwotacticalmay) * 100;
            $reactiveworkmayfix = number_format((float)$reactiveworkmay, 2, '.', '');

            $jumlahwocrjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaljun = $jumlahwonotcrpmjun + $jumlahwopmclosedjun;

            if ($totalwotacticaljun < 1) {
                $jumlahwocrjun = 0;
                $totalwotacticaljun = 0.01;
            }

            $reactiveworkjun = ($jumlahwocrjun / $totalwotacticaljun) * 100;
            $reactiveworkjunfix = number_format((float)$reactiveworkjun, 2, '.', '');

            $jumlahwocrjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaljul = $jumlahwonotcrpmjul + $jumlahwopmclosedjul;

            if ($totalwotacticaljul < 1) {
                $jumlahwocrjul = 0;
                $totalwotacticaljul = 0.01;
            }

            $reactiveworkjul = ($jumlahwocrjul / $totalwotacticaljul) * 100;
            $reactiveworkjulfix = number_format((float)$reactiveworkjul, 2, '.', '');

            $jumlahwocraug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalaug = $jumlahwonotcrpmaug + $jumlahwopmclosedaug;

            if ($totalwotacticalaug < 1) {
                $jumlahwocraug = 0;
                $totalwotacticalaug = 0.01;
            }

            $reactiveworkaug = ($jumlahwocraug / $totalwotacticalaug) * 100;
            $reactiveworkaugfix = number_format((float)$reactiveworkaug, 2, '.', '');

            $jumlahwocrsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orWhere([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf620.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalsep = $jumlahwonotcrpmsep + $jumlahwopmclosedsep;

            if ($totalwotacticalsep < 1) {
                $jumlahwocrsep = 0;
                $totalwotacticalsep = 0.01;
            }

            $reactiveworksep = ($jumlahwocrsep / $totalwotacticalsep) * 100;
            $reactiveworksepfix = number_format((float)$reactiveworksep, 2, '.', '');

            $jumlahwocroct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaloct = $jumlahwonotcrpmoct + $jumlahwopmclosedoct;

            if ($totalwotacticaloct < 1) {
                $jumlahwocroct = 0;
                $totalwotacticaloct = 0.01;
            }

            $reactiveworkoct = ($jumlahwocroct / $totalwotacticaloct) * 100;
            $reactiveworkoctfix = number_format((float)$reactiveworkoct, 2, '.', '');

            $jumlahwocrnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticalnov = $jumlahwonotcrpmnov + $jumlahwopmclosednov;

            if ($totalwotacticalnov < 1) {
                $jumlahwocrnov = 0;
                $totalwotacticalnov = 0.01;
            }

            $reactiveworknov = ($jumlahwocrnov / $totalwotacticalnov) * 100;
            $reactiveworknovfix = number_format((float)$reactiveworknov, 2, '.', '');

            $jumlahwocrdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', 'NOT LIKE', '%CR%'],
                    ['msf620.maint_type', 'NOT LIKE', '%EM%'],
                    ['msf620.maint_type', 'NOT LIKE', '%PM%'],
                    ['msf623.completion_comment', '!=', null],
                    ['msf620.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $totalwotacticaldes = $jumlahwonotcrpmdes + $jumlahwopmcloseddes;

            if ($totalwotacticaldes < 1) {
                $jumlahwocrdes = 0;
                $totalwotacticaldes = 0.01;
            }

            $reactiveworkdes = ($jumlahwocrdes / $totalwotacticaldes) * 100;
            $reactiveworkdesfix = number_format((float)$reactiveworkdes, 2, '.', '');

            $year1 = Carbon::now()->subYears(7)->format('Y');
            $year2 = Carbon::now()->subYears(6)->format('Y');
            $year3 = Carbon::now()->subYears(5)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');
            $year5 = Carbon::now()->subYears(3)->format('Y');
            $year6 = Carbon::now()->subYears(2)->format('Y');
            $year7 = Carbon::now()->subYears(1)->format('Y');

            // Total KPI Persen
            $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
                + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
                + $reactiveworknovfix + $reactiveworkdesfix) / 12;

            $totalreactiveworkfix = number_format((float)$totalreactivework, 2, '.', '');

            $totalwotactical = number_format(
                (float)$totalwotacticaljan + $totalwotacticalfeb + $totalwotacticalmar + $totalwotacticalapr +
                    $totalwotacticalmay + $totalwotacticaljun + $totalwotacticaljul + $totalwotacticalaug +
                    $totalwotacticalsep + $totalwotacticaloct + $totalwotacticalnov + $totalwotacticaldes,
                0,
                '',
                ''
            );

            $totalwonontactical = ($jumlahwocrjan + $jumlahwocrfeb + $jumlahwocrmar + $jumlahwocrapr +
                $jumlahwocrmay + $jumlahwocrjun + $jumlahwocrjul + $jumlahwocraug +
                $jumlahwocrsep + $jumlahwocroct + $jumlahwocrnov + $jumlahwocrdes
            );

            $fiveyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $fiveyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['creation_date', 'LIKE', '%' . $year3 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $fiveyearagoreactive = ($fiveyearagowocr / $fiveyearagowo) * 100;
            $fiveyearagoreactivefix = number_format((float)$fiveyearagoreactive, 2, '.', '');

            $fouryearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $fouryearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['creation_date', 'LIKE', '%' . $year4 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $fouryearagoreactive = ($fouryearagowocr / $fouryearagowo) * 100;
            $fouryearagoreactivefix = number_format((float)$fouryearagoreactive, 2, '.', '');


            $threeyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $threeyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['creation_date', 'LIKE', '%' . $year5 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $threeyearagoreactive = ($threeyearagowocr / $threeyearagowo) * 100;
            $threeyearagoreactivefix = number_format((float)$threeyearagoreactive, 2, '.', '');

            $twoyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $twoyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['creation_date', 'LIKE', '%' . $year6 . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $twoyearagoreactive = ($twoyearagowocr / $twoyearagowo) * 100;
            $twoyearagoreactivefix = number_format((float)$twoyearagoreactive, 2, '.', '');

            $oneyearagowocr = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $oneyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();


            $oneyearagoreactive = ($oneyearagowocr / $oneyearagowo) * 100;
            $oneyearagoreactivefix = number_format((float)$oneyearagoreactive, 2, '.', '');

            $nowyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
        }

        return view(
            'kpi/reactivework',
            [
                'thisyear' => $thisyear,
                'jumlahwocryear' => $jumlahwocryear,
                'jumlahwocrjan' => $jumlahwocrjan,
                'jumlahwojan' => $totalwotacticaljan,
                'reactiveworkjanfix' => $reactiveworkjanfix,
                'jumlahwocrfeb' => $jumlahwocrfeb,
                'jumlahwofeb' => $totalwotacticalfeb,
                'reactiveworkfebfix' => $reactiveworkfebfix,
                'jumlahwocrmar' => $jumlahwocrmar,
                'jumlahwomar' => $totalwotacticalmar,
                'reactiveworkmarfix' => $reactiveworkmarfix,
                'jumlahwocrapr' => $jumlahwocrapr,
                'jumlahwoapr' => $totalwotacticalapr,
                'reactiveworkaprfix' => $reactiveworkaprfix,
                'jumlahwocrmay' => $jumlahwocrmay,
                'jumlahwomay' => $totalwotacticalmay,
                'reactiveworkmayfix' => $reactiveworkmayfix,
                'jumlahwocrjun' => $jumlahwocrjun,
                'jumlahwojun' => $totalwotacticaljun,
                'reactiveworkjunfix' => $reactiveworkjunfix,
                'jumlahwocrjul' => $jumlahwocrjul,
                'jumlahwojul' => $totalwotacticaljul,
                'reactiveworkjulfix' => $reactiveworkjulfix,
                'jumlahwocraug' => $jumlahwocraug,
                'jumlahwoaug' => $totalwotacticalaug,
                'reactiveworkaugfix' => $reactiveworkaugfix,
                'jumlahwocrsep' => $jumlahwocrsep,
                'jumlahwosep' => $totalwotacticalsep,
                'reactiveworksepfix' => $reactiveworksepfix,
                'jumlahwocroct' => $jumlahwocroct,
                'jumlahwooct' => $totalwotacticaloct,
                'reactiveworkoctfix' => $reactiveworkoctfix,
                'jumlahwocrnov' => $jumlahwocrnov,
                'jumlahwonov' => $totalwotacticalnov,
                'reactiveworknovfix' => $reactiveworknovfix,
                'jumlahwocrdes' => $jumlahwocrdes,
                'jumlahwodes' => $totalwotacticaldes,
                'reactiveworkdesfix' => $reactiveworkdesfix,
                'totalreactiveworkfix' => $totalreactiveworkfix,
                'fiveyearagoreactivefix' => $fiveyearagoreactivefix,
                'fouryearagoreactivefix' => $fouryearagoreactivefix,
                'threeyearagoreactivefix' => $threeyearagoreactivefix,
                'twoyearagoreactivefix' => $twoyearagoreactivefix,
                'oneyearagoreactivefix' => $oneyearagoreactivefix,
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
                'option' => $option,
                'namaunit' => $namaunit,
                'totalwotactical' => $totalwotactical,
                'totalwonontactical' => $totalwonontactical,
            ]
        );
    }

    public function Rework()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $jumlahreworktahun = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $tablereworktahun = DB::table('msf620')
            ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->paginate(10);

        $reworkjan = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjan == 0) {
            $jumlahwocrjan = 0.01;
        }

        $rasioreworkjan = ($reworkjan / $jumlahwocrjan) * 100;
        $rasioreworkfixjan = number_format((float)$rasioreworkjan, 2, '.', '');

        $reworkfeb = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrfeb == 0) {
            $jumlahwocrfeb = 0.01;
        }

        $rasioreworkfeb = ($reworkfeb / $jumlahwocrfeb) * 100;
        $rasioreworkfixfeb = number_format((float)$rasioreworkfeb, 2, '.', '');

        $reworkmar = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrmar == 0) {
            $jumlahwocrmar = 0.01;
        }

        $rasioreworkmar = ($reworkmar / $jumlahwocrmar) * 100;
        $rasioreworkfixmar = number_format((float)$rasioreworkmar, 2, '.', '');

        $reworkapr = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrapr == 0) {
            $jumlahwocrapr = 0.01;
        }

        $rasioreworkapr = ($reworkapr / $jumlahwocrapr) * 100;
        $rasioreworkfixapr = number_format((float)$rasioreworkapr, 2, '.', '');

        $reworkmay = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrmay == 0) {
            $jumlahwocrmay = 0.01;
        }

        $rasioreworkmay = ($reworkmay / $jumlahwocrmay) * 100;
        $rasioreworkfixmay = number_format((float)$rasioreworkmay, 2, '.', '');

        $reworkjun = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjun == 0) {
            $jumlahwocrjun = 0.01;
        }

        $rasioreworkjun = ($reworkjun / $jumlahwocrjun) * 100;
        $rasioreworkfixjun = number_format((float)$rasioreworkjun, 2, '.', '');

        $reworkjul = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjul == 0) {
            $jumlahwocrjul = 0.01;
        }

        $rasioreworkjul = ($reworkjul / $jumlahwocrjul) * 100;
        $rasioreworkfixjul = number_format((float)$rasioreworkjul, 2, '.', '');

        $reworkaug = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocraug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocraug == 0) {
            $jumlahwocraug = 0.01;
        }

        $rasioreworkaug = ($reworkaug / $jumlahwocraug) * 100;
        $rasioreworkfixaug = number_format((float)$rasioreworkaug, 2, '.', '');

        $reworksep = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrsep == 0) {
            $jumlahwocrsep = 0.01;
        }

        $rasioreworksep = ($reworksep / $jumlahwocrsep) * 100;
        $rasioreworkfixsep = number_format((float)$rasioreworksep, 2, '.', '');

        $reworkoct = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocroct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocroct == 0) {
            $jumlahwocroct = 0.01;
        }

        $rasioreworkoct = ($reworkoct / $jumlahwocroct) * 100;
        $rasioreworkfixoct = number_format((float)$rasioreworkoct, 2, '.', '');

        $reworknov = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrnov == 0) {
            $jumlahwocrnov = 0.01;
        }

        $rasioreworknov = ($reworknov / $jumlahwocrnov) * 100;
        $rasioreworkfixnov = number_format((float)$rasioreworknov, 2, '.', '');

        $reworkdes = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrdes == 0) {
            $jumlahwocrdes = 0.01;
        }

        $rasioreworkdes = ($reworkdes / $jumlahwocrdes) * 100;
        $rasioreworkfixdes = number_format((float)$rasioreworkdes, 2, '.', '');

        // Total KPI Rework
        $totalrework = ($rasioreworkfixjan + $rasioreworkfixfeb + $rasioreworkfixmar +
            $rasioreworkfixapr + $rasioreworkfixmay + $rasioreworkfixjun +
            $rasioreworkfixjul + $rasioreworkfixaug + $rasioreworkfixsep +
            $rasioreworkfixoct + $rasioreworkfixnov + $rasioreworkfixdes
        ) / 12;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $reworkfiveyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $fiveyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework5 = ($reworkfiveyearago / $fiveyearagowocrdes) * 100;
        $rasioreworkfix5 = number_format((float)$rasiorework5, 2, '.', '');

        $reworkfouryearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $fouryearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework4 = ($reworkfouryearago / $fouryearagowocrdes) * 100;
        $rasioreworkfix4 = number_format((float)$rasiorework4, 2, '.', '');

        $reworkthreeyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $threeyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework3 = ($reworkthreeyearago / $threeyearagowocrdes) * 100;
        $rasioreworkfix3 = number_format((float)$rasiorework3, 2, '.', '');

        $reworktwoyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $twoyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework2 = ($reworktwoyearago / $twoyearagowocrdes) * 100;
        $rasioreworkfix2 = number_format((float)$rasiorework2, 2, '.', '');

        $reworkoneyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $oneyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework1 = ($reworkoneyearago / $oneyearagowocrdes) * 100;
        $rasioreworkfix1 = number_format((float)$rasiorework1, 2, '.', '');

        return view(
            'kpi/rework',
            [
                'jumlahreworktahun' => $jumlahreworktahun,
                'rasioreworkfixjan' => $rasioreworkfixjan,
                'rasioreworkfixfeb' => $rasioreworkfixfeb,
                'rasioreworkfixmar' => $rasioreworkfixmar,
                'rasioreworkfixapr' => $rasioreworkfixapr,
                'rasioreworkfixmay' => $rasioreworkfixmay,
                'rasioreworkfixjun' => $rasioreworkfixjun,
                'rasioreworkfixjul' => $rasioreworkfixjul,
                'rasioreworkfixaug' => $rasioreworkfixaug,
                'rasioreworkfixsep' => $rasioreworkfixsep,
                'rasioreworkfixoct' => $rasioreworkfixoct,
                'rasioreworkfixnov' => $rasioreworkfixnov,
                'rasioreworkfixdes' => $rasioreworkfixdes,
                'jumlahwocrjan' => $jumlahwocrjan,
                'jumlahwocrfeb' => $jumlahwocrfeb,
                'jumlahwocrmar' => $jumlahwocrmar,
                'jumlahwocrapr' => $jumlahwocrapr,
                'jumlahwocrmay' => $jumlahwocrmay,
                'jumlahwocrjun' => $jumlahwocrjun,
                'jumlahwocrjul' => $jumlahwocrjul,
                'jumlahwocraug' => $jumlahwocraug,
                'jumlahwocrsep' => $jumlahwocrsep,
                'jumlahwocroct' => $jumlahwocroct,
                'jumlahwocrnov' => $jumlahwocrnov,
                'jumlahwocrdes' => $jumlahwocrdes,
                'reworkjan' => $reworkjan,
                'reworkfeb' => $reworkfeb,
                'reworkmar' => $reworkmar,
                'reworkapr' => $reworkapr,
                'reworkmay' => $reworkmay,
                'reworkjun' => $reworkjun,
                'reworkjul' => $reworkjul,
                'reworkaug' => $reworkaug,
                'reworksep' => $reworksep,
                'reworkoct' => $reworkoct,
                'reworknov' => $reworknov,
                'reworkdes' => $reworkdes,
                'totalreworkfix' => $totalreworkfix,
                'thisyear' => $thisyear,
                'tablereworktahun' => $tablereworktahun,

                'rasioreworkfix5' => $rasioreworkfix5,
                'rasioreworkfix4' => $rasioreworkfix4,
                'rasioreworkfix3' => $rasioreworkfix3,
                'rasioreworkfix2' => $rasioreworkfix2,
                'rasioreworkfix1' => $rasioreworkfix1,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
            ]
        );
    }

    public function PMCompliance34()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $jumlahwopmyear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmjan == 0) {
            $jumlahwopmjan = 0.001;
        }

        $pmcompliancejan = ($jumlahwopmclosedjan / $jumlahwopmjan) * 100;
        $pmcompliancejanfix = number_format((float)$pmcompliancejan, 2, '.', '');

        $jumlahwopmfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmfeb == 0) {
            $jumlahwopmfeb = 0.001;
        }

        $pmcompliancefeb = ($jumlahwopmclosedfeb / $jumlahwopmfeb) * 100;
        $pmcompliancefebfix = number_format((float)$pmcompliancefeb, 2, '.', '');

        $jumlahwopmmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmmar == 0) {
            $jumlahwopmmar = 0.001;
        }

        $pmcompliancemar = ($jumlahwopmclosedmar / $jumlahwopmmar) * 100;
        $pmcompliancemarfix = number_format((float)$pmcompliancemar, 2, '.', '');

        $jumlahwopmapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmapr == 0) {
            $jumlahwopmapr = 0.001;
        }

        $pmcomplianceapr = ($jumlahwopmclosedapr / $jumlahwopmapr) * 100;
        $pmcomplianceaprfix = number_format((float)$pmcomplianceapr, 2, '.', '');

        $jumlahwopmmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmmay == 0) {
            $jumlahwopmmay = 0.001;
        }

        $pmcompliancemay = ($jumlahwopmclosedmay / $jumlahwopmmay) * 100;
        $pmcompliancemayfix = number_format((float)$pmcompliancemay, 2, '.', '');

        $jumlahwopmjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmjun == 0) {
            $jumlahwopmjun = 0.001;
        }

        $pmcompliancejun = ($jumlahwopmclosedjun / $jumlahwopmjun) * 100;
        $pmcompliancejunfix = number_format((float)$pmcompliancejun, 2, '.', '');

        $jumlahwopmjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmjul == 0) {
            $jumlahwopmjul = 0.001;
        }
        $pmcompliancejul = ($jumlahwopmclosedjul / $jumlahwopmjul) * 100;
        $pmcompliancejulfix = number_format((float)$pmcompliancejul, 2, '.', '');

        $jumlahwopmaug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedaug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmaug == 0) {
            $jumlahwopmaug = 0.001;
        }
        $pmcomplianceaug = ($jumlahwopmclosedaug / $jumlahwopmaug) * 100;
        $pmcomplianceaugfix = number_format((float)$pmcomplianceaug, 2, '.', '');

        $jumlahwopmsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmsep == 0) {
            $jumlahwopmsep = 0.001;
        }
        $pmcompliancesep = ($jumlahwopmclosedsep / $jumlahwopmsep) * 100;
        $pmcompliancesepfix = number_format((float)$pmcompliancesep, 2, '.', '');

        $jumlahwopmoct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedoct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmoct == 0) {
            $jumlahwopmoct = 0.001;
        }

        $pmcomplianceoct = ($jumlahwopmclosedoct / $jumlahwopmoct) * 100;
        $pmcomplianceoctfix = number_format((float)$pmcomplianceoct, 2, '.', '');

        $jumlahwopmnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosednov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmnov == 0) {
            $jumlahwopmnov = 0.001;
        }

        $pmcompliancenov = ($jumlahwopmclosednov / $jumlahwopmnov) * 100;
        $pmcompliancenovfix = number_format((float)$pmcompliancenov, 2, '.', '');

        $jumlahwopmdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmcloseddes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmdes == 0) {
            $jumlahwopmdes = 0.001;
        }

        $pmcompliancedes = ($jumlahwopmcloseddes / $jumlahwopmdes) * 100;
        $pmcompliancedesfix = number_format((float)$pmcompliancedes, 2, '.', '');

        // Total KPI Persen
        $totalkpi = ($pmcompliancejanfix + $pmcompliancefebfix + $pmcompliancemarfix + $pmcomplianceaprfix + $pmcompliancemayfix
            + $pmcompliancejunfix + $pmcompliancejulfix + $pmcomplianceaugfix + $pmcompliancesepfix + $pmcomplianceoctfix
            + $pmcompliancenovfix + $pmcompliancedesfix) / 12;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

        $sevenyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year1 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $sevenyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year1 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $sixyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year2 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $sixyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year2 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $fiveyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fiveyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $fouryearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fouryearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $threeyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $threeyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $twoyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $twoyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $oneyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $oneyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $nowyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        return view(
            'kpi/pmcompliance34',
            [
                'thisyear' => $thisyear,
                'jumlahwopmyear' => $jumlahwopmyear,
                'jumlahwopmjan' => $jumlahwopmjan,
                'jumlahwopmclosedjan' => $jumlahwopmclosedjan,
                'pmcompliancejanfix' => $pmcompliancejanfix,
                'jumlahwopmfeb' => $jumlahwopmfeb,
                'jumlahwopmclosedfeb' => $jumlahwopmclosedfeb,
                'pmcompliancefebfix' => $pmcompliancefebfix,
                'jumlahwopmmar' => $jumlahwopmmar,
                'jumlahwopmclosedmar' => $jumlahwopmclosedmar,
                'pmcompliancemarfix' => $pmcompliancemarfix,
                'jumlahwopmapr' => $jumlahwopmapr,
                'jumlahwopmclosedapr' => $jumlahwopmclosedapr,
                'pmcomplianceaprfix' => $pmcomplianceaprfix,
                'jumlahwopmmay' => $jumlahwopmmay,
                'jumlahwopmclosedmay' => $jumlahwopmclosedmay,
                'pmcompliancemayfix' => $pmcompliancemayfix,
                'jumlahwopmjun' => $jumlahwopmjun,
                'jumlahwopmclosedjun' => $jumlahwopmclosedjun,
                'pmcompliancejunfix' => $pmcompliancejunfix,
                'jumlahwopmjul' => $jumlahwopmjul,
                'jumlahwopmclosedjul' => $jumlahwopmclosedjul,
                'pmcompliancejulfix' => $pmcompliancejulfix,
                'jumlahwopmaug' => $jumlahwopmaug,
                'jumlahwopmclosedaug' => $jumlahwopmclosedaug,
                'pmcomplianceaugfix' => $pmcomplianceaugfix,
                'jumlahwopmsep' => $jumlahwopmsep,
                'jumlahwopmclosedsep' => $jumlahwopmclosedsep,
                'pmcompliancesepfix' => $pmcompliancesepfix,
                'jumlahwopmoct' => $jumlahwopmoct,
                'jumlahwopmclosedoct' => $jumlahwopmclosedoct,
                'pmcomplianceoctfix' => $pmcomplianceoctfix,
                'jumlahwopmnov' => $jumlahwopmnov,
                'jumlahwopmclosednov' => $jumlahwopmclosednov,
                'pmcompliancenovfix' => $pmcompliancenovfix,
                'jumlahwopmdes' => $jumlahwopmdes,
                'jumlahwopmcloseddes' => $jumlahwopmcloseddes,
                'pmcompliancedesfix' => $pmcompliancedesfix,
                'totalkpifix' => $totalkpifix,
                'sevenyearagowopm' => $sevenyearagowopm,
                'sixyearagowopm' => $sixyearagowopm,
                'fiveyearagowopm' => $fiveyearagowopm,
                'fouryearagowopm' => $fouryearagowopm,
                'threeyearagowopm' => $threeyearagowopm,
                'twoyearagowopm' => $twoyearagowopm,
                'oneyearagowopm' => $oneyearagowopm,
                'sevenyearagowopmclosed' => $sevenyearagowopmclosed,
                'sixyearagowopmclosed' => $sixyearagowopmclosed,
                'fiveyearagowopmclosed' => $fiveyearagowopmclosed,
                'fouryearagowopmclosed' => $fouryearagowopmclosed,
                'threeyearagowopmclosed' => $threeyearagowopmclosed,
                'twoyearagowopmclosed' => $twoyearagowopmclosed,
                'oneyearagowopmclosed' => $oneyearagowopmclosed,
                'nowyearagowopmclosed' => $nowyearagowopmclosed,
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
            ]
        );
    }

    public function PMCompliance5()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $jumlahwopmyear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmjan == 0) {
            $jumlahwopmjan = 0.001;
        }

        $pmcompliancejan = ($jumlahwopmclosedjan / $jumlahwopmjan) * 100;
        $pmcompliancejanfix = number_format((float)$pmcompliancejan, 2, '.', '');

        $jumlahwopmfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmfeb == 0) {
            $jumlahwopmfeb = 0.001;
        }

        $pmcompliancefeb = ($jumlahwopmclosedfeb / $jumlahwopmfeb) * 100;
        $pmcompliancefebfix = number_format((float)$pmcompliancefeb, 2, '.', '');

        $jumlahwopmmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmmar == 0) {
            $jumlahwopmmar = 0.001;
        }

        $pmcompliancemar = ($jumlahwopmclosedmar / $jumlahwopmmar) * 100;
        $pmcompliancemarfix = number_format((float)$pmcompliancemar, 2, '.', '');

        $jumlahwopmapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmapr == 0) {
            $jumlahwopmapr = 0.001;
        }

        $pmcomplianceapr = ($jumlahwopmclosedapr / $jumlahwopmapr) * 100;
        $pmcomplianceaprfix = number_format((float)$pmcomplianceapr, 2, '.', '');

        $jumlahwopmmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmmay == 0) {
            $jumlahwopmmay = 0.001;
        }

        $pmcompliancemay = ($jumlahwopmclosedmay / $jumlahwopmmay) * 100;
        $pmcompliancemayfix = number_format((float)$pmcompliancemay, 2, '.', '');

        $jumlahwopmjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmjun == 0) {
            $jumlahwopmjun = 0.001;
        }

        $pmcompliancejun = ($jumlahwopmclosedjun / $jumlahwopmjun) * 100;
        $pmcompliancejunfix = number_format((float)$pmcompliancejun, 2, '.', '');

        $jumlahwopmjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmjul == 0) {
            $jumlahwopmjul = 0.001;
        }
        $pmcompliancejul = ($jumlahwopmclosedjul / $jumlahwopmjul) * 100;
        $pmcompliancejulfix = number_format((float)$pmcompliancejul, 2, '.', '');

        $jumlahwopmaug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedaug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmaug == 0) {
            $jumlahwopmaug = 0.001;
        }
        $pmcomplianceaug = ($jumlahwopmclosedaug / $jumlahwopmaug) * 100;
        $pmcomplianceaugfix = number_format((float)$pmcomplianceaug, 2, '.', '');

        $jumlahwopmsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmsep == 0) {
            $jumlahwopmsep = 0.001;
        }
        $pmcompliancesep = ($jumlahwopmclosedsep / $jumlahwopmsep) * 100;
        $pmcompliancesepfix = number_format((float)$pmcompliancesep, 2, '.', '');

        $jumlahwopmoct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosedoct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmoct == 0) {
            $jumlahwopmoct = 0.001;
        }

        $pmcomplianceoct = ($jumlahwopmclosedoct / $jumlahwopmoct) * 100;
        $pmcomplianceoctfix = number_format((float)$pmcomplianceoct, 2, '.', '');

        $jumlahwopmnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmclosednov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmnov == 0) {
            $jumlahwopmnov = 0.001;
        }

        $pmcompliancenov = ($jumlahwopmclosednov / $jumlahwopmnov) * 100;
        $pmcompliancenovfix = number_format((float)$pmcompliancenov, 2, '.', '');

        $jumlahwopmdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopmcloseddes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwopmdes == 0) {
            $jumlahwopmdes = 0.001;
        }

        $pmcompliancedes = ($jumlahwopmcloseddes / $jumlahwopmdes) * 100;
        $pmcompliancedesfix = number_format((float)$pmcompliancedes, 2, '.', '');

        // Total KPI Persen
        $totalkpi = ($pmcompliancejanfix + $pmcompliancefebfix + $pmcompliancemarfix + $pmcomplianceaprfix + $pmcompliancemayfix
            + $pmcompliancejunfix + $pmcompliancejulfix + $pmcomplianceaugfix + $pmcompliancesepfix + $pmcomplianceoctfix
            + $pmcompliancenovfix + $pmcompliancedesfix) / 12;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

        $sevenyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year1 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $sevenyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year1 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $sixyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year2 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $sixyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year2 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $fiveyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fiveyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $fouryearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fouryearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $threeyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $threeyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $twoyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $twoyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $oneyearagowopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $oneyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT5'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $nowyearagowopmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECTGU'],
                ['maint_type', '=', 'PM'],
                ['wo_status_m', '=', 'C'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        return view(
            'kpi/pmcompliance5',
            [
                'thisyear' => $thisyear,
                'jumlahwopmyear' => $jumlahwopmyear,
                'jumlahwopmjan' => $jumlahwopmjan,
                'jumlahwopmclosedjan' => $jumlahwopmclosedjan,
                'pmcompliancejanfix' => $pmcompliancejanfix,
                'jumlahwopmfeb' => $jumlahwopmfeb,
                'jumlahwopmclosedfeb' => $jumlahwopmclosedfeb,
                'pmcompliancefebfix' => $pmcompliancefebfix,
                'jumlahwopmmar' => $jumlahwopmmar,
                'jumlahwopmclosedmar' => $jumlahwopmclosedmar,
                'pmcompliancemarfix' => $pmcompliancemarfix,
                'jumlahwopmapr' => $jumlahwopmapr,
                'jumlahwopmclosedapr' => $jumlahwopmclosedapr,
                'pmcomplianceaprfix' => $pmcomplianceaprfix,
                'jumlahwopmmay' => $jumlahwopmmay,
                'jumlahwopmclosedmay' => $jumlahwopmclosedmay,
                'pmcompliancemayfix' => $pmcompliancemayfix,
                'jumlahwopmjun' => $jumlahwopmjun,
                'jumlahwopmclosedjun' => $jumlahwopmclosedjun,
                'pmcompliancejunfix' => $pmcompliancejunfix,
                'jumlahwopmjul' => $jumlahwopmjul,
                'jumlahwopmclosedjul' => $jumlahwopmclosedjul,
                'pmcompliancejulfix' => $pmcompliancejulfix,
                'jumlahwopmaug' => $jumlahwopmaug,
                'jumlahwopmclosedaug' => $jumlahwopmclosedaug,
                'pmcomplianceaugfix' => $pmcomplianceaugfix,
                'jumlahwopmsep' => $jumlahwopmsep,
                'jumlahwopmclosedsep' => $jumlahwopmclosedsep,
                'pmcompliancesepfix' => $pmcompliancesepfix,
                'jumlahwopmoct' => $jumlahwopmoct,
                'jumlahwopmclosedoct' => $jumlahwopmclosedoct,
                'pmcomplianceoctfix' => $pmcomplianceoctfix,
                'jumlahwopmnov' => $jumlahwopmnov,
                'jumlahwopmclosednov' => $jumlahwopmclosednov,
                'pmcompliancenovfix' => $pmcompliancenovfix,
                'jumlahwopmdes' => $jumlahwopmdes,
                'jumlahwopmcloseddes' => $jumlahwopmcloseddes,
                'pmcompliancedesfix' => $pmcompliancedesfix,
                'totalkpifix' => $totalkpifix,
                'sevenyearagowopm' => $sevenyearagowopm,
                'sixyearagowopm' => $sixyearagowopm,
                'fiveyearagowopm' => $fiveyearagowopm,
                'fouryearagowopm' => $fouryearagowopm,
                'threeyearagowopm' => $threeyearagowopm,
                'twoyearagowopm' => $twoyearagowopm,
                'oneyearagowopm' => $oneyearagowopm,
                'sevenyearagowopmclosed' => $sevenyearagowopmclosed,
                'sixyearagowopmclosed' => $sixyearagowopmclosed,
                'fiveyearagowopmclosed' => $fiveyearagowopmclosed,
                'fouryearagowopmclosed' => $fouryearagowopmclosed,
                'threeyearagowopmclosed' => $threeyearagowopmclosed,
                'twoyearagowopmclosed' => $twoyearagowopmclosed,
                'oneyearagowopmclosed' => $oneyearagowopmclosed,
                'nowyearagowopmclosed' => $nowyearagowopmclosed,
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
            ]
        );
    }

    public function ReactiveWork34()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $jumlahwocryear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwocrjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwojan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $jan . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwojan == 0) {
            $jumlahwojan = 0.01;
        }

        $reactiveworkjan = ($jumlahwocrjan / $jumlahwojan) * 100;
        $reactiveworkjanfix = number_format((float)$reactiveworkjan, 2, '.', '');

        $jumlahwocrfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwofeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $feb . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwofeb == 0) {
            $jumlahwofeb = 0.01;
        }

        $reactiveworkfeb = ($jumlahwocrfeb / $jumlahwofeb) * 100;
        $reactiveworkfebfix = number_format((float)$reactiveworkfeb, 2, '.', '');

        $jumlahwocrmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwomar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $mar . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwomar == 0) {
            $jumlahwomar = 0.01;
        }

        $reactiveworkmar = ($jumlahwocrmar / $jumlahwomar) * 100;
        $reactiveworkmarfix = number_format((float)$reactiveworkmar, 2, '.', '');

        $jumlahwocrapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $apr . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwoapr == 0) {
            $jumlahwoapr = 0.01;
        }

        $reactiveworkapr = ($jumlahwocrapr / $jumlahwoapr) * 100;
        $reactiveworkaprfix = number_format((float)$reactiveworkapr, 2, '.', '');

        $jumlahwocrmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwomay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $may . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwomay == 0) {
            $jumlahwomay = 0.01;
        }

        $reactiveworkmay = ($jumlahwocrmay / $jumlahwomay) * 100;
        $reactiveworkmayfix = number_format((float)$reactiveworkmay, 2, '.', '');

        $jumlahwocrjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwojun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $jun . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwojun == 0) {
            $jumlahwojun = 0.01;
        }

        $reactiveworkjun = ($jumlahwocrjun / $jumlahwojun) * 100;
        $reactiveworkjunfix = number_format((float)$reactiveworkjun, 2, '.', '');

        $jumlahwocrjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwojul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $jul . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwojul == 0) {
            $jumlahwojul = 0.01;
        }

        $reactiveworkjul = ($jumlahwocrjul / $jumlahwojul) * 100;
        $reactiveworkjulfix = number_format((float)$reactiveworkjul, 2, '.', '');

        $jumlahwocraug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoaug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $aug . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwoaug == 0) {
            $jumlahwoaug = 0.01;
        }

        $reactiveworkaug = ($jumlahwocraug / $jumlahwoaug) * 100;
        $reactiveworkaugfix = number_format((float)$reactiveworkaug, 2, '.', '');

        $jumlahwocrsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwosep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $sep . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwosep == 0) {
            $jumlahwosep = 0.01;
        }

        $reactiveworksep = ($jumlahwocrsep / $jumlahwosep) * 100;
        $reactiveworksepfix = number_format((float)$reactiveworksep, 2, '.', '');

        $jumlahwocroct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwooct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $oct . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwooct == 0) {
            $jumlahwooct = 0.01;
        }

        $reactiveworkoct = ($jumlahwocroct / $jumlahwooct) * 100;
        $reactiveworkoctfix = number_format((float)$reactiveworkoct, 2, '.', '');

        $jumlahwocrnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwonov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $nov . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwonov == 0) {
            $jumlahwonov = 0.01;
        }

        $reactiveworknov = ($jumlahwocrnov / $jumlahwonov) * 100;
        $reactiveworknovfix = number_format((float)$reactiveworknov, 2, '.', '');

        $jumlahwocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwodes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $des . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwodes == 0) {
            $jumlahwodes = 0.01;
        }

        $reactiveworkdes = ($jumlahwocrdes / $jumlahwodes) * 100;
        $reactiveworkdesfix = number_format((float)$reactiveworkdes, 2, '.', '');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / 12;

        $totalreactiveworkfix = number_format((float)$totalreactivework, 2, '.', '');

        $fiveyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fiveyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $year3 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $fiveyearagoreactive = ($fiveyearagowocr / $fiveyearagowo) * 100;
        $fiveyearagoreactivefix = number_format((float)$fiveyearagoreactive, 2, '.', '');

        $fouryearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fouryearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $year4 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $fouryearagoreactive = ($fouryearagowocr / $fouryearagowo) * 100;
        $fouryearagoreactivefix = number_format((float)$fouryearagoreactive, 2, '.', '');


        $threeyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $threeyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $year5 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $threeyearagoreactive = ($threeyearagowocr / $threeyearagowo) * 100;
        $threeyearagoreactivefix = number_format((float)$threeyearagoreactive, 2, '.', '');

        $twoyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $twoyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $year6 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $twoyearagoreactive = ($twoyearagowocr / $twoyearagowo) * 100;
        $twoyearagoreactivefix = number_format((float)$twoyearagoreactive, 2, '.', '');

        $oneyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $oneyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $year7 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();


        $oneyearagoreactive = ($oneyearagowocr / $oneyearagowo) * 100;
        $oneyearagoreactivefix = number_format((float)$oneyearagoreactive, 2, '.', '');

        $nowyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        return view(
            'kpi/reactivework34',
            [
                'thisyear' => $thisyear,
                'jumlahwocryear' => $jumlahwocryear,
                'jumlahwocrjan' => $jumlahwocrjan,
                'jumlahwojan' => $jumlahwojan,
                'reactiveworkjanfix' => $reactiveworkjanfix,
                'jumlahwocrfeb' => $jumlahwocrfeb,
                'jumlahwofeb' => $jumlahwofeb,
                'reactiveworkfebfix' => $reactiveworkfebfix,
                'jumlahwocrmar' => $jumlahwocrmar,
                'jumlahwomar' => $jumlahwomar,
                'reactiveworkmarfix' => $reactiveworkmarfix,
                'jumlahwocrapr' => $jumlahwocrapr,
                'jumlahwoapr' => $jumlahwoapr,
                'reactiveworkaprfix' => $reactiveworkaprfix,
                'jumlahwocrmay' => $jumlahwocrmay,
                'jumlahwomay' => $jumlahwomay,
                'reactiveworkmayfix' => $reactiveworkmayfix,
                'jumlahwocrjun' => $jumlahwocrjun,
                'jumlahwojun' => $jumlahwojun,
                'reactiveworkjunfix' => $reactiveworkjunfix,
                'jumlahwocrjul' => $jumlahwocrjul,
                'jumlahwojul' => $jumlahwojul,
                'reactiveworkjulfix' => $reactiveworkjulfix,
                'jumlahwocraug' => $jumlahwocraug,
                'jumlahwoaug' => $jumlahwoaug,
                'reactiveworkaugfix' => $reactiveworkaugfix,
                'jumlahwocrsep' => $jumlahwocrsep,
                'jumlahwosep' => $jumlahwosep,
                'reactiveworksepfix' => $reactiveworksepfix,
                'jumlahwocroct' => $jumlahwocroct,
                'jumlahwooct' => $jumlahwooct,
                'reactiveworkoctfix' => $reactiveworkoctfix,
                'jumlahwocrnov' => $jumlahwocrnov,
                'jumlahwonov' => $jumlahwonov,
                'reactiveworknovfix' => $reactiveworknovfix,
                'jumlahwocrdes' => $jumlahwocrdes,
                'jumlahwodes' => $jumlahwodes,
                'reactiveworkdesfix' => $reactiveworkdesfix,
                'totalreactiveworkfix' => $totalreactiveworkfix,
                'fiveyearagoreactivefix' => $fiveyearagoreactivefix,
                'fouryearagoreactivefix' => $fouryearagoreactivefix,
                'threeyearagoreactivefix' => $threeyearagoreactivefix,
                'twoyearagoreactivefix' => $twoyearagoreactivefix,
                'oneyearagoreactivefix' => $oneyearagoreactivefix,
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
            ]
        );
    }

    public function ReactiveWork5()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $jumlahwocryear = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwocrjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwojan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $jan . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwojan == 0) {
            $jumlahwojan = 0.01;
        }

        $reactiveworkjan = ($jumlahwocrjan / $jumlahwojan) * 100;
        $reactiveworkjanfix = number_format((float)$reactiveworkjan, 2, '.', '');

        $jumlahwocrfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwofeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $feb . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwofeb == 0) {
            $jumlahwofeb = 0.01;
        }

        $reactiveworkfeb = ($jumlahwocrfeb / $jumlahwofeb) * 100;
        $reactiveworkfebfix = number_format((float)$reactiveworkfeb, 2, '.', '');

        $jumlahwocrmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwomar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $mar . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwomar == 0) {
            $jumlahwomar = 0.01;
        }

        $reactiveworkmar = ($jumlahwocrmar / $jumlahwomar) * 100;
        $reactiveworkmarfix = number_format((float)$reactiveworkmar, 2, '.', '');

        $jumlahwocrapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $apr . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwoapr == 0) {
            $jumlahwoapr = 0.01;
        }

        $reactiveworkapr = ($jumlahwocrapr / $jumlahwoapr) * 100;
        $reactiveworkaprfix = number_format((float)$reactiveworkapr, 2, '.', '');

        $jumlahwocrmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwomay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $may . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwomay == 0) {
            $jumlahwomay = 0.01;
        }

        $reactiveworkmay = ($jumlahwocrmay / $jumlahwomay) * 100;
        $reactiveworkmayfix = number_format((float)$reactiveworkmay, 2, '.', '');

        $jumlahwocrjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwojun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $jun . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwojun == 0) {
            $jumlahwojun = 0.01;
        }

        $reactiveworkjun = ($jumlahwocrjun / $jumlahwojun) * 100;
        $reactiveworkjunfix = number_format((float)$reactiveworkjun, 2, '.', '');

        $jumlahwocrjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwojul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $jul . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwojul == 0) {
            $jumlahwojul = 0.01;
        }

        $reactiveworkjul = ($jumlahwocrjul / $jumlahwojul) * 100;
        $reactiveworkjulfix = number_format((float)$reactiveworkjul, 2, '.', '');

        $jumlahwocraug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoaug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $aug . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwoaug == 0) {
            $jumlahwoaug = 0.01;
        }

        $reactiveworkaug = ($jumlahwocraug / $jumlahwoaug) * 100;
        $reactiveworkaugfix = number_format((float)$reactiveworkaug, 2, '.', '');

        $jumlahwocrsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwosep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $sep . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwosep == 0) {
            $jumlahwosep = 0.01;
        }

        $reactiveworksep = ($jumlahwocrsep / $jumlahwosep) * 100;
        $reactiveworksepfix = number_format((float)$reactiveworksep, 2, '.', '');

        $jumlahwocroct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwooct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $oct . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwooct == 0) {
            $jumlahwooct = 0.01;
        }

        $reactiveworkoct = ($jumlahwocroct / $jumlahwooct) * 100;
        $reactiveworkoctfix = number_format((float)$reactiveworkoct, 2, '.', '');

        $jumlahwocrnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwonov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $nov . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwonov == 0) {
            $jumlahwonov = 0.01;
        }

        $reactiveworknov = ($jumlahwocrnov / $jumlahwonov) * 100;
        $reactiveworknovfix = number_format((float)$reactiveworknov, 2, '.', '');

        $jumlahwocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwodes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $des . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwodes == 0) {
            $jumlahwodes = 0.01;
        }

        $reactiveworkdes = ($jumlahwocrdes / $jumlahwodes) * 100;
        $reactiveworkdesfix = number_format((float)$reactiveworkdes, 2, '.', '');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / 12;

        $totalreactiveworkfix = number_format((float)$totalreactivework, 2, '.', '');

        $fiveyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fiveyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $year3 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($fiveyearagowo == 0) {
            $fiveyearagowo = 0.0001;
        }

        $fiveyearagoreactive = ($fiveyearagowocr / $fiveyearagowo) * 100;
        $fiveyearagoreactivefix = number_format((float)$fiveyearagoreactive, 2, '.', '');

        $fouryearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $fouryearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $year4 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($fouryearagowo == 0) {
            $fouryearagowo = 0.0001;
        }

        $fouryearagoreactive = ($fouryearagowocr / $fouryearagowo) * 100;
        $fouryearagoreactivefix = number_format((float)$fouryearagoreactive, 2, '.', '');


        $threeyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $threeyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $year5 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($threeyearagowo == 0) {
            $threeyearagowo = 0.0001;
        }

        $threeyearagoreactive = ($threeyearagowocr / $threeyearagowo) * 100;
        $threeyearagoreactivefix = number_format((float)$threeyearagoreactive, 2, '.', '');

        $twoyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $twoyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $year6 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($twoyearagowo == 0) {
            $twoyearagowo = 0.0001;
        }

        $twoyearagoreactive = ($twoyearagowocr / $twoyearagowo) * 100;
        $twoyearagoreactivefix = number_format((float)$twoyearagoreactive, 2, '.', '');

        $oneyearagowocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();
        $oneyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $year7 . '%'],
                ['maint_type', 'NOT LIKE', '%CR%'],
                ['maint_type', 'NOT LIKE', '%EM%'],
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($oneyearagowo == 0) {
            $oneyearagowo = 0.0001;
        }

        $oneyearagoreactive = ($oneyearagowocr / $oneyearagowo) * 100;
        $oneyearagoreactivefix = number_format((float)$oneyearagoreactive, 2, '.', '');

        $nowyearagowo = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        return view(
            'kpi/reactivework5',
            [
                'thisyear' => $thisyear,
                'jumlahwocryear' => $jumlahwocryear,
                'jumlahwocrjan' => $jumlahwocrjan,
                'jumlahwojan' => $jumlahwojan,
                'reactiveworkjanfix' => $reactiveworkjanfix,
                'jumlahwocrfeb' => $jumlahwocrfeb,
                'jumlahwofeb' => $jumlahwofeb,
                'reactiveworkfebfix' => $reactiveworkfebfix,
                'jumlahwocrmar' => $jumlahwocrmar,
                'jumlahwomar' => $jumlahwomar,
                'reactiveworkmarfix' => $reactiveworkmarfix,
                'jumlahwocrapr' => $jumlahwocrapr,
                'jumlahwoapr' => $jumlahwoapr,
                'reactiveworkaprfix' => $reactiveworkaprfix,
                'jumlahwocrmay' => $jumlahwocrmay,
                'jumlahwomay' => $jumlahwomay,
                'reactiveworkmayfix' => $reactiveworkmayfix,
                'jumlahwocrjun' => $jumlahwocrjun,
                'jumlahwojun' => $jumlahwojun,
                'reactiveworkjunfix' => $reactiveworkjunfix,
                'jumlahwocrjul' => $jumlahwocrjul,
                'jumlahwojul' => $jumlahwojul,
                'reactiveworkjulfix' => $reactiveworkjulfix,
                'jumlahwocraug' => $jumlahwocraug,
                'jumlahwoaug' => $jumlahwoaug,
                'reactiveworkaugfix' => $reactiveworkaugfix,
                'jumlahwocrsep' => $jumlahwocrsep,
                'jumlahwosep' => $jumlahwosep,
                'reactiveworksepfix' => $reactiveworksepfix,
                'jumlahwocroct' => $jumlahwocroct,
                'jumlahwooct' => $jumlahwooct,
                'reactiveworkoctfix' => $reactiveworkoctfix,
                'jumlahwocrnov' => $jumlahwocrnov,
                'jumlahwonov' => $jumlahwonov,
                'reactiveworknovfix' => $reactiveworknovfix,
                'jumlahwocrdes' => $jumlahwocrdes,
                'jumlahwodes' => $jumlahwodes,
                'reactiveworkdesfix' => $reactiveworkdesfix,
                'totalreactiveworkfix' => $totalreactiveworkfix,
                'fiveyearagoreactivefix' => $fiveyearagoreactivefix,
                'fouryearagoreactivefix' => $fouryearagoreactivefix,
                'threeyearagoreactivefix' => $threeyearagoreactivefix,
                'twoyearagoreactivefix' => $twoyearagoreactivefix,
                'oneyearagoreactivefix' => $oneyearagoreactivefix,
                'year1' => $year1,
                'year2' => $year2,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
            ]
        );
    }

    public function Rework34()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $jumlahreworktahun = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $tablereworktahun = DB::table('msf620')
            ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->paginate(10);

        $reworkjan = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjan == 0) {
            $jumlahwocrjan = 0.01;
        }

        $rasioreworkjan = ($reworkjan / $jumlahwocrjan) * 100;
        $rasioreworkfixjan = number_format((float)$rasioreworkjan, 2, '.', '');

        $reworkfeb = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrfeb == 0) {
            $jumlahwocrfeb = 0.01;
        }

        $rasioreworkfeb = ($reworkfeb / $jumlahwocrfeb) * 100;
        $rasioreworkfixfeb = number_format((float)$rasioreworkfeb, 2, '.', '');

        $reworkmar = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrmar == 0) {
            $jumlahwocrmar = 0.01;
        }

        $rasioreworkmar = ($reworkmar / $jumlahwocrmar) * 100;
        $rasioreworkfixmar = number_format((float)$rasioreworkmar, 2, '.', '');

        $reworkapr = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrapr == 0) {
            $jumlahwocrapr = 0.01;
        }

        $rasioreworkapr = ($reworkapr / $jumlahwocrapr) * 100;
        $rasioreworkfixapr = number_format((float)$rasioreworkapr, 2, '.', '');

        $reworkmay = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrmay == 0) {
            $jumlahwocrmay = 0.01;
        }

        $rasioreworkmay = ($reworkmay / $jumlahwocrmay) * 100;
        $rasioreworkfixmay = number_format((float)$rasioreworkmay, 2, '.', '');

        $reworkjun = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjun == 0) {
            $jumlahwocrjun = 0.01;
        }

        $rasioreworkjun = ($reworkjun / $jumlahwocrjun) * 100;
        $rasioreworkfixjun = number_format((float)$rasioreworkjun, 2, '.', '');

        $reworkjul = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjul == 0) {
            $jumlahwocrjul = 0.01;
        }

        $rasioreworkjul = ($reworkjul / $jumlahwocrjul) * 100;
        $rasioreworkfixjul = number_format((float)$rasioreworkjul, 2, '.', '');

        $reworkaug = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocraug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocraug == 0) {
            $jumlahwocraug = 0.01;
        }

        $rasioreworkaug = ($reworkaug / $jumlahwocraug) * 100;
        $rasioreworkfixaug = number_format((float)$rasioreworkaug, 2, '.', '');

        $reworksep = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrsep == 0) {
            $jumlahwocrsep = 0.01;
        }

        $rasioreworksep = ($reworksep / $jumlahwocrsep) * 100;
        $rasioreworkfixsep = number_format((float)$rasioreworksep, 2, '.', '');

        $reworkoct = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocroct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocroct == 0) {
            $jumlahwocroct = 0.01;
        }

        $rasioreworkoct = ($reworkoct / $jumlahwocroct) * 100;
        $rasioreworkfixoct = number_format((float)$rasioreworkoct, 2, '.', '');

        $reworknov = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrnov == 0) {
            $jumlahwocrnov = 0.01;
        }

        $rasioreworknov = ($reworknov / $jumlahwocrnov) * 100;
        $rasioreworkfixnov = number_format((float)$rasioreworknov, 2, '.', '');

        $reworkdes = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrdes == 0) {
            $jumlahwocrdes = 0.01;
        }

        $rasioreworkdes = ($reworkdes / $jumlahwocrdes) * 100;
        $rasioreworkfixdes = number_format((float)$rasioreworkdes, 2, '.', '');

        // Total KPI Rework
        $totalrework = ($rasioreworkfixjan + $rasioreworkfixfeb + $rasioreworkfixmar +
            $rasioreworkfixapr + $rasioreworkfixmay + $rasioreworkfixjun +
            $rasioreworkfixjul + $rasioreworkfixaug + $rasioreworkfixsep +
            $rasioreworkfixoct + $rasioreworkfixnov + $rasioreworkfixdes
        ) / 12;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $reworkfiveyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $fiveyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year3 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework5 = ($reworkfiveyearago / $fiveyearagowocrdes) * 100;
        $rasioreworkfix5 = number_format((float)$rasiorework5, 2, '.', '');

        $reworkfouryearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $fouryearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year4 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework4 = ($reworkfouryearago / $fouryearagowocrdes) * 100;
        $rasioreworkfix4 = number_format((float)$rasiorework4, 2, '.', '');

        $reworkthreeyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $threeyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year5 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework3 = ($reworkthreeyearago / $threeyearagowocrdes) * 100;
        $rasioreworkfix3 = number_format((float)$rasiorework3, 2, '.', '');

        $reworktwoyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $twoyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year6 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework2 = ($reworktwoyearago / $twoyearagowocrdes) * 100;
        $rasioreworkfix2 = number_format((float)$rasiorework2, 2, '.', '');

        $reworkoneyearago = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $oneyearagowocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $year7 . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $rasiorework1 = ($reworkoneyearago / $oneyearagowocrdes) * 100;
        $rasioreworkfix1 = number_format((float)$rasiorework1, 2, '.', '');

        return view(
            'kpi/rework34',
            [
                'jumlahreworktahun' => $jumlahreworktahun,
                'rasioreworkfixjan' => $rasioreworkfixjan,
                'rasioreworkfixfeb' => $rasioreworkfixfeb,
                'rasioreworkfixmar' => $rasioreworkfixmar,
                'rasioreworkfixapr' => $rasioreworkfixapr,
                'rasioreworkfixmay' => $rasioreworkfixmay,
                'rasioreworkfixjun' => $rasioreworkfixjun,
                'rasioreworkfixjul' => $rasioreworkfixjul,
                'rasioreworkfixaug' => $rasioreworkfixaug,
                'rasioreworkfixsep' => $rasioreworkfixsep,
                'rasioreworkfixoct' => $rasioreworkfixoct,
                'rasioreworkfixnov' => $rasioreworkfixnov,
                'rasioreworkfixdes' => $rasioreworkfixdes,
                'jumlahwocrjan' => $jumlahwocrjan,
                'jumlahwocrfeb' => $jumlahwocrfeb,
                'jumlahwocrmar' => $jumlahwocrmar,
                'jumlahwocrapr' => $jumlahwocrapr,
                'jumlahwocrmay' => $jumlahwocrmay,
                'jumlahwocrjun' => $jumlahwocrjun,
                'jumlahwocrjul' => $jumlahwocrjul,
                'jumlahwocraug' => $jumlahwocraug,
                'jumlahwocrsep' => $jumlahwocrsep,
                'jumlahwocroct' => $jumlahwocroct,
                'jumlahwocrnov' => $jumlahwocrnov,
                'jumlahwocrdes' => $jumlahwocrdes,
                'reworkjan' => $reworkjan,
                'reworkfeb' => $reworkfeb,
                'reworkmar' => $reworkmar,
                'reworkapr' => $reworkapr,
                'reworkmay' => $reworkmay,
                'reworkjun' => $reworkjun,
                'reworkjul' => $reworkjul,
                'reworkaug' => $reworkaug,
                'reworksep' => $reworksep,
                'reworkoct' => $reworkoct,
                'reworknov' => $reworknov,
                'reworkdes' => $reworkdes,
                'totalreworkfix' => $totalreworkfix,
                'thisyear' => $thisyear,
                'tablereworktahun' => $tablereworktahun,

                'rasioreworkfix5' => $rasioreworkfix5,
                'rasioreworkfix4' => $rasioreworkfix4,
                'rasioreworkfix3' => $rasioreworkfix3,
                'rasioreworkfix2' => $rasioreworkfix2,
                'rasioreworkfix1' => $rasioreworkfix1,
                'year3' => $year3,
                'year4' => $year4,
                'year5' => $year5,
                'year6' => $year6,
                'year7' => $year7,
            ]
        );
    }

    public function Rework5()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $jumlahreworktahun = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $tablereworktahun = DB::table('msf620')
            ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->paginate(10);

        $reworkjan = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjan = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jan . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjan == 0) {
            $jumlahwocrjan = 0.01;
        }

        $rasioreworkjan = ($reworkjan / $jumlahwocrjan) * 100;
        $rasioreworkfixjan = number_format((float)$rasioreworkjan, 2, '.', '');

        $reworkfeb = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrfeb = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $feb . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrfeb == 0) {
            $jumlahwocrfeb = 0.01;
        }

        $rasioreworkfeb = ($reworkfeb / $jumlahwocrfeb) * 100;
        $rasioreworkfixfeb = number_format((float)$rasioreworkfeb, 2, '.', '');

        $reworkmar = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrmar = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $mar . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrmar == 0) {
            $jumlahwocrmar = 0.01;
        }

        $rasioreworkmar = ($reworkmar / $jumlahwocrmar) * 100;
        $rasioreworkfixmar = number_format((float)$rasioreworkmar, 2, '.', '');

        $reworkapr = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrapr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $apr . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrapr == 0) {
            $jumlahwocrapr = 0.01;
        }

        $rasioreworkapr = ($reworkapr / $jumlahwocrapr) * 100;
        $rasioreworkfixapr = number_format((float)$rasioreworkapr, 2, '.', '');

        $reworkmay = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrmay = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $may . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrmay == 0) {
            $jumlahwocrmay = 0.01;
        }

        $rasioreworkmay = ($reworkmay / $jumlahwocrmay) * 100;
        $rasioreworkfixmay = number_format((float)$rasioreworkmay, 2, '.', '');

        $reworkjun = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjun = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jun . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjun == 0) {
            $jumlahwocrjun = 0.01;
        }

        $rasioreworkjun = ($reworkjun / $jumlahwocrjun) * 100;
        $rasioreworkfixjun = number_format((float)$rasioreworkjun, 2, '.', '');

        $reworkjul = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrjul = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $jul . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrjul == 0) {
            $jumlahwocrjul = 0.01;
        }

        $rasioreworkjul = ($reworkjul / $jumlahwocrjul) * 100;
        $rasioreworkfixjul = number_format((float)$rasioreworkjul, 2, '.', '');

        $reworkaug = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocraug = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $aug . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocraug == 0) {
            $jumlahwocraug = 0.01;
        }

        $rasioreworkaug = ($reworkaug / $jumlahwocraug) * 100;
        $rasioreworkfixaug = number_format((float)$rasioreworkaug, 2, '.', '');

        $reworksep = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrsep = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $sep . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrsep == 0) {
            $jumlahwocrsep = 0.01;
        }

        $rasioreworksep = ($reworksep / $jumlahwocrsep) * 100;
        $rasioreworkfixsep = number_format((float)$rasioreworksep, 2, '.', '');

        $reworkoct = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocroct = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $oct . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocroct == 0) {
            $jumlahwocroct = 0.01;
        }

        $rasioreworkoct = ($reworkoct / $jumlahwocroct) * 100;
        $rasioreworkfixoct = number_format((float)$rasioreworkoct, 2, '.', '');

        $reworknov = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrnov = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $nov . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrnov == 0) {
            $jumlahwocrnov = 0.01;
        }

        $rasioreworknov = ($reworknov / $jumlahwocrnov) * 100;
        $rasioreworkfixnov = number_format((float)$rasioreworknov, 2, '.', '');

        $reworkdes = DB::table('msf620')
            ->select('equip_no', DB::raw('COUNT(equip_no)'))
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->groupBy('equip_no')
            ->havingRaw('COUNT(equip_no) > 1')
            ->count();

        $jumlahwocrdes = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $des . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        if ($jumlahwocrdes == 0) {
            $jumlahwocrdes = 0.01;
        }

        $rasioreworkdes = ($reworkdes / $jumlahwocrdes) * 100;
        $rasioreworkfixdes = number_format((float)$rasioreworkdes, 2, '.', '');

        // Total KPI Rework
        $totalrework = ($rasioreworkfixjan + $rasioreworkfixfeb + $rasioreworkfixmar +
            $rasioreworkfixapr + $rasioreworkfixmay + $rasioreworkfixjun +
            $rasioreworkfixjul + $rasioreworkfixaug + $rasioreworkfixsep +
            $rasioreworkfixoct + $rasioreworkfixnov + $rasioreworkfixdes
        ) / 12;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');


        return view(
            'kpi/rework5',
            [
                'jumlahreworktahun' => $jumlahreworktahun,
                'rasioreworkfixjan' => $rasioreworkfixjan,
                'rasioreworkfixfeb' => $rasioreworkfixfeb,
                'rasioreworkfixmar' => $rasioreworkfixmar,
                'rasioreworkfixapr' => $rasioreworkfixapr,
                'rasioreworkfixmay' => $rasioreworkfixmay,
                'rasioreworkfixjun' => $rasioreworkfixjun,
                'rasioreworkfixjul' => $rasioreworkfixjul,
                'rasioreworkfixaug' => $rasioreworkfixaug,
                'rasioreworkfixsep' => $rasioreworkfixsep,
                'rasioreworkfixoct' => $rasioreworkfixoct,
                'rasioreworkfixnov' => $rasioreworkfixnov,
                'rasioreworkfixdes' => $rasioreworkfixdes,
                'jumlahwocrjan' => $jumlahwocrjan,
                'jumlahwocrfeb' => $jumlahwocrfeb,
                'jumlahwocrmar' => $jumlahwocrmar,
                'jumlahwocrapr' => $jumlahwocrapr,
                'jumlahwocrmay' => $jumlahwocrmay,
                'jumlahwocrjun' => $jumlahwocrjun,
                'jumlahwocrjul' => $jumlahwocrjul,
                'jumlahwocraug' => $jumlahwocraug,
                'jumlahwocrsep' => $jumlahwocrsep,
                'jumlahwocroct' => $jumlahwocroct,
                'jumlahwocrnov' => $jumlahwocrnov,
                'jumlahwocrdes' => $jumlahwocrdes,
                'reworkjan' => $reworkjan,
                'reworkfeb' => $reworkfeb,
                'reworkmar' => $reworkmar,
                'reworkapr' => $reworkapr,
                'reworkmay' => $reworkmay,
                'reworkjun' => $reworkjun,
                'reworkjul' => $reworkjul,
                'reworkaug' => $reworkaug,
                'reworksep' => $reworksep,
                'reworkoct' => $reworkoct,
                'reworknov' => $reworknov,
                'reworkdes' => $reworkdes,
                'totalreworkfix' => $totalreworkfix,
                'thisyear' => $thisyear,
                'tablereworktahun' => $tablereworktahun,
            ]
        );
    }

    public function PMcompliancePrint(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = Carbon::now()->setMonth(1)->format('Y-m');
        $feb = Carbon::now()->setMonth(2)->format('Y-m');
        $mar = Carbon::now()->setMonth(3)->format('Y-m');
        $apr = Carbon::now()->setMonth(4)->format('Y-m');
        $may = Carbon::now()->setMonth(5)->format('Y-m');
        $jun = Carbon::now()->setMonth(6)->format('Y-m');
        $jul = Carbon::now()->setMonth(7)->format('Y-m');
        $aug = Carbon::now()->setMonth(8)->format('Y-m');
        $sep = Carbon::now()->setMonth(9)->format('Y-m');
        $oct = Carbon::now()->setMonth(10)->format('Y-m');
        $nov = Carbon::now()->setMonth(11)->format('Y-m');
        $des = Carbon::now()->setMonth(12)->format('Y-m');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        /*$test = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TELECT'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
                ['msf620.plan_fin_date', 'LIKE', '%2023-01%']
            ])
            ->orderBy('msf620.plan_fin_date')
            ->get();

        dd($test->toJson()); */

        $option = 'TELECT';
        $namaunit = 'Listrik 1-2';

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TELECT') {
                $namaunit = 'Listrik 1-2';
            }
            if ($request->bidang == 'TELECT3') {
                $namaunit = 'Listrik 3-4';
            }
            if ($request->bidang == 'TELECT5') {
                $namaunit = 'Listrik 5';
            }

            $tablepmnotcomply = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                ])
                ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
                ->whereNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'asc')
                ->get();

            $jumlahwopmyear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjan == 0) {
                $jumlahwopmjan = 0.001;
            }

            $pmcompliancejan = ($jumlahwopmclosedjan / $jumlahwopmjan) * 100;
            $pmcompliancejanfix = number_format((float)$pmcompliancejan, 2, '.', '');

            $jumlahwopmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmfeb == 0) {
                $jumlahwopmfeb = 0.001;
            }

            $pmcompliancefeb = ($jumlahwopmclosedfeb / $jumlahwopmfeb) * 100;
            $pmcompliancefebfix = number_format((float)$pmcompliancefeb, 2, '.', '');

            $jumlahwopmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmar == 0) {
                $jumlahwopmmar = 0.001;
            }

            $pmcompliancemar = ($jumlahwopmclosedmar / $jumlahwopmmar) * 100;
            $pmcompliancemarfix = number_format((float)$pmcompliancemar, 2, '.', '');

            $jumlahwopmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmapr == 0) {
                $jumlahwopmapr = 0.001;
            }

            $pmcomplianceapr = ($jumlahwopmclosedapr / $jumlahwopmapr) * 100;
            $pmcomplianceaprfix = number_format((float)$pmcomplianceapr, 2, '.', '');

            $jumlahwopmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmay == 0) {
                $jumlahwopmmay = 0.001;
            }

            $pmcompliancemay = ($jumlahwopmclosedmay / $jumlahwopmmay) * 100;
            $pmcompliancemayfix = number_format((float)$pmcompliancemay, 2, '.', '');

            $jumlahwopmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjun == 0) {
                $jumlahwopmjun = 0.001;
            }

            $pmcompliancejun = ($jumlahwopmclosedjun / $jumlahwopmjun) * 100;
            $pmcompliancejunfix = number_format((float)$pmcompliancejun, 2, '.', '');

            $jumlahwopmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjul == 0) {
                $jumlahwopmjul = 0.001;
            }

            $pmcompliancejul = ($jumlahwopmclosedjul / $jumlahwopmjul) * 100;
            $pmcompliancejulfix = number_format((float)$pmcompliancejul, 2, '.', '');

            $jumlahwopmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmaug == 0) {
                $jumlahwopmaug = 0.001;
            }

            $pmcomplianceaug = ($jumlahwopmclosedaug / $jumlahwopmaug) * 100;
            $pmcomplianceaugfix = number_format((float)$pmcomplianceaug, 2, '.', '');

            $jumlahwopmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmsep == 0) {
                $jumlahwopmsep = 0.001;
            }

            $pmcompliancesep = ($jumlahwopmclosedsep / $jumlahwopmsep) * 100;
            $pmcompliancesepfix = number_format((float)$pmcompliancesep, 2, '.', '');

            $jumlahwopmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmoct == 0) {
                $jumlahwopmoct = 0.001;
            }

            $pmcomplianceoct = ($jumlahwopmclosedoct / $jumlahwopmoct) * 100;
            $pmcomplianceoctfix = number_format((float)$pmcomplianceoct, 2, '.', '');

            $jumlahwopmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmnov == 0) {
                $jumlahwopmnov = 0.001;
            }

            $pmcompliancenov = ($jumlahwopmclosednov / $jumlahwopmnov) * 100;
            $pmcompliancenovfix = number_format((float)$pmcompliancenov, 2, '.', '');

            $jumlahwopmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmdes == 0) {
                $jumlahwopmdes = 0.001;
            }

            $pmcompliancedes = ($jumlahwopmcloseddes / $jumlahwopmdes) * 100;
            $pmcompliancedesfix = number_format((float)$pmcompliancedes, 2, '.', '');

            // Total KPI Persen
            $totalkpi = ($pmcompliancejanfix + $pmcompliancefebfix + $pmcompliancemarfix + $pmcomplianceaprfix + $pmcompliancemayfix
                + $pmcompliancejunfix + $pmcompliancejulfix + $pmcomplianceaugfix + $pmcompliancesepfix + $pmcomplianceoctfix
                + $pmcompliancenovfix + $pmcompliancedesfix) / 12;

            $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

            $sevenyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sevenyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $sixyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sixyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fiveyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fiveyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fouryearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fouryearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $threeyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $threeyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $twoyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $oneyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $oneyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $nowyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $request->bidang],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])

                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
        } else {
            $option = 'TELECT';
            $namaunit = 'Listrik 1-2';

            $tablepmnotcomply = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C']

                ])
                ->whereNull('msf623.completion_comment')
                ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
                ->orderBy('msf620.plan_fin_date', 'asc')
                ->get();

            $jumlahwopmyear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjan == 0) {
                $jumlahwopmjan = 0.001;
            }

            $pmcompliancejan = ($jumlahwopmclosedjan / $jumlahwopmjan) * 100;
            $pmcompliancejanfix = number_format((float)$pmcompliancejan, 2, '.', '');

            $jumlahwopmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmfeb == 0) {
                $jumlahwopmfeb = 0.001;
            }

            $pmcompliancefeb = ($jumlahwopmclosedfeb / $jumlahwopmfeb) * 100;
            $pmcompliancefebfix = number_format((float)$pmcompliancefeb, 2, '.', '');

            $jumlahwopmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmar == 0) {
                $jumlahwopmmar = 0.001;
            }

            $pmcompliancemar = ($jumlahwopmclosedmar / $jumlahwopmmar) * 100;
            $pmcompliancemarfix = number_format((float)$pmcompliancemar, 2, '.', '');

            $jumlahwopmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmapr == 0) {
                $jumlahwopmapr = 0.001;
            }

            $pmcomplianceapr = ($jumlahwopmclosedapr / $jumlahwopmapr) * 100;
            $pmcomplianceaprfix = number_format((float)$pmcomplianceapr, 2, '.', '');

            $jumlahwopmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmmay == 0) {
                $jumlahwopmmay = 0.001;
            }

            $pmcompliancemay = ($jumlahwopmclosedmay / $jumlahwopmmay) * 100;
            $pmcompliancemayfix = number_format((float)$pmcompliancemay, 2, '.', '');

            $jumlahwopmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjun == 0) {
                $jumlahwopmjun = 0.001;
            }

            $pmcompliancejun = ($jumlahwopmclosedjun / $jumlahwopmjun) * 100;
            $pmcompliancejunfix = number_format((float)$pmcompliancejun, 2, '.', '');

            $jumlahwopmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmjul == 0) {
                $jumlahwopmjul = 0.001;
            }

            $pmcompliancejul = ($jumlahwopmclosedjul / $jumlahwopmjul) * 100;
            $pmcompliancejulfix = number_format((float)$pmcompliancejul, 2, '.', '');

            $jumlahwopmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmaug == 0) {
                $jumlahwopmaug = 0.001;
            }

            $pmcomplianceaug = ($jumlahwopmclosedaug / $jumlahwopmaug) * 100;
            $pmcomplianceaugfix = number_format((float)$pmcomplianceaug, 2, '.', '');

            $jumlahwopmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmsep == 0) {
                $jumlahwopmsep = 0.001;
            }

            $pmcompliancesep = ($jumlahwopmclosedsep / $jumlahwopmsep) * 100;
            $pmcompliancesepfix = number_format((float)$pmcompliancesep, 2, '.', '');

            $jumlahwopmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmoct == 0) {
                $jumlahwopmoct = 0.001;
            }

            $pmcomplianceoct = ($jumlahwopmclosedoct / $jumlahwopmoct) * 100;
            $pmcomplianceoctfix = number_format((float)$pmcomplianceoct, 2, '.', '');

            $jumlahwopmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmnov == 0) {
                $jumlahwopmnov = 0.001;
            }

            $pmcompliancenov = ($jumlahwopmclosednov / $jumlahwopmnov) * 100;
            $pmcompliancenovfix = number_format((float)$pmcompliancenov, 2, '.', '');

            $jumlahwopmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%'],

                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            if ($jumlahwopmdes == 0) {
                $jumlahwopmdes = 0.001;
            }

            $pmcompliancedes = ($jumlahwopmcloseddes / $jumlahwopmdes) * 100;
            $pmcompliancedesfix = number_format((float)$pmcompliancedes, 2, '.', '');

            // Total KPI Persen
            $totalkpi = ($pmcompliancejanfix + $pmcompliancefebfix + $pmcompliancemarfix + $pmcomplianceaprfix + $pmcompliancemayfix
                + $pmcompliancejunfix + $pmcompliancejulfix + $pmcomplianceaugfix + $pmcompliancesepfix + $pmcomplianceoctfix
                + $pmcompliancenovfix + $pmcompliancedesfix) / 12;

            $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

            $sevenyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sevenyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $sixyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sixyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fiveyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fiveyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fouryearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fouryearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $threeyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $threeyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%'],
                    ['msf620.wo_status_m', '=', 'C'],
                ])
                //->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $oneyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $oneyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $nowyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', 'TELECT'],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])

                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
        }

        $pmnotcomplyjan = number_format((float)$jumlahwopmjan - $jumlahwopmclosedjan, 0, '', '');
        $pmnotcomplyfeb = number_format((float)$jumlahwopmfeb - $jumlahwopmclosedfeb, 0, '', '');
        $pmnotcomplymar = number_format((float)$jumlahwopmmar - $jumlahwopmclosedmar, 0, '', '');
        $pmnotcomplyapr = number_format((float)$jumlahwopmapr - $jumlahwopmclosedapr, 0, '', '');
        $pmnotcomplymay = number_format((float)$jumlahwopmmay - $jumlahwopmclosedmay, 0, '', '');
        $pmnotcomplyjun = number_format((float)$jumlahwopmjun - $jumlahwopmclosedjun, 0, '', '');
        $pmnotcomplyjul = number_format((float)$jumlahwopmjul - $jumlahwopmclosedjul, 0, '', '');
        $pmnotcomplyaug = number_format((float)$jumlahwopmaug - $jumlahwopmclosedaug, 0, '', '');
        $pmnotcomplysep = number_format((float)$jumlahwopmsep - $jumlahwopmclosedsep, 0, '', '');
        $pmnotcomplyoct = number_format((float)$jumlahwopmoct - $jumlahwopmclosedoct, 0, '', '');
        $pmnotcomplynov = number_format((float)$jumlahwopmnov - $jumlahwopmclosednov, 0, '', '');
        $pmnotcomplydes = number_format((float)$jumlahwopmdes - $jumlahwopmcloseddes, 0, '', '');

        $data = [
            'thisyear' => $thisyear,
            'jumlahwopmyear' => $jumlahwopmyear,
            'jumlahwopmjan' => $jumlahwopmjan,
            'jumlahwopmclosedjan' => $jumlahwopmclosedjan,
            'pmcompliancejanfix' => $pmcompliancejanfix,
            'jumlahwopmfeb' => $jumlahwopmfeb,
            'jumlahwopmclosedfeb' => $jumlahwopmclosedfeb,
            'pmcompliancefebfix' => $pmcompliancefebfix,
            'jumlahwopmmar' => $jumlahwopmmar,
            'jumlahwopmclosedmar' => $jumlahwopmclosedmar,
            'pmcompliancemarfix' => $pmcompliancemarfix,
            'jumlahwopmapr' => $jumlahwopmapr,
            'jumlahwopmclosedapr' => $jumlahwopmclosedapr,
            'pmcomplianceaprfix' => $pmcomplianceaprfix,
            'jumlahwopmmay' => $jumlahwopmmay,
            'jumlahwopmclosedmay' => $jumlahwopmclosedmay,
            'pmcompliancemayfix' => $pmcompliancemayfix,
            'jumlahwopmjun' => $jumlahwopmjun,
            'jumlahwopmclosedjun' => $jumlahwopmclosedjun,
            'pmcompliancejunfix' => $pmcompliancejunfix,
            'jumlahwopmjul' => $jumlahwopmjul,
            'jumlahwopmclosedjul' => $jumlahwopmclosedjul,
            'pmcompliancejulfix' => $pmcompliancejulfix,
            'jumlahwopmaug' => $jumlahwopmaug,
            'jumlahwopmclosedaug' => $jumlahwopmclosedaug,
            'pmcomplianceaugfix' => $pmcomplianceaugfix,
            'jumlahwopmsep' => $jumlahwopmsep,
            'jumlahwopmclosedsep' => $jumlahwopmclosedsep,
            'pmcompliancesepfix' => $pmcompliancesepfix,
            'jumlahwopmoct' => $jumlahwopmoct,
            'jumlahwopmclosedoct' => $jumlahwopmclosedoct,
            'pmcomplianceoctfix' => $pmcomplianceoctfix,
            'jumlahwopmnov' => $jumlahwopmnov,
            'jumlahwopmclosednov' => $jumlahwopmclosednov,
            'pmcompliancenovfix' => $pmcompliancenovfix,
            'jumlahwopmdes' => $jumlahwopmdes,
            'jumlahwopmcloseddes' => $jumlahwopmcloseddes,
            'pmcompliancedesfix' => $pmcompliancedesfix,
            'totalkpifix' => $totalkpifix,
            'sevenyearagowopm' => $sevenyearagowopm,
            'sixyearagowopm' => $sixyearagowopm,
            'fiveyearagowopm' => $fiveyearagowopm,
            'fouryearagowopm' => $fouryearagowopm,
            'threeyearagowopm' => $threeyearagowopm,
            'twoyearagowopm' => $twoyearagowopm,
            'oneyearagowopm' => $oneyearagowopm,
            'sevenyearagowopmclosed' => $sevenyearagowopmclosed,
            'sixyearagowopmclosed' => $sixyearagowopmclosed,
            'fiveyearagowopmclosed' => $fiveyearagowopmclosed,
            'fouryearagowopmclosed' => $fouryearagowopmclosed,
            'threeyearagowopmclosed' => $threeyearagowopmclosed,
            'twoyearagowopmclosed' => $twoyearagowopmclosed,
            'oneyearagowopmclosed' => $oneyearagowopmclosed,
            'nowyearagowopmclosed' => $nowyearagowopmclosed,
            'year1' => $year1,
            'year2' => $year2,
            'year3' => $year3,
            'year4' => $year4,
            'year5' => $year5,
            'year6' => $year6,
            'year7' => $year7,
            'option' => $option,
            'namaunit' => $namaunit,
            'tablepmnotcomply' => $tablepmnotcomply,
            'thisyear' => $thisyear,
            'jumlahwopmyear' => $jumlahwopmyear,
            'jumlahwopmjan' => $jumlahwopmjan,
            'jumlahwopmclosedjan' => $jumlahwopmclosedjan,
            'pmcompliancejanfix' => $pmcompliancejanfix,
            'jumlahwopmfeb' => $jumlahwopmfeb,
            'jumlahwopmclosedfeb' => $jumlahwopmclosedfeb,
            'pmcompliancefebfix' => $pmcompliancefebfix,
            'jumlahwopmmar' => $jumlahwopmmar,
            'jumlahwopmclosedmar' => $jumlahwopmclosedmar,
            'pmcompliancemarfix' => $pmcompliancemarfix,
            'jumlahwopmapr' => $jumlahwopmapr,
            'jumlahwopmclosedapr' => $jumlahwopmclosedapr,
            'pmcomplianceaprfix' => $pmcomplianceaprfix,
            'jumlahwopmmay' => $jumlahwopmmay,
            'jumlahwopmclosedmay' => $jumlahwopmclosedmay,
            'pmcompliancemayfix' => $pmcompliancemayfix,
            'jumlahwopmjun' => $jumlahwopmjun,
            'jumlahwopmclosedjun' => $jumlahwopmclosedjun,
            'pmcompliancejunfix' => $pmcompliancejunfix,
            'jumlahwopmjul' => $jumlahwopmjul,
            'jumlahwopmclosedjul' => $jumlahwopmclosedjul,
            'pmcompliancejulfix' => $pmcompliancejulfix,
            'jumlahwopmaug' => $jumlahwopmaug,
            'jumlahwopmclosedaug' => $jumlahwopmclosedaug,
            'pmcomplianceaugfix' => $pmcomplianceaugfix,
            'jumlahwopmsep' => $jumlahwopmsep,
            'jumlahwopmclosedsep' => $jumlahwopmclosedsep,
            'pmcompliancesepfix' => $pmcompliancesepfix,
            'jumlahwopmoct' => $jumlahwopmoct,
            'jumlahwopmclosedoct' => $jumlahwopmclosedoct,
            'pmcomplianceoctfix' => $pmcomplianceoctfix,
            'jumlahwopmnov' => $jumlahwopmnov,
            'jumlahwopmclosednov' => $jumlahwopmclosednov,
            'pmcompliancenovfix' => $pmcompliancenovfix,
            'jumlahwopmdes' => $jumlahwopmdes,
            'jumlahwopmcloseddes' => $jumlahwopmcloseddes,
            'pmcompliancedesfix' => $pmcompliancedesfix,
            'totalkpifix' => $totalkpifix,
            'sevenyearagowopm' => $sevenyearagowopm,
            'sixyearagowopm' => $sixyearagowopm,
            'fiveyearagowopm' => $fiveyearagowopm,
            'fouryearagowopm' => $fouryearagowopm,
            'threeyearagowopm' => $threeyearagowopm,
            'twoyearagowopm' => $twoyearagowopm,
            'oneyearagowopm' => $oneyearagowopm,
            'sevenyearagowopmclosed' => $sevenyearagowopmclosed,
            'sixyearagowopmclosed' => $sixyearagowopmclosed,
            'fiveyearagowopmclosed' => $fiveyearagowopmclosed,
            'fouryearagowopmclosed' => $fouryearagowopmclosed,
            'threeyearagowopmclosed' => $threeyearagowopmclosed,
            'twoyearagowopmclosed' => $twoyearagowopmclosed,
            'oneyearagowopmclosed' => $oneyearagowopmclosed,
            'nowyearagowopmclosed' => $nowyearagowopmclosed,
            'year1' => $year1,
            'year2' => $year2,
            'year3' => $year3,
            'year4' => $year4,
            'year5' => $year5,
            'year6' => $year6,
            'year7' => $year7,
            'option' => $option,
            'namaunit' => $namaunit,
            'tablepmnotcomply' => $tablepmnotcomply,

            'pmnotcomplyjan' => $pmnotcomplyjan,
            'pmnotcomplyfeb' => $pmnotcomplyfeb,
            'pmnotcomplymar' => $pmnotcomplymar,
            'pmnotcomplyapr' => $pmnotcomplyapr,
            'pmnotcomplymay' => $pmnotcomplymay,
            'pmnotcomplyjun' => $pmnotcomplyjun,
            'pmnotcomplyjul' => $pmnotcomplyjul,
            'pmnotcomplyaug' => $pmnotcomplyaug,
            'pmnotcomplysep' => $pmnotcomplysep,
            'pmnotcomplyoct' => $pmnotcomplyoct,
            'pmnotcomplynov' => $pmnotcomplynov,
            'pmnotcomplydes' => $pmnotcomplydes,
        ];

        //$pdf = PDF::loadview('kpi/pmcompliancepdf', $data);
        //return $pdf->download('Report-PMCompliance-Listrik12.pdf');
    }

    public function TestPageIndex(Request $request)
    {

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d'); //Output 2023-01-01

        /*$tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->whereNull('msf623.completion_comment')
            ->where([
                ['msf620.work_group', '=', 'TINST'],
                ['msf620.maint_type', '=', 'CR'],
                ['msf620.wo_status_m', '=', 'C'],
                ['msf620.plan_fin_date', 'LIKE', '%2023-02%'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->orderBy('msf620.plan_fin_date', 'asc')
            ->get();*/

        $jumlahwocrfeb = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf623.creation_date', 'LIKE', '%2023-02%'],
                ['msf620.maint_type', '=', 'CR'],
                ['msf623.work_group', '=', 'TINST']
                //['msf623.work_order', '=', '00149086']
            ])
            ->get();

        dd($jumlahwocrfeb->toArray());

        return view('testPage');
    }

    public function Print()
    {
        $date = Carbon::now()->format('Y-m-d HH:mm');

        $pdf = PDF::loadview('testPage');
        $pdf->set_paper('A4', 'landscape');
        return $pdf->download('Test.pdf');
    }
}
