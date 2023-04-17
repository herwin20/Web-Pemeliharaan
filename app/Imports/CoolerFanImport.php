<?php

namespace App\Imports;

use App\Models\CoolerFan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoolerFanImport implements WithHeadingRow, ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        /*Validator::make($collection->toArray(), [
            '*.wo_number' => 'unique:mysql2.wrench_time,wo_number',
            '*.description_wo' => 'unique:mysql2.wrench_time,wo_number',
        ])->validate(); */

        foreach ($collection as $row) {
            # code...
            CoolerFan::create([
                'date'              => $row['date'],
                'actual'            => $row['actual'],
                'forecast'          => $row['forecast'],
                'forecast_lower'    => $row['forecast_lower'],
                'forecast_upper'    => $row['forecast_upper'],
                'unit'              => $row['unit'],
                'equipment'         => $row['equipment'],
            ]);
        }
    }
}
