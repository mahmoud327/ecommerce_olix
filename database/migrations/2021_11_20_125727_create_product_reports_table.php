<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reports', function (Blueprint $table) {
            $table->id();
            $table->biginteger('product_id');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->biginteger('user_id');
            $table->string('select_message')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reports');
    }
}
