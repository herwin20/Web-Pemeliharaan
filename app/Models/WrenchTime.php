<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WrenchTime extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'wrench_time';
    protected $fillable = [
        'wo_number',
        'plant_no',
        'description_wo',
        'work_group',
        'mt_type',
        'start_repair_date',
        'start_repair_time',
        'stop_repair_date',
        'stop_repair_time',
        'working_days',
        'average_hours',
        'on_hand_repairs',
        'time_to_repairs',
    ];
}
