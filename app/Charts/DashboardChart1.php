<?php

namespace App\Charts;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardChart1
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $thisyear = Carbon::now()->format('Y');
        $jumlahwopm = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopm3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwopm5 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'PM'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwocr = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwocr3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwocr5 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'CR'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoej = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT'],
                ['maint_type', '=', 'EJ'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoej3 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'TELECT3'],
                ['maint_type', '=', 'EJ'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        $jumlahwoej5 = DB::table('msf620')
            ->where([
                ['work_group', '=', 'ELECGU'],
                ['maint_type', '=', 'EJ'],
                ['creation_date', 'LIKE', '%' . $thisyear . '%']
            ])
            ->orderBy('creation_date', 'desc')
            ->count();

        return $this->chart->barChart()
            ->setTitle('Jumlah WO Per Blok')
            ->setSubtitle(date('M Y'))
            ->addData('PM', [$jumlahwopm, $jumlahwopm3, $jumlahwopm5])
            ->addData('CR', [$jumlahwocr, $jumlahwocr3, 2])
            ->addData('EJ', [$jumlahwoej, $jumlahwoej3, 2])
            ->setXAxis(['Blok 1-2', 'Blok 3-4', 'Blok 5']);
    }
}
