<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeatureSubAccountTable extends Migration {

	public function up()
	{
		Schema::create('feature_sub_account', function(Blueprint $table) {
			$table->id();
			$table->bigInteger('feature_id')->unsigned();
			$table->bigInteger('sub_account_id');
			$table->timestamps();
			$table->softDeletes();

     
		});
	}

	public function down()
	{
		Schema::drop('feature_sub_account');
	}
}
