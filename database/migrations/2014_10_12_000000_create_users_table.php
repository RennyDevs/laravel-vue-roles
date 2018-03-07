<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user', 25)->unique();
            $table->string('name', 25);
            $table->string('last_name', 25);
            $table->integer('num_id')->unsigned()->unique();
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->integer('module_id')->unsigned()->index();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('module_id')
            ->references('id')->on('modules')
            ->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
