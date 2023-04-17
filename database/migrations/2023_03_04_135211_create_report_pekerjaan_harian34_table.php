<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     * php artisan migrate --database="mysql2" cara migrate
     */
    public function up()
    {
        Schema::create('report_pekerjaan_harian34', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('week');
            $table->timestamps();
            $table->string('nama_pekerjaan');
            $table->string('tipe_pekerjaan');
            $table->text('uraian_pekerjaan');
            $table->string('lokasi');
            $table->string('unit');
            $table->string('subsistem')->nullable();
            $table->string('pic');
            $table->text('temuan')->nullable();
            $table->text('material')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->string('status');
            $table->string('photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_pekerjaan_harian34');
    }
};
