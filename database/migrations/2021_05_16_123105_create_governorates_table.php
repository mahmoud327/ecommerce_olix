<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGovernoratesTable extends Migration {

	public function up()
	{
		Schema::create('governorates', function(Blueprint $table) {
			$table->id();
			$table->text('name');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('governorates');
	}
}
