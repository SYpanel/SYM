<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('password', 60);

            /** package*/
            $table->integer('disk_space')->default(0);
            $table->integer('bandwidth')->default(0);
            $table->integer('emails')->default(0);
            $table->integer('dbs')->default(0);
            $table->integer('sub_domains')->default(0);
            $table->integer('parked_domains')->default(0);
            $table->integer('addon_domains')->default(0);

            $table->rememberToken();
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
        Schema::drop('accounts');
    }
}
