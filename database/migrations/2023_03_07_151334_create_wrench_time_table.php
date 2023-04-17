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
        Schema::create('wrench_time', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('wo_number');
            $table->string('plant_no');
            $table->string('description_wo');
            $table->string('work_group');
            $table->string('mt_type');
            $table->string('start_repair_date');
            $table->string('start_repair_time');
            $table->string('stop_repair_date');
            $table->string('stop_repair_time');
            $table->integer('working_days');
            $table->float('average_hours');
            $table->integer('on_hand_repairs');
            $table->integer('time_to_repairs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wrench_time');
    }
};
