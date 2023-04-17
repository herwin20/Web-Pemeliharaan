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
     */
    public function up()
    {
        // Create Table
        Schema::create('report_pekerjaan_harian', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop The Table
        Schema::dropIfExists('report_pekerjaan_harian');
    }
};
