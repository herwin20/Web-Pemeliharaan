<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WrenchTime;
use App\Imports\FileImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WrenchTimeController extends Controller
{
    //
    /*public function index(Request $request)
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

        $option = $request->bidang;

        $namaunit = 'Listrik 1-2';

        // TNS String di Yajra
        /*$conn = oci_connect('ellview', 'PJBb3gr3@t', '(DESCRIPTION = 
        (ADDRESS_LIST = 
            (ADDRESS = 
                (PROTOCOL = TCP)
                (HOST = 192.168.3.205)
                (PORT = 1521)
            )
        )
        (CONNECT_DATA = 
            (SERVER = DEDICATED)
            (SID = ELLPRD)
        )
        )');

        $bidang = 'TELECT';

        $test = DB::connection('oracle')->select("SELECT DISTINCT
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
            TRIM(a.work_group) LIKE '$bidang' AND
            a.wo_status_m in ('C','O','A') AND
            a.equip_no = c.equip_no AND
            a.work_order = b.work_order AND
            a.dstrct_code = b.dstrct_code AND
            a.dstrct_code LIKE 'UPMT' AND
            a.raised_date BETWEEN '20230101' AND '20230601'
          ORDER BY
            a.work_order,
            b.job_dur_date,
            b.seq_no
        ) a
        ) t
        
        ORDER BY
        t.work_order,
        t.work_group");
        //$test = DB::connection('oracle')->select('select count(0) FROM ellipse.msf220');
        dd($test);

        $wrenchtime = WrenchTime::where('work_group', '=', 'TELECT')
            ->paginate(5);

        $janhandrepair = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $jan . '%'],
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $jantimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $jan . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $febtimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $feb . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $martimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $mar . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $aprtimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $apr . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $maytimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $may . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $juntimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $jun . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $jultimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $jul . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $augtimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $aug . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $septimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $sep . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $octtimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $oct . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $novtimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $nov . '%'],
            ['work_group', '=', 'TELECT'],
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
            ['work_group', '=', 'TELECT'],
        ])->sum('on_hand_repairs');
        $destimeonrepairs = WrenchTime::where([
            ['start_repair_date', 'LIKE', '%' . $des . '%'],
            ['work_group', '=', 'TELECT'],
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

        if ($request->bidang) {

            $totalwocr = WrenchTime::where('work_group', 'LIKE', '%' . $request->bidang . '%')->count();

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
            $totalwocr = WrenchTime::where('work_group', '=', 'TELECT')->count();
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

            $wrenchtime = WrenchTime::where('work_group', '=', 'TELECT')
                ->paginate(5);

            $janhandrepair = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jan . '%'],
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $jantimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jan . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $febtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $feb . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $martimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $mar . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $aprtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $apr . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $maytimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $may . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $juntimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jun . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $jultimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $jul . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $augtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $aug . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $septimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $sep . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $octtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $oct . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $novtimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $nov . '%'],
                ['work_group', '=', 'TELECT'],
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
                ['work_group', '=', 'TELECT'],
            ])->sum('on_hand_repairs');
            $destimeonrepairs = WrenchTime::where([
                ['start_repair_date', 'LIKE', '%' . $des . '%'],
                ['work_group', '=', 'TELECT'],
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

        return view('kpi.wrenchtime', [
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
    } */

    public function index(Request $request)
    {

        if ($request->bidang && $request->tahun) {
            $option = $request->bidang;
            $optiontahun = $request->tahun;

            $thisyear = Carbon::now()->format('Y');
            $thisyear2 = Carbon::now()->format('Y');
            $year1 = Carbon::now()->subYears(1)->format('Y');
            $year2 = Carbon::now()->subYears(2)->format('Y');
            $year3 = Carbon::now()->subYears(3)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');

            $start = 0101;
            $end = 1231;

            if ($request->bidang == 'TELECT') {
                $namaunit = 'Listrik 1-2';
            }
            if ($request->bidang == 'TELECT3') {
                $namaunit = 'Listrik 3-4';
            }
            if ($request->bidang == 'TELECT5') {
                $namaunit = 'Listrik 5';
            }
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
                    TRIM(a.work_group) LIKE '$request->bidang' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$request->tahun+$start' AND '$request->tahun$end'
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
        } else {
            $namaunit = 'Listrik 1-2';
            $thisyear = Carbon::now()->format('Y');
            $thisyear2 = Carbon::now()->format('Y');
            $year1 = Carbon::now()->subYears(1)->format('Y');
            $year2 = Carbon::now()->subYears(2)->format('Y');
            $year3 = Carbon::now()->subYears(3)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');
            $option = 'TELECT';
            $optiontahun = $thisyear2;
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
        }

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

        return view('kpi.wrenchtime', [
            'getWrenchtime' => $getWrenchtime,
            'option' => $option,
            'optiontahun' => $optiontahun,
            'namaunit' => $namaunit,
            'thisyear' => $thisyear,
            'year1' => $year1,
            'year2' => $year2,
            'year3' => $year3,
            'year4' => $year4,

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
        ]);
    }

    public function indexMech(Request $request)
    {

        if ($request->bidang && $request->tahun) {
            $option = $request->bidang;
            $optiontahun = $request->tahun;

            $thisyear = Carbon::now()->format('Y');
            $thisyear2 = Carbon::now()->format('Y');
            $year1 = Carbon::now()->subYears(1)->format('Y');
            $year2 = Carbon::now()->subYears(2)->format('Y');
            $year3 = Carbon::now()->subYears(3)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');

            $start = 0101;
            $end = 1231;

            if ($request->bidang == 'TMECH') {
                $namaunit = 'Mekanik 1-2';
            }
            if ($request->bidang == 'TMECH34') {
                $namaunit = 'Mekanik 3-4';
            }
            if ($request->bidang == 'TMECH5') {
                $namaunit = 'Mekanik 5';
            }
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
                    TRIM(a.work_group) LIKE '$request->bidang' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$request->tahun+$start' AND '$request->tahun$end'
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
        } else {
            $namaunit = 'Mekanik 1-2';
            $thisyear = Carbon::now()->format('Y');
            $thisyear2 = Carbon::now()->format('Y');
            $year1 = Carbon::now()->subYears(1)->format('Y');
            $year2 = Carbon::now()->subYears(2)->format('Y');
            $year3 = Carbon::now()->subYears(3)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');
            $option = 'TMECH';
            $optiontahun = $thisyear2;
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
        }

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

        return view('kpi.wrenchtimemech', [
            'getWrenchtime' => $getWrenchtime,
            'option' => $option,
            'optiontahun' => $optiontahun,
            'namaunit' => $namaunit,
            'thisyear' => $thisyear,
            'year1' => $year1,
            'year2' => $year2,
            'year3' => $year3,
            'year4' => $year4,

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
        ]);
    }

    public function indexInst(Request $request)
    {

        if ($request->bidang && $request->tahun) {
            $option = $request->bidang;
            $optiontahun = $request->tahun;

            $thisyear = Carbon::now()->format('Y');
            $thisyear2 = Carbon::now()->format('Y');
            $year1 = Carbon::now()->subYears(1)->format('Y');
            $year2 = Carbon::now()->subYears(2)->format('Y');
            $year3 = Carbon::now()->subYears(3)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');

            $start = 0101;
            $end = 1231;

            if ($request->bidang == 'TINST') {
                $namaunit = 'Instrument 1-2';
            }
            if ($request->bidang == 'TMECH34') {
                $namaunit = 'Instrument 3-4';
            }
            if ($request->bidang == 'TMECH5') {
                $namaunit = 'Instrument 5';
            }
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
                    TRIM(a.work_group) LIKE '$request->bidang' AND
                    a.wo_status_m in ('C','O','A') AND
                    a.equip_no = c.equip_no AND
                    a.work_order = b.work_order AND
                    a.dstrct_code = b.dstrct_code AND
                    a.dstrct_code LIKE 'UPMT' AND
                    a.raised_date BETWEEN '$request->tahun+$start' AND '$request->tahun$end'
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
        } else {
            $namaunit = 'Instrument 1-2';
            $thisyear = Carbon::now()->format('Y');
            $thisyear2 = Carbon::now()->format('Y');
            $year1 = Carbon::now()->subYears(1)->format('Y');
            $year2 = Carbon::now()->subYears(2)->format('Y');
            $year3 = Carbon::now()->subYears(3)->format('Y');
            $year4 = Carbon::now()->subYears(4)->format('Y');
            $option = 'TINST';
            $optiontahun = $thisyear2;
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
        }

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

        return view('kpi.wrenchtimeinst', [
            'getWrenchtime' => $getWrenchtime,
            'option' => $option,
            'optiontahun' => $optiontahun,
            'namaunit' => $namaunit,
            'thisyear' => $thisyear,
            'year1' => $year1,
            'year2' => $year2,
            'year3' => $year3,
            'year4' => $year4,

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
        ]);
    }

    public function import()
    {
        Excel::import(new FileImport, request()->file('file'));
        return redirect('wrench-time')->with('success', 'File has been added succesfully!');
    }
}
