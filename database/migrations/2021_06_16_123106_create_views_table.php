<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateViewsTable extends Migration {

	public function up()
	{
		Schema::create('views', function(Blueprint $table) {
			$table->id();
			$table->string('name', 80);
			$table->text('image');
			$table->timestamps();
			$table->softDeletes();


		});
	}

	public function down()
	{
		Schema::drop('views');
	}
}
