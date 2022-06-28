<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationTypesTable extends Migration {

	public function up()
	{
		Schema::create('organization_types', function(Blueprint $table) {
			$table->id();
			$table->text('name');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('organization_types');
	}
}
