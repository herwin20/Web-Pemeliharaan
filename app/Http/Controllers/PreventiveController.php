<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreventiveController extends Controller
{
    public function PreventiveClosed(Request $request)
    {
        $pmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['wo_status_m', '=', 'C'],
                ['maint_type', '=', 'PM']
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        if ($request->name) {
            $pmclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'C'],
                    ['maint_type', '=', 'PM'],
                    ['wo_desc', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        } else {
            $pmclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'C'],
                    ['maint_type', '=', 'PM']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        }

        return view('preventive/pmclosed', ['viewpmclosed' => $pmclosed]);
    }

    public function PreventiveNotClosed(Request $request)
    {
        $pmnotclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['wo_status_m', '=', 'A'],
                ['maint_type', '=', 'PM']
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        if ($request->name) {
            $pmnotclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'A'],
                    ['maint_type', '=', 'PM'],
                    ['wo_desc', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        } else {
            $pmnotclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'A'],
                    ['maint_type', '=', 'PM']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        }

        return view('preventive/pmnotclosed', ['viewpmnotclosed' => $pmnotclosed]);
    }
}
