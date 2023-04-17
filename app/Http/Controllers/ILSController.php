<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class ILSController extends Controller
{
    public function ILSToday()
    {
        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $thisyear = Carbon::now()->format('Y');
        $ilstoday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $today]
            ])
            ->orderBy('raised_date', 'desc')
            ->paginate(25);

        $totalilstoday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $today]
            ])
            ->orderBy('raised_date', 'desc')
            ->count();

        $totalilsyesterday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $yesterday]
            ])
            ->orderBy('raised_date', 'desc')
            ->count();

        $totalilsurgenttoday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $today],
                ['priority_cde_541', '=', 'C']
            ])
            ->orderBy('raised_date', 'desc')
            ->count();

        $totalilsurgentyesterday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $yesterday],
                ['priority_cde_541', '=', 'C']
            ])
            ->orderBy('raised_date', 'desc')
            ->count();

        $totalilsclosedyear = DB::table('msf541')
            ->where([
                ['closed_date', 'LIKE', '%' . $thisyear . '%'],
                ['raised_date', 'LIKE', '%' . $thisyear . '%'],
                ['corrective_desc', 'NOT LIKE', "%FLM%"],
            ])
            ->orderBy('raised_date', 'desc')
            ->count();

        $totalilsopendyear = DB::table('msf541')
            ->whereNull('closed_date')
            ->where([
                ['raised_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('raised_date', 'desc')
            ->count();

        return view(
            'ils/ilstoday',
            [
                'listilstoday' => $ilstoday,
                'totalilstoday' => $totalilstoday,
                'totalilsyesterday' => $totalilsyesterday,
                'totalilsurgenttoday' => $totalilsurgenttoday,
                'totalilsurgentyesterday' => $totalilsurgentyesterday,
                'totalilsclosedyear' => $totalilsclosedyear,
                'totalilsopendyear' => $totalilsopendyear,
                'tahunini' => $thisyear
            ]
        );
    }

    public function ILSUrgent()
    {
        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $thisyear = Carbon::now()->format('Y');

        $ilsurgenttoday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $today],
                ['priority_cde_541', '=', 'C']
            ])
            ->orderBy('raised_date', 'desc')
            ->paginate(10);

        $ilsurgentyesterday = DB::table('msf541')
            ->where([
                ['raised_date', '=', $yesterday],
                ['priority_cde_541', '=', 'C']
            ])
            ->orderBy('raised_date', 'desc')
            ->paginate(10);

        return view(
            'ils/ilsurgent',
            [
                'ilsurgenttabletoday' => $ilsurgenttoday,
                'ilsurgenttableyesterday' => $ilsurgentyesterday,
            ]
        );
    }

    public function ILSClosed(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');

        if ($request->name) {
            $tableilsclosedyear = DB::table('msf541')
                ->where([
                    ['closed_date', 'LIKE', '%' . $thisyear . '%'],
                    ['raised_date', 'LIKE', '%' . $thisyear . '%'],
                    ['corrective_desc', 'LIKE', '%' . $request->name . '%'],
                ])
                ->orderBy('raised_date', 'desc')
                ->paginate(20);
        } else {
            $tableilsclosedyear = DB::table('msf541')
                ->where([
                    ['closed_date', 'LIKE', '%' . $thisyear . '%'],
                    ['raised_date', 'LIKE', '%' . $thisyear . '%'],
                    ['corrective_desc', 'NOT LIKE', "%FLM%"],
                ])
                ->orderBy('raised_date', 'desc')
                ->paginate(20);
        }

        return view(
            'ils/ilsclosed',
            [
                'thisyear' => $thisyear,
                'tableilsclosed' => $tableilsclosedyear
            ]
        );
    }

    public function ILSOpen(Request $request)
    {
        $thisyear = Carbon::now()->format('Y');

        if ($request->name) {
            $tableilsopenyear = DB::table('msf541')
                ->whereNull('closed_date')
                ->where([
                    ['raised_date', 'LIKE', '%' . $thisyear . '%'],
                    ['corrective_desc', 'LIKE', '%' . $request->name . '%'],
                ])
                ->orderBy('raised_date', 'desc')
                ->paginate(20);
        } else {
            $tableilsopenyear = DB::table('msf541')
                ->whereNull('closed_date')
                ->where([
                    ['raised_date', 'LIKE', '%' . $thisyear . '%']
                ])
                ->orderBy('raised_date', 'desc')
                ->paginate(20);
        }

        return view(
            'ils/ilsopen',
            [
                'thisyear' => $thisyear,
                'tableilsopen' => $tableilsopenyear
            ]
        );
    }
}
