<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubAccountsTable extends Migration {

	public function up()
	{
		Schema::create('sub_accounts', function(Blueprint $table) {
			$table->id();
			$table->string('name', 100);
			$table->bigInteger('account_id');
			$table->timestamps();
			$table->softDeletes();
		});

	}

	public function down()
	{
		Schema::drop('sub_accounts');
	}
}
