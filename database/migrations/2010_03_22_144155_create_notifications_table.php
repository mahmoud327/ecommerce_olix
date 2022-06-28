<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->id();
            $table->timestamps();
			$table->longtext('title', 150);
			$table->longtext('content');
			$table->integer('notificationable_id');
			$table->string('notificationable_type', 255);
			$table->softDeletes();
			$table->tinyInteger('is_read')->default(0);

		});

  
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
