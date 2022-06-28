<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTypesTable extends Migration {

	public function up()
	{
		Schema::create('category_types', function(Blueprint $table) {
			$table->id();
			$table->text('name');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('category_types');
	}
}
