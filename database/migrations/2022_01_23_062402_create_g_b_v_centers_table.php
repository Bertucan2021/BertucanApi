<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGBVCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gbv_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 20)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('phone_number', 20)->nullable(); 
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('membership_id')->references('id')->on('memberships');
            $table->text('license')->nullable();
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
        Schema::dropIfExists('gbv_centers');
    }
}
