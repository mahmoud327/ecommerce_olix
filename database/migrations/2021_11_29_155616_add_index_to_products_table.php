<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('price');
            $table->index('promote_to');
            $table->index('position');
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_created_at_index');
            $table->dropIndex('products_updated_at_index');
            $table->dropIndex('products_price_index');
            $table->dropIndex('products_promote_to_index');
            $table->dropIndex('products_position_index');
            $table->dropIndex('products_status_index');
            $table->dropIndex('products_deleted_at_index');
        });
    }
}
