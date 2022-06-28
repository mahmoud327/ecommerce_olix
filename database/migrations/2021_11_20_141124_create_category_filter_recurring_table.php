<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryFilterRecurringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_filter_recurring', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('filter_recurring_id')->nullable();
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
        Schema::dropIfExists('category_filter_recurring');
    }
}
