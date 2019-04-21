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
            
            // General info.
            /* $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('stage')->default(1); // Stage of creation.
            $table->string('title');
            $table->text('description');
            $table->boolean('validated')->default(false);
            $table->boolean('active')->default(false);

            // Location
            $table->unsignedInteger('city_id');
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->char('address', 80); // Full address.

            // Place details
            $table->unsignedTinyInteger('property_size')->default(2); // Property size
            $table->unsignedTinyInteger('property_type')->default(1); // Property type
            $table->unsignedTinyInteger('landlord')->default(1); // I am a Live in landlord etc.
            $table->boolean('living_room')->default(true);
            
            // Room details
            $table->enum('room_size', ['jednoosobowy', 'dwuosobowy'])->default('jednoosobowy');
            $table->boolean('furnished')->default(true);
            $table->boolean('ensuite')->default(false);

            // Budget
            $table->unsignedSmallInteger('rent');
            $table->unsignedSmallInteger('deposit');
            $table->boolean('bills_included')->default(false);
            $table->boolean('broadband')->default(true);

            // Availability
            $table->timestamp('available_from')->useCurrent();
            $table->unsignedTinyInteger('minimum_stay')->default(0);
            $table->unsignedTinyInteger('maximum_stay')->default(0);
            $table->boolean('short_term')->default(false);
            $table->enum('days_available', ['7 dni w tygodniu', 'Pon - pia', 'Weekendy'])->default('7 dni w tygodniu');

            // Desired tentant
            $table->boolean('smooking')->default(false);
            $table->char('gender', 1)->default('N');
            $table->char('occupation', 1)->default('N');
            $table->boolean('pets')->default(false);
            $table->unsignedTinyInteger('minimum_age');
            $table->unsignedTinyInteger('maximum_age');
            $table->boolean('couples')->default(false); */

            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('street_id');
            /* $table->string('title');
            $table->text('description');
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->char('address', 80); // Full address. */

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
