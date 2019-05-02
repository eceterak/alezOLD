<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streets', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 255);
            $table->unsignedInteger('city_id');
            $table->text('type');
            $table->float('lon', 10, 6);
            $table->float('lat', 10, 6);
            $table->decimal('importance', 7, 6);
            $table->char('ct', 80);
            //$table->point('coordinates');

            $table->timestamps();
            
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
        Schema::dropIfExists('streets');
    }
}
