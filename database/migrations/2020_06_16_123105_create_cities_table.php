<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->id();
			$table->text('name');
			$table->integer('governorate_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
		});


	}


	public function down()
	{
		Schema::drop('cities');
	}
}
