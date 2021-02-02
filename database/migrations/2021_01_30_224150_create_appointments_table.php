<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('AppointNo')->unique();
            $table->text('AppointDescription');
            $table->string('FirstNameAP');
            $table->string('LastNameAP');
            $table->string('UsernameAP');
            $table->string('CityAP');
            $table->string('Gender');
            $table->integer('ZIPCODE');
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
        Schema::dropIfExists('appointments');
    }
}
