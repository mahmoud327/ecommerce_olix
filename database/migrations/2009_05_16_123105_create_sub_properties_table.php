<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubPropertiesTable extends Migration {

	public function up()
	{
		Schema::create('sub_properties', function(Blueprint $table) {
			$table->id();
			$table->text('name');
			$table->integer('property_id')->unsigned();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sub_properties');
	}
}
