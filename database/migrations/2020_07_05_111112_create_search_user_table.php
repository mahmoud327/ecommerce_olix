<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchUserTable extends Migration
{

    public function up()
    {
        Schema::create('search_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
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
        Schema::dropIfExists('search_user');
    }
}
