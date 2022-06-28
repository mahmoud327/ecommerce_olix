<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complainments', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->longtext('message')->nullable();
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
        Schema::dropIfExists('complainments');
    }
}
