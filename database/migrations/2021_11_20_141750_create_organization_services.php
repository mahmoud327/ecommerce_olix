<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
			$table->text('image')->nullable();
			$table->longtext('phones');
			$table->string('description')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->bigInteger('position')->nullable();
			$table->longtext('links')->nullable();
			$table->longtext('city_name')->nullable();
			$table->longtext('google_map_link')->nullable();
			$table->integer('service_id')->nullable();;
			$table->integer('city_id')->nullable();;

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_services');
    }
}
