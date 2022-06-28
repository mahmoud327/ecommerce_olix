<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategorySubAccountsTable extends Migration {

	public function up()
	{
		Schema::create('category_sub_accounts', function(Blueprint $table) {
			$table->id();
			$table->bigInteger('category_id')->unsigned();
			$table->bigInteger('sub_account_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});


	}

	public function down()
	{
		Schema::drop('category_sub_accounts');
	}
}
