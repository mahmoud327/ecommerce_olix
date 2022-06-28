<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->id();
			$table->string('name', 80);
			$table->text('description');
			$table->bigInteger('view_id')->unsigned();
			$table->text('image')->nullable();;
			$table->string('text1', 200)->nullable();
			$table->string('text2', 200)->nullable();
			$table->bigInteger('parent_id')->unsigned()->default('0');
			$table->integer('is_all')->default('0');
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('category_recurring_id')->nullable()->unsigned();
			$table->bigInteger('position')->nullable();
			$table->longtext('text3')->nullable();

       
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}
