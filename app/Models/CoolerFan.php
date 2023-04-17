<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoolerFan extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'cooler_fan';
    protected $fillable = [
        'date',
        'actual',
        'forecast',
        'forecast_lower',
        'forecast_upper',
        'unit',
        'equipment',
    ];
}
