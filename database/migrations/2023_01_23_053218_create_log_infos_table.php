<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->date('pregnancyDate')->nullable();
            $table->date('phaseChange')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('log_infos');
    }
}
