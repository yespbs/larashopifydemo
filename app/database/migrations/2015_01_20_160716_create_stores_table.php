<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('store', 255)->unique();
			$table->string('access_token', 50);
			$table->string('refresh_token', 50);
			$table->string('publishable_key', 50);
			$table->string('token_type', 50);
			$table->string('email', 100)->nullable();
			$table->string('password', 60)->nullable();
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('stores');
	}

}
