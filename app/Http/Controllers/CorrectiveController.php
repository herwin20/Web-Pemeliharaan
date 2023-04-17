<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CorrectiveController extends Controller
{
    public function CorrectiveClosed(Request $request)
    {
        $cmclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['wo_status_m', '=', 'C'],
                ['maint_type', '=', 'CR']
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        if ($request->name) {
            $cmclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'C'],
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        } else {
            $cmclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'C'],
                    ['maint_type', '=', 'CR']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        }

        return view('corrective/cmclosed', ['viewcmclosed' => $cmclosed]);
    }

    public function CorrectiveNotClosed(Request $request)
    {
        $cmnotclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['wo_status_m', '=', 'O'],
                ['maint_type', '=', 'CR']
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        if ($request->name) {
            $cmnotclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'O'],
                    ['maint_type', '=', 'CR'],
                    ['wo_desc', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        } else {
            $cmnotclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'O'],
                    ['maint_type', '=', 'CR']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        }

        return view('corrective/cmnotclosed', ['viewcmnotclosed' => $cmnotclosed]);
    }
}
