<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertismentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array('product','organization'))->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->biginteger('category_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->longtext('link')->nullable();
            $table->biginteger('type_id')->nullable();
            $table->longtext('image')->nullable();
            $table->string('code')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisments');
    }
}
