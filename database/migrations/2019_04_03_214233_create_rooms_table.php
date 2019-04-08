<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('stage')->default(1); // Stage of creation.
            $table->unsignedInteger('user_id');
            $table->char('place_id', 255);
            $table->char('city_id', 255);
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->char('address', 80); // Full address.
            
            $table->unsignedTinyInteger('property_size')->default(2); // Property size
            $table->unsignedTinyInteger('property_type_id')->default(1); // Property type
            $table->unsignedTinyInteger('user_status')->default(1); // I am a Live in landlord etc.
            
            // Amenities
            $table->boolean('living_room')->default(true);


            $table->string('title');
            $table->text('description');




            $table->unsignedSmallInteger('rent');

            
            $table->boolean('validated')->default(false);
            $table->timestamps();








/*             
            
            $table->unsignedInteger('city_id'); // Postcode/City
            //$table->boolean('active')->default(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            //$table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
            //$table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
