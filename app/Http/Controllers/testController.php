<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class testController extends Controller
{
    public function testIndex()
    {
        //$test = DB::connection('kkk') // tow database
            //->table('msdf');
        $view = DB::table('msf620')
            ->where([
                ['maint_type', '=', 'PM'],
                ['work_group', '=', 'TELECT'],
                ['creation_date', 'LIKE', "%2022-11%"]
            ])
            ->orderBy('creation_date', 'desc')
            ->paginate(20);

        $count = DB::table('msf620')
            ->where([
                ['maint_type', '=', 'PM'],
                ['work_group', '=', 'TELECT'],
                ['creation_date', 'LIKE', "%2022-11%"]
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        return view('testPage', ['datatest' => $view, 'countTest' => $count]);
    }
}
