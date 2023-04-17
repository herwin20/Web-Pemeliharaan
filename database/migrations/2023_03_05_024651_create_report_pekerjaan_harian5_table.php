<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate --database="mysql2"
     * @return void
     */
    public function up()
    {
        Schema::create('report_pekerjaan_harian5', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('week');
            $table->timestamps();
            $table->string('nama_pekerjaan')->nullable();
            $table->string('tipe_pekerjaan')->nullable();
            $table->text('uraian_pekerjaan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('unit')->nullable();
            $table->string('subsistem')->nullable();
            $table->string('pic')->nullable();
            $table->text('temuan')->nullable();
            $table->text('material')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->string('status')->nullable();
            $table->string('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_pekerjaan_harian5');
    }
};
