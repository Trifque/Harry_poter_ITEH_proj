<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardedToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awarded_to', function (Blueprint $table) {
            $table->id('awarded_to_id');
            $table->unsignedBigInteger('award_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            $table->foreign('award_id')->references('award_id')->on('awards');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('post_id')->references('post_id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('awarded_to');
    }
}
