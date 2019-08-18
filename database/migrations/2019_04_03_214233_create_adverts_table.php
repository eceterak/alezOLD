<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('street_id')->nullable();
            $table->boolean('verified')->default(false);
            $table->boolean('archived')->default(false);
            $table->string('slug')->unique();
            $table->unsignedInteger('visits')->default(0);
            $table->string('phone', 13)->nullable();
            $table->text('revision')->nullable();
            
            // General info.
            $table->char('title', 60)->nullable();
            $table->text('description')->nullable();
            $table->enum('room_size', ['single', 'double', 'triple'])->default('single');
            $table->enum('landlord', ['live_in', 'live_out', 'tenetant', 'agent', 'former'])->nullable();
            
            // $$$.
            $table->unsignedSmallInteger('rent');
            $table->unsignedSmallInteger('deposit')->nullable();
            $table->unsignedSmallInteger('bills')->nullable();

            // Availability.
            $table->timestamp('available_from')->useCurrent();
            $table->unsignedTinyInteger('minimum_stay')->nullable();
            $table->unsignedTinyInteger('maximum_stay')->nullable();
            
            // Property details.
            $table->enum('property_type', ['block', 'house', 'tenement', 'apartment', 'loft'])->nullable();
            $table->unsignedTinyInteger('property_size')->default('1');
            
            // Advert details.
            $table->boolean('furnished')->default(false);
            $table->boolean('broadband')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('living_room')->default(false);
            $table->boolean('garage')->default(false);
            $table->boolean('garden')->default(false);
            
            // Desired tenetant.
            $table->boolean('nonsmoking')->default(false);
            $table->boolean('pets')->default(false);
            $table->boolean('couples')->default(false);
            $table->enum('gender', ['m', 'f'])->nullable();
            $table->enum('occupation', ['student', 'professional'])->nullable();
            $table->unsignedTinyInteger('minimum_age')->nullable();
            $table->unsignedTinyInteger('maximum_age')->nullable();

            $table->timestamps();
            
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adverts');
    }
}
