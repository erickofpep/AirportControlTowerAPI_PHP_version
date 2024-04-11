<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircraft_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('aircraft_name')->nullable();
            $table->string('type');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('altitude');
            $table->string('heading');
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
        Schema::dropIfExists('aircraft_locations');
    }
}
