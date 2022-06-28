<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->id();
			$table->longtext('terms')->nullable();
			$table->longtext('about_us')->nullable();
			$table->string('phone', 15)->nullable();
			$table->string('email', 30)->nullable();
			$table->string('fb_link', 100)->nullable();
			$table->string('tw_link', 100)->nullable();
			$table->string('youtube_link', 100)->nullable();
			$table->string('inst_link', 100)->nullable();
			$table->string('whatsapp', 100)->nullable();
			$table->string('fax', 100)->nullable();
            $table->double('latitude')->nullable();
			$table->double('longitude')->nullable();
			$table->timestamps();
		});

	}

	public function down()
	{
		Schema::drop('settings');
	}
}
