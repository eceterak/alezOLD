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
            $table->unsignedInteger('street_id')->nullable();
            $table->boolean('verified')->default(false)->nullable();
            $table->boolean('active')->default(false)->nullable();
            $table->char('slug', 80)->nullable();
            
            // $$$.
            $table->unsignedSmallInteger('rent');
            $table->unsignedSmallInteger('deposit');
            $table->unsignedSmallInteger('bills');
            
            // General info.
            $table->char('title', 50);
            $table->text('description');
            $table->enum('landlord', ['live_in', 'live_out', 'tenetant', 'agent', 'former'])->nullable();

            // Availability.
            $table->timestamp('available_from')->useCurrent();
            $table->unsignedTinyInteger('minimum_stay')->nullable();
            $table->unsignedTinyInteger('maximum_stay')->nullable();
            
            // Property details.
            $table->enum('property_type', ['block', 'house', 'tenement', 'apartment', 'loft'])->nullable();
            $table->unsignedTinyInteger('property_size')->default('1');
            $table->boolean('living_room')->default(false);
            $table->boolean('parking')->default(false);
            
            // Room details.
            $table->enum('room_size', ['single', 'double', 'triple'])->default('single')->nullable();
            $table->boolean('furnished')->default(false);
            $table->boolean('broadband')->default(false);
            
            // Desired tenetant.
            $table->boolean('smooking')->default(false);
            $table->boolean('pets')->default(false);
            $table->boolean('couples')->default(false);
            $table->enum('gender', ['n', 'm', 'f'])->nullable();
            $table->enum('occupation', ['n', 'student', 'professional'])->nullable();
            $table->unsignedTinyInteger('minimum_age')->nullable();
            $table->unsignedTinyInteger('maximum_age')->nullable();

            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
