<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WrenchTime;
use App\Imports\FileImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KPIControllerInst extends Controller
{
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

        $option = 'TINST';
        $namaunit = 'Instrument 1-2';

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TINST') {
                $namaunit = 'Instrument 1-2';
            }
            if ($request->bidang == 'TINST34') {
                $namaunit = 'Instrument 3-4';
            }
            if ($request->bidang == 'TINST5') {
                $namaunit = 'Instrument 5';
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
            $option = 'TINST';
            $namaunit = 'Instrument 1-2';

            $tablepmnotcomply = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.wo_status_m', '=', 'C'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosedoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmclosednov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $jumlahwopmcloseddes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sevenyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year1 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $sixyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $sixyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year2 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $fiveyearagowopm = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fiveyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $fouryearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $threeyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $twoyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],
                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
            $oneyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->whereNotNull('msf623.completion_comment')
                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();

            $nowyearagowopmclosed = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'PM'],

                    ['msf620.plan_fin_date', 'LIKE', '%' . $thisyear . '%']
                ])

                ->orderBy('msf620.plan_fin_date', 'desc')
                ->count();
        }

        return view(
            'kpi/pmcomplianceinst',
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

        $option = 'TINST';
        $namaunit = 'Instrument 1-2';

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TINST') {
                $namaunit = 'Instrument 1-2';
            }
            if ($request->bidang == 'TINST34') {
                $namaunit = 'Instrument 3-4';
            }
            if ($request->bidang == 'TINST5') {
                $namaunit = 'Instrument 5';
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

            $option = 'TINST';
            $namaunit = 'Instrument 1-2';

            $jumlahwocryear = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'],
                    ['msf623.creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwocrjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjan = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmfeb = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmmar = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmapr = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmmay = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjun = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmjul = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmaug = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orWhere([
                    ['msf620.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf620.creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmsep = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmoct = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->orderBy('msf620.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmnov = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'CR'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orWhere([
                    ['msf623.work_group', '=', $option],
                    ['msf620.maint_type', '=', 'EM'], //CR 8 PM 215
                    ['msf623.creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->orderBy('msf623.creation_date', 'desc')
                ->count();

            $jumlahwonotcrpmdes = DB::table('msf620')
                ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
                ->where([
                    ['msf620.work_group', '=', $option],
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
                    ['msf620.work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $fiveyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $fouryearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $threeyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $twoyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
            $oneyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();


            $oneyearagoreactive = ($oneyearagowocr / $oneyearagowo) * 100;
            $oneyearagoreactivefix = number_format((float)$oneyearagoreactive, 2, '.', '');

            $nowyearagowo = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%'],
                    ['maint_type', 'NOT LIKE', '%CR%'],
                    ['maint_type', 'NOT LIKE', '%EM%'],
                ])
                ->orderBy('creation_date', 'desc')
                ->count();
        }

        return view(
            'kpi/reactiveworkinst',
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

    public function ReWork(Request $request)
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

        $option = 'TINST';
        $namaunit = 'Instrumen 1-2';

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TINST') {
                $namaunit = 'Instrumen 1-2';
            }
            if ($request->bidang == 'TINST34') {
                $namaunit = 'Instrumen 3-4';
            }
            if ($request->bidang == 'TINST5') {
                $namaunit = 'Instrumen 5';
            }
            $jumlahreworktahun = DB::table('msf620')
                ->select('equip_no', DB::raw('COUNT(equip_no)'))
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $tablereworktahun = DB::table('msf620')
                ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->paginate(10);

            $reworkjan = DB::table('msf620')
                ->select('equip_no', DB::raw('COUNT(equip_no)'))
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrjan = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrfeb = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrmar = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrapr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrmay = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrjun = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrjul = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocraug = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrsep = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocroct = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrnov = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $fiveyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $fouryearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $threeyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $twoyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
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
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $oneyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $request->bidang],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $rasiorework1 = ($reworkoneyearago / $oneyearagowocrdes) * 100;
            $rasioreworkfix1 = number_format((float)$rasiorework1, 2, '.', '');
        } else {
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $tablereworktahun = DB::table('msf620')
                ->select('equip_no', 'wo_desc', 'creation_date', DB::raw('COUNT(equip_no) AS total'))
                ->where([
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->paginate(10);

            $reworkjan = DB::table('msf620')
                ->select('equip_no', DB::raw('COUNT(equip_no)'))
                ->where([
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $jan . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrjan = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $feb . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrfeb = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $mar . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrmar = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $apr . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrapr = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $may . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrmay = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $jun . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrjun = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $jul . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrjul = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $aug . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocraug = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $sep . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrsep = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $oct . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocroct = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $nov . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrnov = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', $option],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $des . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $jumlahwocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', $option],
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
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year3 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $fiveyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TINST'],
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
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year4 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $fouryearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TINST'],
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
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year5 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $threeyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TINST'],
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
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year6 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $twoyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TINST'],
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
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->groupBy('equip_no')
                ->havingRaw('COUNT(equip_no) > 1')
                ->count();

            $oneyearagowocrdes = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'CR'],
                    ['creation_date', 'LIKE', '%' . $year7 . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->count();

            $rasiorework1 = ($reworkoneyearago / $oneyearagowocrdes) * 100;
            $rasioreworkfix1 = number_format((float)$rasiorework1, 2, '.', '');
        }

        return view(
            'kpi/reworkinst',
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
                'namaunit' => $namaunit,
                'option' => $option,

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

    public function WrenchTime(Request $request)
    {
        // Code ..
        $thisyear = Carbon::now()->format('Y');
        $jan = Carbon::now()->setMonth(1)->format('Ym');
        $feb = Carbon::now()->setMonth(2)->format('Ym');
        $mar = Carbon::now()->setMonth(3)->format('Ym');
        $apr = Carbon::now()->setMonth(4)->format('Ym');
        $may = Carbon::now()->setMonth(5)->format('Ym');
        $jun = Carbon::now()->setMonth(6)->format('Ym');
        $jul = Carbon::now()->setMonth(7)->format('Ym');
        $aug = Carbon::now()->setMonth(8)->format('Ym');
        $sep = Carbon::now()->setMonth(9)->format('Ym');
        $oct = Carbon::now()->setMonth(10)->format('Ym');
        $nov = Carbon::now()->setMonth(11)->format('Ym');
        $des = Carbon::now()->setMonth(12)->format('Ym');

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $option = 'TINST';
        $namaunit = 'Instrumen 1-2';

        if ($request->bidang) {

            $totalwocr = WrenchTime::where('work_group', 'LIKE', '%' . $request->bidang . '%')->count();

            $option = $request->bidang;

            if ($request->bidang == 'TINST') {
                $namaunit = 'Instrumen 1-2';
            }
            if ($request->bidang == 'TINST34') {
                $namaunit = 'Instrumen 3-4';
            }
            if ($request->bidang == 'TINST5') {
                $namaunit = 'Instrumen 5';
            }

            $wrenchtime = WrenchTime::where('work_group', 'LIKE', '%' . $request->bidang . '%')
                ->paginate(5);

            $janhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jan . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $jantimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jan . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($janhandrepair == 0) {
                $janhandrepair = 0.001;
            }
            if ($jantimeonrepairs == 0) {
                $jantimeonrepairs = 0.001;
            }
            $countjan = ($janhandrepair / $jantimeonrepairs) * 100;
            $wrenchtimejan = number_format((float)$countjan, 2, '.', '');

            $febhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $feb . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $febtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $feb . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($febhandrepair == 0) {
                $febhandrepair = 0.001;
            }
            if ($febtimeonrepairs == 0) {
                $febtimeonrepairs = 0.001;
            }
            $countfeb = ($febhandrepair / $febtimeonrepairs) * 100;
            $wrenchtimefeb = number_format((float)$countfeb, 2, '.', '');

            $marhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $mar . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $martimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $mar . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($marhandrepair == 0) {
                $marhandrepair = 0.001;
            }
            if ($martimeonrepairs == 0) {
                $martimeonrepairs = 0.001;
            }
            $countmar = ($marhandrepair / $martimeonrepairs) * 100;
            $wrenchtimemar = number_format((float)$countmar, 2, '.', '');

            $aprhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $apr . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $aprtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $apr . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($aprhandrepair == 0) {
                $aprhandrepair = 0.001;
            }
            if ($aprtimeonrepairs == 0) {
                $aprtimeonrepairs = 0.001;
            }
            $countapr = ($aprhandrepair / $aprtimeonrepairs) * 100;
            $wrenchtimeapr = number_format((float)$countapr, 2, '.', '');

            $mayhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $may . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $maytimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $may . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($mayhandrepair == 0) {
                $mayhandrepair = 0.001;
            }
            if ($maytimeonrepairs == 0) {
                $maytimeonrepairs = 0.001;
            }
            $countmay = ($mayhandrepair / $maytimeonrepairs) * 100;
            $wrenchtimemay = number_format((float)$countmay, 2, '.', '');

            $junhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jun . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $juntimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jun . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($junhandrepair == 0) {
                $junhandrepair = 0.001;
            }
            if ($juntimeonrepairs == 0) {
                $juntimeonrepairs = 0.001;
            }
            $countjun = ($junhandrepair / $juntimeonrepairs) * 100;
            $wrenchtimejun = number_format((float)$countjun, 2, '.', '');

            $julhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jul . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $jultimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jul . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($julhandrepair == 0) {
                $julhandrepair = 0.001;
            }
            if ($jultimeonrepairs == 0) {
                $jultimeonrepairs = 0.001;
            }
            $countjul = ($julhandrepair / $jultimeonrepairs) * 100;
            $wrenchtimejul = number_format((float)$countjul, 2, '.', '');

            $aughandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $aug . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $augtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $aug . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($aughandrepair == 0) {
                $aughandrepair = 0.001;
            }
            if ($augtimeonrepairs == 0) {
                $augtimeonrepairs = 0.001;
            }
            $countaug = ($aughandrepair / $augtimeonrepairs) * 100;
            $wrenchtimeaug = number_format((float)$countaug, 2, '.', '');

            $sephandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $sep . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $septimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $sep . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($sephandrepair == 0) {
                $sephandrepair = 0.001;
            }
            if ($septimeonrepairs == 0) {
                $septimeonrepairs = 0.001;
            }
            $countsep = ($sephandrepair / $septimeonrepairs) * 100;
            $wrenchtimesep = number_format((float)$countsep, 2, '.', '');

            $octhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $oct . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $octtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $oct . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($octhandrepair == 0) {
                $octhandrepair = 0.001;
            }
            if ($octtimeonrepairs == 0) {
                $octtimeonrepairs = 0.001;
            }
            $countoct = ($octhandrepair / $octtimeonrepairs) * 100;
            $wrenchtimeoct = number_format((float)$countoct, 2, '.', '');

            $novhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $nov . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $novtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $nov . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($novhandrepair == 0) {
                $novhandrepair = 0.001;
            }
            if ($novtimeonrepairs == 0) {
                $novtimeonrepairs = 0.001;
            }
            $countnov = ($novhandrepair / $novtimeonrepairs) * 100;
            $wrenchtimenov = number_format((float)$countnov, 2, '.', '');

            $deshandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $des . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('on_hand_repairs');
            $destimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $des . '%'],
                ['work_group', 'LIKE', '%' . $request->bidang . '%'],
            ])->sum('time_to_repairs');

            if ($deshandrepair == 0) {
                $deshandrepair = 0.001;
            }
            if ($destimeonrepairs == 0) {
                $destimeonrepairs = 0.001;
            }
            $countdes = ($deshandrepair / $destimeonrepairs) * 100;
            $wrenchtimedes = number_format((float)$countdes, 2, '.', '');

            $total = ($wrenchtimejan + $wrenchtimefeb + $wrenchtimemar + $wrenchtimeapr + $wrenchtimemay + $wrenchtimejun
                + $wrenchtimejul + $wrenchtimeaug + $wrenchtimesep + $wrenchtimeoct + $wrenchtimenov + $wrenchtimedes) / 12;
            $totalfix = number_format((float)$total, 2, '.', '');
        } else {
            $totalwocr = WrenchTime::where('work_group', '=', $option)->count();
            $option = $request->bidang;

            if ($request->bidang == 'TINST') {
                $namaunit = 'Mekanik 1-2';
            }
            if ($request->bidang == 'TMECH34') {
                $namaunit = 'Mekanik 3-4';
            }
            if ($request->bidang == 'TMECH5') {
                $namaunit = 'Mekanik 5';
            }

            $wrenchtime = WrenchTime::where('work_group', '=', $option)
                ->paginate(5);

            $janhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jan . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $jantimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jan . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($janhandrepair == 0) {
                $janhandrepair = 0.001;
            }
            if ($jantimeonrepairs == 0) {
                $jantimeonrepairs = 0.001;
            }
            $countjan = ($janhandrepair / $jantimeonrepairs) * 100;
            $wrenchtimejan = number_format((float)$countjan, 2, '.', '');

            $febhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $feb . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $febtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $feb . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($febhandrepair == 0) {
                $febhandrepair = 0.001;
            }
            if ($febtimeonrepairs == 0) {
                $febtimeonrepairs = 0.001;
            }
            $countfeb = ($febhandrepair / $febtimeonrepairs) * 100;
            $wrenchtimefeb = number_format((float)$countfeb, 2, '.', '');

            $marhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $mar . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $martimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $mar . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($marhandrepair == 0) {
                $marhandrepair = 0.001;
            }
            if ($martimeonrepairs == 0) {
                $martimeonrepairs = 0.001;
            }
            $countmar = ($marhandrepair / $martimeonrepairs) * 100;
            $wrenchtimemar = number_format((float)$countmar, 2, '.', '');

            $aprhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $apr . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $aprtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $apr . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($aprhandrepair == 0) {
                $aprhandrepair = 0.001;
            }
            if ($aprtimeonrepairs == 0) {
                $aprtimeonrepairs = 0.001;
            }
            $countapr = ($aprhandrepair / $aprtimeonrepairs) * 100;
            $wrenchtimeapr = number_format((float)$countapr, 2, '.', '');

            $mayhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $may . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $maytimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $may . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($mayhandrepair == 0) {
                $mayhandrepair = 0.001;
            }
            if ($maytimeonrepairs == 0) {
                $maytimeonrepairs = 0.001;
            }
            $countmay = ($mayhandrepair / $maytimeonrepairs) * 100;
            $wrenchtimemay = number_format((float)$countmay, 2, '.', '');

            $junhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jun . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $juntimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jun . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($junhandrepair == 0) {
                $junhandrepair = 0.001;
            }
            if ($juntimeonrepairs == 0) {
                $juntimeonrepairs = 0.001;
            }
            $countjun = ($junhandrepair / $juntimeonrepairs) * 100;
            $wrenchtimejun = number_format((float)$countjun, 2, '.', '');

            $julhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jul . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $jultimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jul . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($julhandrepair == 0) {
                $julhandrepair = 0.001;
            }
            if ($jultimeonrepairs == 0) {
                $jultimeonrepairs = 0.001;
            }
            $countjul = ($julhandrepair / $jultimeonrepairs) * 100;
            $wrenchtimejul = number_format((float)$countjul, 2, '.', '');

            $aughandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $aug . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $augtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $aug . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($aughandrepair == 0) {
                $aughandrepair = 0.001;
            }
            if ($augtimeonrepairs == 0) {
                $augtimeonrepairs = 0.001;
            }
            $countaug = ($aughandrepair / $augtimeonrepairs) * 100;
            $wrenchtimeaug = number_format((float)$countaug, 2, '.', '');

            $sephandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $sep . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $septimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $sep . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($sephandrepair == 0) {
                $sephandrepair = 0.001;
            }
            if ($septimeonrepairs == 0) {
                $septimeonrepairs = 0.001;
            }
            $countsep = ($sephandrepair / $septimeonrepairs) * 100;
            $wrenchtimesep = number_format((float)$countsep, 2, '.', '');

            $octhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $oct . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $octtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $oct . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($octhandrepair == 0) {
                $octhandrepair = 0.001;
            }
            if ($octtimeonrepairs == 0) {
                $octtimeonrepairs = 0.001;
            }
            $countoct = ($octhandrepair / $octtimeonrepairs) * 100;
            $wrenchtimeoct = number_format((float)$countoct, 2, '.', '');

            $novhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $nov . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $novtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $nov . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($novhandrepair == 0) {
                $novhandrepair = 0.001;
            }
            if ($novtimeonrepairs == 0) {
                $novtimeonrepairs = 0.001;
            }
            $countnov = ($novhandrepair / $novtimeonrepairs) * 100;
            $wrenchtimenov = number_format((float)$countnov, 2, '.', '');

            $deshandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $des . '%'],
                ['work_group', '=', $option],
            ])->sum('on_hand_repairs');
            $destimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $des . '%'],
                ['work_group', '=', $option],
            ])->sum('time_to_repairs');

            if ($deshandrepair == 0) {
                $deshandrepair = 0.001;
            }
            if ($destimeonrepairs == 0) {
                $destimeonrepairs = 0.001;
            }
            $countdes = ($deshandrepair / $destimeonrepairs) * 100;
            $wrenchtimedes = number_format((float)$countdes, 2, '.', '');

            $total = ($wrenchtimejan + $wrenchtimefeb + $wrenchtimemar + $wrenchtimeapr + $wrenchtimemay + $wrenchtimejun
                + $wrenchtimejul + $wrenchtimeaug + $wrenchtimesep + $wrenchtimeoct + $wrenchtimenov + $wrenchtimedes) / 12;
            $totalfix = number_format((float)$total, 2, '.', '');
        }

        return view('kpi.wrenchtimeinst', [
            'wrenchtime' => $wrenchtime,
            'thisyear' => $thisyear,
            'janhandrepair' => $janhandrepair,
            'febhandrepair' => $febhandrepair,
            'marhandrepair' => $marhandrepair,
            'aprhandrepair' => $aprhandrepair,
            'mayhandrepair' => $mayhandrepair,
            'junhandrepair' => $junhandrepair,
            'julhandrepair' => $julhandrepair,
            'aughandrepair' => $aughandrepair,
            'sephandrepair' => $sephandrepair,
            'octhandrepair' => $octhandrepair,
            'novhandrepair' => $novhandrepair,
            'deshandrepair' => $deshandrepair,
            'jantimeonrepairs' => $jantimeonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'wrenchtimejan' => $wrenchtimejan,
            'wrenchtimefeb' => $wrenchtimefeb,
            'wrenchtimemar' => $wrenchtimemar,
            'wrenchtimeapr' => $wrenchtimeapr,
            'wrenchtimemay' => $wrenchtimemay,
            'wrenchtimejun' => $wrenchtimejun,
            'wrenchtimejul' => $wrenchtimejul,
            'wrenchtimeaug' => $wrenchtimeaug,
            'wrenchtimesep' => $wrenchtimesep,
            'wrenchtimeoct' => $wrenchtimeoct,
            'wrenchtimenov' => $wrenchtimenov,
            'wrenchtimedes' => $wrenchtimedes,
            'namaunit' => $namaunit,
            'option' => $option,
            'totalwocr' => $totalwocr,
            'totalfix' => $totalfix,
        ]);
    }

    public function import()
    {
        Excel::import(new FileImport, request()->file('file'));
        return redirect('wrenchtimeinst')->with('success', 'File has been added succesfully!');
    }
}
