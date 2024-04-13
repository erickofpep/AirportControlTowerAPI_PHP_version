<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weatherinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city')->nullable();
            $table->string('description')->nullable();
            $table->string('temperature')->nullable();
            $table->string('visibility')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_deg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weatherinfos');
    }
}
