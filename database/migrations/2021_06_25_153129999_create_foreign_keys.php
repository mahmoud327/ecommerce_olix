<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		// Schema::table('categories', function(Blueprint $table) {
		// 	$table->foreign('view_id')->references('id')->on('views')
		// 				->onDelete('no action')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('categories', function(Blueprint $table) {
		// 	$table->foreign('category_recurring_id')->references('id')->on('categories_recurring')
		// 				->onDelete('cascade')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('filters', function(Blueprint $table) {
		// 	$table->foreign('filter_recurring_id')->references('id')->on('filters_recurring')
		// 				->onDelete('no action')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('filters', function(Blueprint $table) {
		// 	$table->foreign('category_id')->references('id')->on('categories')
		// 				->onDelete('no action')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('sub_filters', function(Blueprint $table) {
		// 	$table->foreign('filter_id')->references('id')->on('filters')
		// 				->onDelete('cascade')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('filter_sub_accounts', function(Blueprint $table) {
		// 	$table->foreign('filter_id')->references('id')->on('filters')
		// 				->onDelete('cascade')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('categories_recurring', function(Blueprint $table) {
		// 	$table->foreign('view_id')->references('id')->on('views')
		// 				->onDelete('no action')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('category_sub_accounts', function(Blueprint $table) {
		// 	$table->foreign('category_id')->references('id')->on('categories')
		// 				->onDelete('no action')
		// 				->onUpdate('cascade');
		// });
		// Schema::table('category_sub_accounts', function(Blueprint $table) {
		// 	$table->foreign('sub_account_id')->references('id')->on('sub_accounts')
		// 				->onDelete('no action')
		// 				->onUpdate('cascade');
		// });
	}

	public function down()
	{
		// Schema::table('categories', function(Blueprint $table) {
		// 	$table->dropForeign('categories_view_id_foreign');
		// });
		// Schema::table('categories', function(Blueprint $table) {
		// 	$table->dropForeign('categories_category_recurring_id_foreign');
		// });
		// Schema::table('filters', function(Blueprint $table) {
		// 	$table->dropForeign('filters_filter_recurring_id_foreign');
		// });
		// Schema::table('filters', function(Blueprint $table) {
		// 	$table->dropForeign('filters_category_id_foreign');
		// });
		// Schema::table('sub_filters', function(Blueprint $table) {
		// 	$table->dropForeign('sub_filters_filter_id_foreign');
		// });
		// Schema::table('filter_sub_accounts', function(Blueprint $table) {
		// 	$table->dropForeign('filter_sub_accounts_filter_id_foreign');
		// });
		// Schema::table('categories_recurring', function(Blueprint $table) {
		// 	$table->dropForeign('categories_recurring_view_id_foreign');
		// });
		// Schema::table('category_sub_accounts', function(Blueprint $table) {
		// 	$table->dropForeign('category_sub_accounts_category_id_foreign');
		// });
		// Schema::table('category_sub_accounts', function(Blueprint $table) {
		// 	$table->dropForeign('category_sub_accounts_sub_account_id_foreign');
		// });
	}
}
