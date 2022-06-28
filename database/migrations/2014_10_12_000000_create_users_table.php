<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();
            $table->string('api_token')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->enum('mobile_type', array('android', 'ios'));
            $table->text('fcm_token')->nullable();
            $table->string('image')->nullable();
            $table->integer('activate')->default(0);
            $table->integer('organization_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('lang')->default('en');
            $table->string('pin_code')->nullable();
            $table->tinyinteger('verify_phone')->default(0);
            $table->string('email')->nullable();
            $table->biginteger('marketer_code_id')->nullable();
            $table->integer('points')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
