<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('management')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('division')->unique();
            $table->integer('management_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('management_id')->references('id')->on('managements')->onDelete('cascade');
        });


        // Schema::create('access_logs', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id')->nullable();
        //     $table->string('event', 50);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
