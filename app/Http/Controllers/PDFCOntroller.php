<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFCOntroller extends Controller
{
    public function PMCompliancePrintIndex()
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

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

        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TELECT'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework
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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Listrik 1-2';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TELECT';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TELECT' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

        return view(
            'kpi/pmcompliancepdf',
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

                // Reactive Work
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
                'totalwotactical' => $totalwotactical,
                'totalwonontactical' => $totalwonontactical,

                // Rework
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
                'tablereworktahun' => $tablereworktahun,

                //Wrench Time
                'getWrenchtime' => $getWrenchtime,
                'thisyear' => $thisyear,
                'janhandonrepairs' => $janhandonrepairs,
                'jantimeonrepairs' => $jantimeonrepairs,
                'janwrenchtime' => $janwrenchtime,
                'febhandonrepairs' => $febhandonrepairs,
                'febtimeonrepairs' => $febtimeonrepairs,
                'febwrenchtime' => $febwrenchtime,
                'marhandonrepairs' => $marhandonrepairs,
                'martimeonrepairs' => $martimeonrepairs,
                'marwrenchtime' => $marwrenchtime,
                'aprhandonrepairs' => $aprhandonrepairs,
                'aprtimeonrepairs' => $aprtimeonrepairs,
                'aprwrenchtime' => $aprwrenchtime,
                'mayhandonrepairs' => $mayhandonrepairs,
                'maytimeonrepairs' => $maytimeonrepairs,
                'maywrenchtime' => $maywrenchtime,
                'junhandonrepairs' => $junhandonrepairs,
                'juntimeonrepairs' => $juntimeonrepairs,
                'junwrenchtime' => $junwrenchtime,
                'julhandonrepairs' => $julhandonrepairs,
                'jultimeonrepairs' => $jultimeonrepairs,
                'julwrenchtime' => $julwrenchtime,
                'aughandonrepairs' => $aughandonrepairs,
                'augtimeonrepairs' => $augtimeonrepairs,
                'augwrenchtime' => $augwrenchtime,
                'sephandonrepairs' => $sephandonrepairs,
                'septimeonrepairs' => $septimeonrepairs,
                'sepwrenchtime' => $sepwrenchtime,
                'octhandonrepairs' => $octhandonrepairs,
                'octtimeonrepairs' => $octtimeonrepairs,
                'octwrenchtime' => $octwrenchtime,
                'novhandonrepairs' => $novhandonrepairs,
                'novtimeonrepairs' => $novtimeonrepairs,
                'novwrenchtime' => $novwrenchtime,
                'deshandonrepairs' => $deshandonrepairs,
                'destimeonrepairs' => $destimeonrepairs,
                'deswrenchtime' => $deswrenchtime,
            ]
        );
    }

    public function Print()
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

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

        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TELECT'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework
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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Listrik 1-2';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TELECT';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TELECT' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
            'tablereworktahun' => $tablereworktahun,

            // WrenchTime
            'getWrenchtime' => $getWrenchtime,
            'thisyear' => $thisyear,
            'janhandonrepairs' => $janhandonrepairs,
            'jantimeonrepairs' => $jantimeonrepairs,
            'janwrenchtime' => $janwrenchtime,
            'febhandonrepairs' => $febhandonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'febwrenchtime' => $febwrenchtime,
            'marhandonrepairs' => $marhandonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'marwrenchtime' => $marwrenchtime,
            'aprhandonrepairs' => $aprhandonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'aprwrenchtime' => $aprwrenchtime,
            'mayhandonrepairs' => $mayhandonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'maywrenchtime' => $maywrenchtime,
            'junhandonrepairs' => $junhandonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'junwrenchtime' => $junwrenchtime,
            'julhandonrepairs' => $julhandonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'julwrenchtime' => $julwrenchtime,
            'aughandonrepairs' => $aughandonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'augwrenchtime' => $augwrenchtime,
            'sephandonrepairs' => $sephandonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'sepwrenchtime' => $sepwrenchtime,
            'octhandonrepairs' => $octhandonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'octwrenchtime' => $octwrenchtime,
            'novhandonrepairs' => $novhandonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'novwrenchtime' => $novwrenchtime,
            'deshandonrepairs' => $deshandonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'deswrenchtime' => $deswrenchtime,
        ];

        $now = Carbon::now()->format('Y m d');
        $pdf = PDF::loadview('kpi.pmcompliancepdf', $data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Report Summary KPI' . ' ' . $namaunit . ' ' . $now . '.pdf');
    }

    public function PMCompliancePrintIndexListrik34()
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

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

        $option = 'TELECT3';
        $namaunit = 'Listrik 3-4';

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

        // Reactive Work

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

        // Rework

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
            'kpi/pmcompliancepdf34',
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

                // Reactive Work
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
                'totalwotactical' => $totalwotactical,
                'totalwonontactical' => $totalwonontactical,

                // Rework
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
            ]
        );
    }

    public function PrintListrik34()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $option = 'TELECT3';
        $namaunit = 'Listrik 3-4';
        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TELECT3'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework

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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Listrik 3-4';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TELECT34';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TELECT' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
            'tablereworktahun' => $tablereworktahun,

            // WrenchTime
            'getWrenchtime' => $getWrenchtime,
            'thisyear' => $thisyear,
            'janhandonrepairs' => $janhandonrepairs,
            'jantimeonrepairs' => $jantimeonrepairs,
            'janwrenchtime' => $janwrenchtime,
            'febhandonrepairs' => $febhandonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'febwrenchtime' => $febwrenchtime,
            'marhandonrepairs' => $marhandonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'marwrenchtime' => $marwrenchtime,
            'aprhandonrepairs' => $aprhandonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'aprwrenchtime' => $aprwrenchtime,
            'mayhandonrepairs' => $mayhandonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'maywrenchtime' => $maywrenchtime,
            'junhandonrepairs' => $junhandonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'junwrenchtime' => $junwrenchtime,
            'julhandonrepairs' => $julhandonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'julwrenchtime' => $julwrenchtime,
            'aughandonrepairs' => $aughandonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'augwrenchtime' => $augwrenchtime,
            'sephandonrepairs' => $sephandonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'sepwrenchtime' => $sepwrenchtime,
            'octhandonrepairs' => $octhandonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'octwrenchtime' => $octwrenchtime,
            'novhandonrepairs' => $novhandonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'novwrenchtime' => $novwrenchtime,
            'deshandonrepairs' => $deshandonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'deswrenchtime' => $deswrenchtime,
        ];

        $now = Carbon::now()->format('Y m d');
        $pdf = PDF::loadview('kpi.pmcompliancepdf34', $data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Report Summary KPI' . ' ' . $namaunit . ' ' . $now . '.pdf');
    }

    public function PMCompliancePrintIndexMech12()
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

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

        $option = 'TMECH';
        $namaunit = 'Mekanik 1-2';

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

        // Reactive Work

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

        // Rework

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
            'kpi/pmcompliancepdfmech12',
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

                // Reactive Work
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
                'totalwotactical' => $totalwotactical,
                'totalwonontactical' => $totalwonontactical,

                // Rework
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
            ]
        );
    }

    public function PrintMech12()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

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

        $option = 'TMECH';
        $namaunit = 'Mekanik 1-2';

        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework

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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Mekanik 1-2';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TMECH';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TMECH' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
            'tablereworktahun' => $tablereworktahun,

            // WrenchTime
            'getWrenchtime' => $getWrenchtime,
            'thisyear' => $thisyear,
            'janhandonrepairs' => $janhandonrepairs,
            'jantimeonrepairs' => $jantimeonrepairs,
            'janwrenchtime' => $janwrenchtime,
            'febhandonrepairs' => $febhandonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'febwrenchtime' => $febwrenchtime,
            'marhandonrepairs' => $marhandonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'marwrenchtime' => $marwrenchtime,
            'aprhandonrepairs' => $aprhandonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'aprwrenchtime' => $aprwrenchtime,
            'mayhandonrepairs' => $mayhandonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'maywrenchtime' => $maywrenchtime,
            'junhandonrepairs' => $junhandonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'junwrenchtime' => $junwrenchtime,
            'julhandonrepairs' => $julhandonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'julwrenchtime' => $julwrenchtime,
            'aughandonrepairs' => $aughandonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'augwrenchtime' => $augwrenchtime,
            'sephandonrepairs' => $sephandonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'sepwrenchtime' => $sepwrenchtime,
            'octhandonrepairs' => $octhandonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'octwrenchtime' => $octwrenchtime,
            'novhandonrepairs' => $novhandonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'novwrenchtime' => $novwrenchtime,
            'deshandonrepairs' => $deshandonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'deswrenchtime' => $deswrenchtime,
        ];

        $now = Carbon::now()->format('Y m d');
        $pdf = PDF::loadview('kpi.pmcompliancepdfmech12', $data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Report Summary KPI' . ' ' . $namaunit . ' ' . $now . '.pdf');
    }

    public function PMCompliancePrintIndexMech34()
    {
        $thisyear = Carbon::now()->format('Y');
        $notcomply = Carbon::now()->subMonth(1)->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->format('Y-m-d');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

        $option = 'TMECH34';
        $namaunit = 'Mekanik 3-4';

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

        // Reactive Work
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

        // Rework
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

        return view('kpi.pmcompliancepdfmech34', [
            'thisyear' => $thisyear,
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
            'option' => $option,
            'namaunit' => $namaunit,
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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
        ]);
    }

    public function Printmech34()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';

        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $option = 'TMECH34';
        $namaunit = 'Mekanik 3-4';
        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TMECH34'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework

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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Mekanik 3-4';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TMECH34';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TMECH34' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
            'tablereworktahun' => $tablereworktahun,

            // WrenchTime
            'getWrenchtime' => $getWrenchtime,
            'thisyear' => $thisyear,
            'janhandonrepairs' => $janhandonrepairs,
            'jantimeonrepairs' => $jantimeonrepairs,
            'janwrenchtime' => $janwrenchtime,
            'febhandonrepairs' => $febhandonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'febwrenchtime' => $febwrenchtime,
            'marhandonrepairs' => $marhandonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'marwrenchtime' => $marwrenchtime,
            'aprhandonrepairs' => $aprhandonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'aprwrenchtime' => $aprwrenchtime,
            'mayhandonrepairs' => $mayhandonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'maywrenchtime' => $maywrenchtime,
            'junhandonrepairs' => $junhandonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'junwrenchtime' => $junwrenchtime,
            'julhandonrepairs' => $julhandonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'julwrenchtime' => $julwrenchtime,
            'aughandonrepairs' => $aughandonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'augwrenchtime' => $augwrenchtime,
            'sephandonrepairs' => $sephandonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'sepwrenchtime' => $sepwrenchtime,
            'octhandonrepairs' => $octhandonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'octwrenchtime' => $octwrenchtime,
            'novhandonrepairs' => $novhandonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'novwrenchtime' => $novwrenchtime,
            'deshandonrepairs' => $deshandonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'deswrenchtime' => $deswrenchtime,
        ];

        $now = Carbon::now()->format('Y m d');
        $pdf = PDF::loadview('kpi.pmcompliancepdfmech34', $data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Report Summary KPI' . ' ' . $namaunit . ' ' . $now . '.pdf');
    }

    public function PMCompliancePrintIndexInst12()
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

        $option = 'TINST';
        $namaunit = 'Instrument 1-2';

        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work
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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework
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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        return view('kpi.pmcompliancepdftins12', [
            'thisyear' => $thisyear,
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
            'option' => $option,
            'namaunit' => $namaunit,
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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
        ]);
    }

    public function PrintInst12()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';
        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $option = 'TINST';
        $namaunit = 'Instrument 1-2';
        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TINST'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework

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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Instrument 1-2';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TINST';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TINST' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
            'tablereworktahun' => $tablereworktahun,

            // WrenchTime
            'getWrenchtime' => $getWrenchtime,
            'thisyear' => $thisyear,
            'janhandonrepairs' => $janhandonrepairs,
            'jantimeonrepairs' => $jantimeonrepairs,
            'janwrenchtime' => $janwrenchtime,
            'febhandonrepairs' => $febhandonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'febwrenchtime' => $febwrenchtime,
            'marhandonrepairs' => $marhandonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'marwrenchtime' => $marwrenchtime,
            'aprhandonrepairs' => $aprhandonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'aprwrenchtime' => $aprwrenchtime,
            'mayhandonrepairs' => $mayhandonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'maywrenchtime' => $maywrenchtime,
            'junhandonrepairs' => $junhandonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'junwrenchtime' => $junwrenchtime,
            'julhandonrepairs' => $julhandonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'julwrenchtime' => $julwrenchtime,
            'aughandonrepairs' => $aughandonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'augwrenchtime' => $augwrenchtime,
            'sephandonrepairs' => $sephandonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'sepwrenchtime' => $sepwrenchtime,
            'octhandonrepairs' => $octhandonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'octwrenchtime' => $octwrenchtime,
            'novhandonrepairs' => $novhandonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'novwrenchtime' => $novwrenchtime,
            'deshandonrepairs' => $deshandonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'deswrenchtime' => $deswrenchtime,
        ];

        $now = Carbon::now()->format('Y m d');
        $pdf = PDF::loadview('kpi.pmcompliancepdftinst12', $data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Report Summary KPI' . ' ' . $namaunit . ' ' . $now . '.pdf');
    }

    public function PMCompliancePrintIndexInst34()
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

        $option = 'TINST34';
        $namaunit = 'Instrument 3-4';

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

        // Reactive Work
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

        // Rework
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

        return view('kpi.pmcompliancepdftins34', [
            'thisyear' => $thisyear,
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
            'option' => $option,
            'namaunit' => $namaunit,
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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
        ]);
    }

    public function PrintInst34()
    {
        $thisyear = Carbon::now()->format('Y');
        $jan = $thisyear . '-01';
        $feb = $thisyear . '-02';
        $mar = $thisyear . '-03';
        $apr = $thisyear . '-04';
        $may = $thisyear . '-05';
        $jun = $thisyear . '-06';
        $jul = $thisyear . '-07';
        $aug = $thisyear . '-08';
        $sep = $thisyear . '-09';
        $oct = $thisyear . '-10';
        $nov = $thisyear . '-11';
        $des = $thisyear . '-12';
        $year1 = Carbon::now()->subYears(7)->format('Y');
        $year2 = Carbon::now()->subYears(6)->format('Y');
        $year3 = Carbon::now()->subYears(5)->format('Y');
        $year4 = Carbon::now()->subYears(4)->format('Y');
        $year5 = Carbon::now()->subYears(3)->format('Y');
        $year6 = Carbon::now()->subYears(2)->format('Y');
        $year7 = Carbon::now()->subYears(1)->format('Y');

        $option = 'TINST34';
        $namaunit = 'Instrument 3-4';
        $parse = Carbon::parse('now');
        $getMonth = $parse->month;

        $notcomply = Carbon::now()->format('Y-m-d');
        $notcomplydate = Carbon::now()->setMonth(1)->setDay(1)->format('Y-m-d');

        $tablepmnotcomply = DB::table('msf620')
            ->join('msf623', 'msf623.work_order', '=', 'msf620.work_order')
            ->where([
                ['msf620.work_group', '=', 'TINST34'],
                ['msf620.maint_type', '=', 'PM'],
                ['msf620.wo_status_m', '=', 'C'],
            ])
            ->whereBetween('msf620.plan_fin_date', [$notcomplydate, $notcomply])
            ->whereNull('msf623.completion_comment')
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
            + $pmcompliancenovfix + $pmcompliancedesfix) / $getMonth;

        $totalkpifix = number_format((float)$totalkpi, 2, '.', '');

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

        // Reactive Work

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

        // Total KPI Persen
        $totalreactivework = ($reactiveworkjanfix + $reactiveworkfebfix + $reactiveworkmarfix + $reactiveworkaprfix + $reactiveworkmayfix
            + $reactiveworkjunfix + $reactiveworkjulfix + $reactiveworkaugfix + $reactiveworksepfix + $reactiveworkoctfix
            + $reactiveworknovfix + $reactiveworkdesfix) / $getMonth;

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

        // Rework

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
            ->get();

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
        ) / $getMonth;
        $totalreworkfix = number_format((float)$totalrework, 2, '.', '');

        $namaunit = 'Instrument 3-4';
        $thisyear = Carbon::now()->format('Y');
        $option = 'TINST34';
        $start = 0101;
        $end = 1231;
        $getWrenchtime = DB::connection('oracle')->select(
            "SELECT DISTINCT
                t.work_order wo_number,
                t.plant_no plant_no,
                t.wo_desc description_wo,
                t.work_group work_group_header,
                t.wo_status_m wo_status,
                t.maint_type mt_type,
                t.start_repair start_repair_date,
                t.start_time start_repair_time,
                t.stop_repair stop_repair_date,
                t.finish_time stop_repair_time,
                t.working_days,
                (to_number(SubStr(To_Char(t.average_hour), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.average_hour), 12, 2)) +
                (to_number(SubStr(To_Char(t.average_hour), 15, 2)) / 60) average_hours,
                
                (to_number(SubStr(To_Char(t.on_hand_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.on_hand_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.on_hand_repair), 15, 2)) / 60) on_hand_repairs,
                
                (to_number(SubStr(To_Char(t.time_to_repair), 1, 10)) * 24) +
                to_number(SubStr(To_Char(t.time_to_repair), 12, 2)) +
                (to_number(SubStr(To_Char(t.time_to_repair), 15, 2)) / 60) time_to_repairs
                
                FROM(
                SELECT
                a.*,
                SubStr(a.min_job_date, 1, 8) start_repair,
                SubStr(a.max_job_date, 1, 8) stop_repair,
                To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1 working_days,
                SubStr(a.min_job_date, 9, 4) start_time,
                SubStr(a.max_job_date, 13, 4) finish_time,
                
                ((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2 average_hour,
                
                ((To_Date(SubStr(max_job_date, 1, 8), 'yyyymmdd') - To_Date(SubStr(min_job_date, 1, 8), 'yyyymmdd') + 1) *
                (((to_timestamp(SubStr(a.min_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.min_job_date, 9, 4), 'HH24:MI'))+
                (to_timestamp(SubStr(a.max_job_date, 13, 4), 'HH24:MI')-to_timestamp(SubStr(a.max_job_date, 9, 4), 'HH24:MI')))/2)) on_hand_repair,
                
                (to_timestamp(SubStr(a.max_job_date, 1, 8) || ' ' || SubStr(a.max_job_date, 13, 4), 'YYYYMMDD HH24:MI') -
                to_timestamp(SubStr(a.min_job_date, 1, 8) || ' ' || SubStr(a.min_job_date, 9, 4), 'YYYYMMDD HH24:MI')) time_to_repair
                FROM (
                SELECT
                a.dstrct_code,
                a.work_order,
                a.wo_desc,
                a.wo_status_m,
                c.plant_no,
                a.work_group,
                a.maint_type,
                b.job_dur_date,
                b.seq_no,
                b.job_dur_start,
                b.job_dur_finish,
                b.job_dur_hours,
                Row_Number() OVER (
                    PARTITION BY 
                    b.dstrct_code, b.work_order 
                    ORDER BY 
                    b.dstrct_code, b.work_order, b.job_dur_date, b.seq_no
                ) rn,
                Min(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) min_job_date,
                Max(job_dur_date||job_dur_start||job_dur_finish) OVER (PARTITION BY b.dstrct_code, b.work_order) max_job_date
                FROM
                    ellipse.msf620 a,
                    ellipse.msf622 b,
                    ellipse.msf600 c
                WHERE
                    TRIM(a.work_group) LIKE 'TINST34' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$thisyear+$start' AND '$thisyear$end'
                ORDER BY
                    a.work_order,
                    b.job_dur_date,
                    b.seq_no
                ) a
                ) t
                
                ORDER BY
                t.work_order,
                t.work_group"
        );

        $janhandonrepairs = 0;
        $jantimeonrepairs = 0;
        $janwrenchtime = 0;

        $febhandonrepairs = 0;
        $febtimeonrepairs = 0;
        $febwrenchtime = 0;

        $marhandonrepairs = 0;
        $martimeonrepairs = 0;
        $marwrenchtime = 0;

        $aprhandonrepairs = 0;
        $aprtimeonrepairs = 0;
        $aprwrenchtime = 0;

        $mayhandonrepairs = 0;
        $maytimeonrepairs = 0;
        $maywrenchtime = 0;

        $junhandonrepairs = 0;
        $juntimeonrepairs = 0;
        $junwrenchtime = 0;

        $julhandonrepairs = 0;
        $jultimeonrepairs = 0;
        $julwrenchtime = 0;

        $aughandonrepairs = 0;
        $augtimeonrepairs = 0;
        $augwrenchtime = 0;

        $sephandonrepairs = 0;
        $septimeonrepairs = 0;
        $sepwrenchtime = 0;

        $octhandonrepairs = 0;
        $octtimeonrepairs = 0;
        $octwrenchtime = 0;

        $novhandonrepairs = 0;
        $novtimeonrepairs = 0;
        $novwrenchtime = 0;

        $deshandonrepairs = 0;
        $destimeonrepairs = 0;
        $deswrenchtime = 0;

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

            // Reactive Work
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
            'totalwotactical' => $totalwotactical,
            'totalwonontactical' => $totalwonontactical,

            // Rework
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
            'tablereworktahun' => $tablereworktahun,

            // WrenchTime
            'getWrenchtime' => $getWrenchtime,
            'thisyear' => $thisyear,
            'janhandonrepairs' => $janhandonrepairs,
            'jantimeonrepairs' => $jantimeonrepairs,
            'janwrenchtime' => $janwrenchtime,
            'febhandonrepairs' => $febhandonrepairs,
            'febtimeonrepairs' => $febtimeonrepairs,
            'febwrenchtime' => $febwrenchtime,
            'marhandonrepairs' => $marhandonrepairs,
            'martimeonrepairs' => $martimeonrepairs,
            'marwrenchtime' => $marwrenchtime,
            'aprhandonrepairs' => $aprhandonrepairs,
            'aprtimeonrepairs' => $aprtimeonrepairs,
            'aprwrenchtime' => $aprwrenchtime,
            'mayhandonrepairs' => $mayhandonrepairs,
            'maytimeonrepairs' => $maytimeonrepairs,
            'maywrenchtime' => $maywrenchtime,
            'junhandonrepairs' => $junhandonrepairs,
            'juntimeonrepairs' => $juntimeonrepairs,
            'junwrenchtime' => $junwrenchtime,
            'julhandonrepairs' => $julhandonrepairs,
            'jultimeonrepairs' => $jultimeonrepairs,
            'julwrenchtime' => $julwrenchtime,
            'aughandonrepairs' => $aughandonrepairs,
            'augtimeonrepairs' => $augtimeonrepairs,
            'augwrenchtime' => $augwrenchtime,
            'sephandonrepairs' => $sephandonrepairs,
            'septimeonrepairs' => $septimeonrepairs,
            'sepwrenchtime' => $sepwrenchtime,
            'octhandonrepairs' => $octhandonrepairs,
            'octtimeonrepairs' => $octtimeonrepairs,
            'octwrenchtime' => $octwrenchtime,
            'novhandonrepairs' => $novhandonrepairs,
            'novtimeonrepairs' => $novtimeonrepairs,
            'novwrenchtime' => $novwrenchtime,
            'deshandonrepairs' => $deshandonrepairs,
            'destimeonrepairs' => $destimeonrepairs,
            'deswrenchtime' => $deswrenchtime,
        ];

        $now = Carbon::now()->format('Y m d');
        $pdf = PDF::loadview('kpi.pmcompliancepdftinst34', $data);
        $pdf->set_paper('A4', 'landscape');
        return $pdf->stream('Report Summary KPI' . ' ' . $namaunit . ' ' . $now . '.pdf');
    }
}
