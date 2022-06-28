<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationServiceServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_service_service', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('organization_service_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->double('price')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_service_service');
    }
}
