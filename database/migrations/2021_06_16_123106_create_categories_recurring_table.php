<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesRecurringTable extends Migration {

	public function up()
	{
		Schema::create('categories_recurring', function(Blueprint $table) {
			$table->id();
			$table->string('name', 80);
			$table->bigInteger('parent_id');
			$table->text('description')->nullable();
			$table->BigInteger('view_id')->unsigned()->nullable();
			$table->text('image')->nullable();
			$table->string('text1', 200)->nullable();
			$table->string('text2', 200)->nullable();
            $table->bigInteger('position')->nullable();
			$table->integer('is_all')->default('0');
			$table->bigInteger('category_type_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});

	}

	public function down()
	{
		Schema::drop('categories_recurring');
	}
}
