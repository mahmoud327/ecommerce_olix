<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableProductFavouriteUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product_favourite_user', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->foreignId('user_id')->nullable()->index();
            $table->string('product_id', 45)->nullable();
            $table->softDeletes();
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('product_favourite_user');

    }
}
