<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCycleHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cycle_histories', function (Blueprint $table) {
           
            $table->string('is_registered',3)->nullable(); 
            $table->string('is_logged', 3)->nullable(); 
            $table->text('token')->nullable();   
            $table->bigInteger('user_id')->nullable();  
            $table->foreign('user_id')->references('id')->on('users');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cycle_histories', function (Blueprint $table) {
            $table->dropColumn('is_registered'); 
            $table->dropColumn('is_logged'); 
            $table->dropColumn('token');   
            $table->dropColumn('user_id');  
        });
    }
}
