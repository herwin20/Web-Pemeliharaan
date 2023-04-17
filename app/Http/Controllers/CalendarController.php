<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    #code ..
    public function indexcalendar(Request $request)
    {

        $option = 'TELECT';
        $namaunit = 'Listrik 1-2';
        $thisyear = Carbon::now()->format('Y');

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
            $kerjaan = array();
            $event = DB::table('msf620')
                ->where([
                    ['work_group', '=',  $request->bidang],
                    ['maint_type', '=', 'PM'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['work_group', '=',  $request->bidang],
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
        } else {
            $kerjaan = array();
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
        }

        return view('reportpekerjaan.jadwal-kegiatan', [
            'kerjaan' => $kerjaan,
            'option' => $option,
            'namaunit' => $namaunit,
        ]);
    }

    public function indexcalendarmech(Request $request)
    {

        $option = 'TMECH';
        $namaunit = 'Mekanik 1-2';
        $thisyear = Carbon::now()->format('Y');

        if ($request->bidang) {
            $option = $request->bidang;

            if ($request->bidang == 'TMECH') {
                $namaunit = 'Mekanik 1-2';
            }
            if ($request->bidang == 'TMECH34') {
                $namaunit = 'Mekanik 3-4';
            }
            if ($request->bidang == 'TMECH5') {
                $namaunit = 'Mekanik 5';
            }
            $kerjaan = array();
            $event = DB::table('msf620')
                ->where([
                    ['work_group', '=',  $request->bidang],
                    ['maint_type', '=', 'PM'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['work_group', '=',  $request->bidang],
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
        } else {
            $kerjaan = array();
            $event = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TMECH'],
                    ['maint_type', '=', 'PM'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['work_group', '=', 'TMECH'],
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
        }

        return view('reportpekerjaan.jadwal-kegiatan-mech', [
            'kerjaan' => $kerjaan,
            'option' => $option,
            'namaunit' => $namaunit,
        ]);
    }

    public function indexcalendarinst(Request $request)
    {

        $option = 'TINST';
        $namaunit = 'Instrumen 1-2';
        $thisyear = Carbon::now()->format('Y');

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
            $kerjaan = array();
            $event = DB::table('msf620')
                ->where([
                    ['work_group', '=',  $request->bidang],
                    ['maint_type', '=', 'PM'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['work_group', '=',  $request->bidang],
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
        } else {
            $kerjaan = array();
            $event = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TINST'],
                    ['maint_type', '=', 'PM'],
                    ['creation_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orWhere([
                    ['work_group', '=', 'TINST'],
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
        }

        return view('reportpekerjaan.jadwal-kegiatan-inst', [
            'kerjaan' => $kerjaan,
            'option' => $option,
            'namaunit' => $namaunit,
        ]);
    }
}
