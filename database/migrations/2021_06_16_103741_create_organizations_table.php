<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->longtext('phones')->nullable();
            $table->string('link')->nullable();
            $table->string('description')->nullable();
            $table->double('latitude')->nullable();
            $table->double('langitude')->nullable();
            $table->string('background_cover')->nullable();
			$table->bigInteger('organization_type_id')->unsigned();
			$table->tinyInteger('byadmin')->defualt(0);

        });
    }




    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
