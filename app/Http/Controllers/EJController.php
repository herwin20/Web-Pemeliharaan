<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EJController extends Controller
{
    public function EJClosed(Request $request)
    {
        $ejclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['wo_status_m', '=', 'C'],
                ['maint_type', '=', 'EJ']
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        if ($request->name) {
            $ejclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'C'],
                    ['maint_type', '=', 'EJ'],
                    ['wo_desc', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        } else {
            $ejclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'C'],
                    ['maint_type', '=', 'EJ']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        }

        return view('ej/ejclosed', ['viewejclosed' => $ejclosed]);
    }

    public function EJNotClosed(Request $request)
    {
        $ejnotclosed = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['wo_status_m', '=', 'O'],
                ['maint_type', '=', 'EJ']
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        if ($request->name) {
            $ejnotclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'O'],
                    ['maint_type', '=', 'EJ'],
                    ['wo_desc', 'like', '%' . $request->name . '%']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        } else {
            $ejnotclosed = DB::table('msf620')
                ->where([
                    ['work_group', '=', 'TELECT'],
                    ['wo_status_m', '=', 'O'],
                    ['maint_type', '=', 'EJ']
                ])
                ->orderBy('creation_date', 'desc')
                ->paginate(20);
        }

        return view('ej/ejnotclosed', ['viewejnotclosed' => $ejnotclosed]);
    }
}
