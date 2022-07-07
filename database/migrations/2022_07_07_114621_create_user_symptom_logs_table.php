<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSymptomLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_symptom_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('user_response'); 
            $table->bigInteger('symptom_log_id')->nullable(); 
            $table->bigInteger('user_id')->nullable(); 
            $table->string('status', 20)->nullable(); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('symptom_log_id')->references('id')->on('symptom_logs');
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
        Schema::dropIfExists('user_symptom_logs');
    }
}
