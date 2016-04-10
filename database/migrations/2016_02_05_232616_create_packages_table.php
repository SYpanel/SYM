<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function (Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->integer('disk_space')->default(0);
			$table->integer('bandwidth')->default(0);
			$table->integer('emails')->default(0);
			$table->integer('dbs')->default(0);
			$table->integer('sub_domains')->default(0);
			$table->integer('parked_domains')->default(0);
			$table->integer('addon_domains')->default(0);
			$table->timestamps();
		});

		Schema::table('accounts', function (Blueprint $table) {
			$table->integer('package_id')->unsigned()->nullable();
			$table->foreign('package_id')->references('id')->on('packages');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down()
	{
		Schema::drop('packages');
	}
}
