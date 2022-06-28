<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilterRecurringSubAccountsTable extends Migration {

	public function up()
	{
		Schema::create('filter_recurring_sub_accounts', function(Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->softDeletes();
			$table->bigInteger('filter_recurring_id')->unsigned();
			$table->bigInteger('sub_account_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('filter_recurring_sub_accounts');
	}
}

