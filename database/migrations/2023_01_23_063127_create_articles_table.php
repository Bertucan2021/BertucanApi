<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->nullable();
            $table->string('introduction', 255)->nullable();
            $table->text('icon')->nullable(); 
            $table->text('body')->nullable();
            $table->text('small_description')->nullable();
            $table->bigInteger('article_by')->nullable();
            $table->string('type', '255')->nullable();
            $table->string('status', 20)->nullable();
            $table->foreign('article_by')->references('id')->on('users');
           
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
        Schema::dropIfExists('articles');
    }
}
