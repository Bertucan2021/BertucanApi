<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 20)->nullable();
            $table->string('last_name', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('password')->nullable();
            $table->text('profile_picture')->nullable();
            $table->string('phone_number', 20)->unique()->nullable();
            $table->string('log_status', 20)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('role', 20)->default('user')->nullable();
            $table->bigInteger('address_id')->unsigned()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('membership_id')->unsigned()->nullable();
            $table->rememberToken();
            //size of remembertoken needs to be changed after migration
            $table->timestamps();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('membership_id')->references('id')->on('memberships');
 
        });
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
