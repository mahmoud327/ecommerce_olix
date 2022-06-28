<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilterTypesTable extends Migration {

	public function up()
	{
		Schema::create('filter_types', function(Blueprint $table) {
			$table->id();
			$table->text('name');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('filter_types');
	}
}
