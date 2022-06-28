<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubAccountUserTable extends Migration {

	public function up()
	{
		Schema::create('sub_account_user', function(Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('sub_account_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();


		});
	}

	public function down()
	{
		Schema::drop('sub_account_user');
	}
}

?>
