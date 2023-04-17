<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class CurrentGT11
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {

        $currentgt131 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt132 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE621 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt133 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE631 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt121 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt122 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE621 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt123 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE631 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt111 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt112 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE621 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $currentgt113 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE631 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $label = DB::connection('pgsql')->table('history')
            ->selectRaw('date_rec')
            ->where('address_no', '=', '13MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('date_rec');

        return $this->chart->lineChart()
            ->setTitle('Arus 3 GT Blok 1')
            ->setSubtitle(date('m-Y'))
            ->addData('CurrentGT13-1', $currentgt131->toArray())
            ->addData('CurrentGT13-2', $currentgt132->toArray())
            ->addData('CurrentGT13-3', $currentgt133->toArray())
            ->addData('CurrentGT12-1', $currentgt121->toArray())
            ->addData('CurrentGT12-2', $currentgt122->toArray())
            ->addData('CurrentGT12-3', $currentgt123->toArray())
            ->addData('CurrentGT11-1', $currentgt111->toArray())
            ->addData('CurrentGT11-2', $currentgt112->toArray())
            ->addData('CurrentGT11-3', $currentgt113->toArray())
            ->setLabels($label->toArray());
    }
}
