<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report5Model extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'report_pekerjaan_harian5';
    protected $fillable = [
        'week',
        'nama_pekerjaan',
        'tipe_pekerjaan',
        'uraian_pekerjaan',
        'lokasi',
        'unit',
        'subsistem',
        'pic',
        'temuan',
        'material',
        'rekomendasi',
        'status',
        'photo',
    ];
}
