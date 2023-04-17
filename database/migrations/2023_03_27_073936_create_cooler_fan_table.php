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
        Schema::create('cooler_fan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

$table->dateTime('date');
            $table->float('actual');
            $table->float('forecast');
            $table->float('forecast_lower');
            $table->float('forecast_upper');
            $table->string('unit');
            $table->string('equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooler_fan');
    }
};
