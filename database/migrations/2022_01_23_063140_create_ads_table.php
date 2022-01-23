<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('ad_type')->nullable();
            $table->text('image')->nullable();
            $table->string('status', '20')->nullable();
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('ad_type')->references('id')->on('ad_types');
            
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
        Schema::dropIfExists('ads');
    }
}
