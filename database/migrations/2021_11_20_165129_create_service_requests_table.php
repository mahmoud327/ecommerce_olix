<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->longtext('message')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('organization_service_id')->nullable();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
