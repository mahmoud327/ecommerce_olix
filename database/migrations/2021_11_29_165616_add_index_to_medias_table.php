<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medias', function (Blueprint $table) {
            $table->index('deleted_at');
            $table->index(['mediaable_type', 'mediaable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medias', function (Blueprint $table) {
            $table->dropIndex('medias_deleted_at_index');
            $table->dropIndex('medias_mediaable_type_mediaable_id_index');
        });
    }
}
