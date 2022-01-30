<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('type')->default('user')->nullable();
            $table->integer('show_ad')->nullable();
            $table->integer('add_per_minute')->nullable();
            $table->integer('allowed_ad_per_month')->nullable(); //for companies
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
        Schema::dropIfExists('memberships');
    }
}
