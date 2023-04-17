<?php

namespace App\Charts;

use App\Models\CoolerFan as ModelsCoolerFan;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class CoolerFan
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $actual =  ModelsCoolerFan::where([
            ['unit', '=', 'GT11'],
            ['equipment', '=', 'C1F1'],
        ])->pluck('actual');

        $forecast =  ModelsCoolerFan::where([
            ['unit', '=', 'GT11'],
            ['equipment', '=', 'C1F1'],
        ])->pluck('forecast');

        $forecast_lower =  ModelsCoolerFan::where([
            ['unit', '=', 'GT11'],
            ['equipment', '=', 'C1F1'],
        ])->pluck('forecast_lower');

        $forecast_upper =  ModelsCoolerFan::where([
            ['unit', '=', 'GT11'],
            ['equipment', '=', 'C1F1'],
        ])->pluck('forecast_upper');

        $date =  ModelsCoolerFan::where([
            ['unit', '=', 'GT11'],
            ['equipment', '=', 'C1F1'],
        ])->pluck('date');

        return $this->chart->lineChart()
            ->setTitle('Forecast VS Actual')
            ->setSubtitle('Cooler Fan Current')
            ->addData('Actual', $actual->toArray())
            ->addData('Forecast', $forecast->toArray())
            ->addData('Forecast Lower', $forecast_lower->toArray())
            ->addData('Forecast Upper', $forecast_upper->toArray())
            ->setXAxis($date->toArray());
    }
}
