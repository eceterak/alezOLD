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
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('street_id');
            $table->boolean('validated')->default(false);
            $table->boolean('active')->default(false);
            
            // General info.
            $table->string('title');
            $table->text('description');
            $table->enum('landlord', ['live_in', 'live_out', 'tenetant', 'agent', 'former'])->default('live_in');
            
            // $$$.
            $table->unsignedTinyInteger('rent');
            $table->unsignedTinyInteger('deposit');
            $table->unsignedTinyInteger('bills');

            // Availability.
            $table->timestamp('available_from')->useCurrent();
            $table->unsignedTinyInteger('minimum_stay')->default(0);
            $table->unsignedTinyInteger('maximum_stay')->default(0);   
            
            // Property details.
            $table->enum('property_type', ['block', 'house', 'tenement', 'apartment', 'loft'])->default('block');
            $table->unsignedTinyInteger('property_size')->default(2);
            $table->boolean('living_room')->default(true);
            $table->boolean('parking')->default(false);
            
            // Room details.
            $table->enum('room_size', ['single', 'double', 'triple'])->default('single');
            $table->boolean('furnished')->default(true);
            $table->boolean('broadband')->default(true);
            
            // Desired tenetant.
            $table->boolean('smooking')->default(false);
            $table->boolean('pets')->default(false);
            $table->boolean('couples')->default(false);
            $table->enum('gender', ['n', 'm', 'f'])->default('n');
            $table->enum('occupation', ['n', 'student', 'professional'])->default('n');
            $table->unsignedTinyInteger('minimum_age')->default(0);
            $table->unsignedTinyInteger('maximum_age')->default(0);

            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
