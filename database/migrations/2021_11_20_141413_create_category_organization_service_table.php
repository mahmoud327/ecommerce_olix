<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryOrganizationServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_organization_service', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('organization_service_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_organization_service');
    }
}
