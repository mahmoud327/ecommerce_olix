<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUpgradeRequestsTable extends Migration {

	public function up()
	{
		Schema::create('upgrade_requests', function(Blueprint $table) {
			$table->id();
			$table->string('organization_name');
			$table->string('phone', 50);
			$table->double('latitude')->nullable();
			$table->double('longitude')->nullable();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('sub_account_id')->unsigned();
			$table->bigInteger('category_id')->unsigned();
			$table->enum('status', array('pennding', 'accepted', 'rejected'))->default('pennding');
			$table->longText('note')->nullable();
			$table->longText('rejected_reason')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->bigInteger('organization_id')->unsigned()->nullable();;
		});


	}

	public function down()
	{
		Schema::drop('upgrade_requests');
	}
}

