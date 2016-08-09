<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('');
            $table->string('details')->default('');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->time('starttime');
            $table->time('endtime');
			$table->integer('resourceId')->unsigned();	// ID des Raumes
            $table->boolean('disabled')->default(false);            
            $table->timestamps();
        });
		Schema::table('events', function ($table) {		
			$table->foreign('resourceId')->references('id')->on('rooms');			
	    });		
		Schema::table('rooms', function ($table) {		
			$table->foreign('building_id')->references('id')->on('buildings');
	    });		

	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
