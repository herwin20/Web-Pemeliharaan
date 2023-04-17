<?php

namespace App\Imports;

use App\Models\WrenchTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FileImport implements WithHeadingRow, ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.wo_number' => 'unique:mysql2.wrench_time,wo_number',
            '*.description_wo' => 'unique:mysql2.wrench_time,wo_number',
        ])->validate();

        foreach ($rows as $row) {
            # code...
            WrenchTime::create([
                'wo_number'             => $row['wo_number'],
                'plant_no'              => $row['plant_no'],
                'description_wo'        => $row['description_wo'],
                'work_group'            => $row['work_group_header'],
                'mt_type'               => $row['mt_type'],
                'start_repair_date'     => $row['start_repair_date'],
                'start_repair_time'     => $row['start_repair_time'],
                'stop_repair_date'      => $row['stop_repair_date'],
                'stop_repair_time'      => $row['stop_repair_time'],
                'working_days'          => $row['working_days'],
                'average_hours'         => $row['average_hours'],
                'on_hand_repairs'       => $row['on_hand_repairs'],
                'time_to_repairs'       => $row['time_to_repairs'],
            ]);
        }
    }

    /*public function model(array $row)
    {
        return new WrenchTime([
            //
            'wo_number'             => $row['wo_number'],
            'plant_no'              => $row['plant_no'],
            'description_wo'        => $row['description_wo'],
            'work_group'            => $row['work_group_header'],
            'mt_type'               => $row['mt_type'],
            'start_repair_date'     => $row['start_repair_date'],
            'start_repair_time'     => $row['start_repair_time'],
            'stop_repair_date'      => $row['stop_repair_date'],
            'stop_repair_time'      => $row['stop_repair_time'],
            'working_days'          => $row['working_days'],
            'average_hours'         => $row['average_hours'],
            'on_hand_repairs'       => $row['on_hand_repairs'],
            'time_to_repairs'       => $row['time_to_repairs'],
        ]);
    } */
}
