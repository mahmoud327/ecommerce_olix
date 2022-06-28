<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertiesTable extends Migration {

	public function up()
	{
		Schema::create('properties', function(Blueprint $table) {
			$table->increments('id');
			$table->text('name');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('properties');
	}
}