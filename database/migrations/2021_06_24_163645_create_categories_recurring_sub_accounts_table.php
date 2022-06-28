<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesRecurringSubAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_recurring_sub_accounts', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('category_recurring_id')->unsigned();
			$table->bigInteger('sub_account_id')->unsigned();
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
        Schema::dropIfExists('categories_recurring_sub_accounts');
    }
}
