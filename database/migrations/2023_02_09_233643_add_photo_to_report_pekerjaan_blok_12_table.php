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
        Schema::table('report_pekerjaan_harian', function (Blueprint $table) {
            //add column
            $table->string('photo')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_pekerjaan_harian', function (Blueprint $table) {
            //Drop Column
            if (Schema::hasColumn('report_pekerjaan_harian', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
