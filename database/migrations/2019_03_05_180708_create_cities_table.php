<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('type', 40)->default('miasto')->nullable();
            $table->string('slug', 60)->nullable();
            $table->string('parent', 50)->nullable();
            $table->float('lat', 10, 6);
            $table->float('lon', 10, 6);
            $table->decimal('importance', 7, 6)->nullable();
            $table->boolean('suggested')->default(false);
            $table->char('community', 50);
            $table->char('county', 50);
            $table->char('state', 50);
            $table->float('west', 10, 6)->nullable();
            $table->float('south', 10, 6)->nullable();
            $table->float('east', 10, 6)->nullable();
            $table->float('north', 10, 6)->nullable();
            
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
        Schema::dropIfExists('cities');
    }
}
