<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilterSubAccountsTable extends Migration {

	public function up()
	{
		Schema::create('filter_sub_accounts', function(Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('filter_id')->unsigned();
			$table->bigInteger('sub_account_id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('filter_sub_accounts');
	}
}
