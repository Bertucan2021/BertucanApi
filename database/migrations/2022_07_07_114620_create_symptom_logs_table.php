<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSymptomLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symptom_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('symptom_description'); 
            $table->bigInteger('symptom_type_id')->nullable();
            $table->string('status', 20)->nullable();  
            $table->foreign('symptom_type_id')->references('id')->on('symptom_types');
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
        Schema::dropIfExists('symptom_logs');
    }
}
