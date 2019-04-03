<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoomAmenities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_room_amenities', function (Blueprint $table) {
            $table->increments('id');
            /* $table->unsignedInteger('city_id');
            $table->timestamps();

            $this->foreign('city_id')->references('id')->on('amenities')->onDelete('cascade');
            $this->foreign('amenities_id')->references('id')->on('amenities')->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_room_amenities');
    }
}
