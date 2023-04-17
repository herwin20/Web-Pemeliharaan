<?php

namespace App\Charts;

use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class VoltageChartGT
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    #12MKA10CE104 XQ50 L1-L2
    #12MKA10CE105 XQ50 L2-L3
    #12MKA10CE106 XQ50 L1-L3


    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {

        $voltageGT11L1 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE104 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT11L2 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE105 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT11L3 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '11MKA10CE106 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT12L1 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE104 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT12L2 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE105 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT12L3 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '12MKA10CE106 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT13L1 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE104 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT13L2 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE105 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $voltageGT13L3 = DB::connection('pgsql')->table('history')
            ->selectRaw('value')
            ->where('address_no', '=', '13MKA10CE106 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('value');

        $label = DB::connection('pgsql')->table('history')
            ->selectRaw('date_rec')
            ->where('address_no', '=', '13MKA10CE611 XQ50')
            ->orderBy('date_rec', 'desc')
            ->limit(50)->pluck('date_rec');


        return $this->chart->lineChart()
            ->setTitle('Tegangan GT Blok 1')
            ->setSubtitle(date("m-Y"))
            ->addData('VoltageGT11L1', $voltageGT11L1->toArray())
            ->addData('VoltageGT11L2', $voltageGT11L2->toArray())
            ->addData('VoltageGT11L3', $voltageGT11L3->toArray())
            ->addData('VoltageGT12L1', $voltageGT12L1->toArray())
            ->addData('VoltageGT12L2', $voltageGT12L2->toArray())
            ->addData('VoltageGT12L3', $voltageGT12L3->toArray())
            ->addData('VoltageGT13L1', $voltageGT13L1->toArray())
            ->addData('VoltageGT13L2', $voltageGT13L2->toArray())
            ->addData('VoltageGT13L3', $voltageGT13L3->toArray())
            ->setLabels($label->toArray());
    }
}
