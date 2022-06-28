
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
			$table->string('url');
            $table->string('path')->nullabe();
            $table->string('full_file');
            $table->integer('mediaable_id');
            $table->integer('position');
			$table->string('mediaable_type', 255);
            $table->rememberToken();
			$table->timestamps();
            $table->softDeletes();
			$table->string('upload_key', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
    }
}
