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
            $table->bigIncrements('user_id');
            $table->string('username');
            $table->string('password');
            $table->string('country');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('email');
            $table->date('join_date');
            $table->mediumText('biography');
            $table->string('role');
            $table->string('house');
            $table->string('first_name');
            $table->string('last_name');
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
        Schema::dropIfExists('users');
    }
}
