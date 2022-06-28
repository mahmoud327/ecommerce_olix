<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {

      Schema::create('products', function (Blueprint $table) {

         $table->id();
         $table->string('name')->nullable();
         $table->string('phone')->nullable();
         $table->string('username')->nullable();
         $table->string('email')->nullable();
         $table->longtext('note')->nullable();
         $table->longtext('description')->nullable();
         $table->integer('quantity')->unsigned()->nullable();
         $table->integer('organization_id')->unsigned()->nullable();
         $table->string('organization_name')->nullable();
         $table->bigInteger('category_id');
         $table->enum('status', array('approve','disapprove', 'pennding', 'finished'))->default('approve');
         $table->integer('user_id')->unsigned();
         $table->integer('contact')->unsigned();
         $table->string('link')->nullable();
         $table->double('discount');
         $table->double('price');
         $table->Biginteger('count_chat')->unsigned()->default(0);
         $table->Biginteger('count_phone')->unsigned()->default(0);
         $table->Biginteger('count_view')->unsigned()->default(0);
         $table->double('latitude')->nullable();
         $table->double('longitude')->nullable();
         $table->softDeletes();
         $table->timestamps();
         $table->Biginteger('position')->unsigned();
         $table->tinyinteger('byadmin')->defualt(0);
         $table->string('city_name')->nullable();

         $table->tinyinteger('verify_phone')->default(0);
         $table->string('pin_code')->nullable();
         $table->longtext('rejected_reason')->nullable();
         $table->biginteger('marketer_code_id')->nullable();
         $table->longtext('promote_to')->nullable();
         $table->integer('old_position')->unsigned();
         $table->date('date_old_position')->nullable();
         $table->Biginteger('governorate_id')->unsigned();
         $table->Biginteger('city_id')->unsigned();

      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('products');
   }
}
