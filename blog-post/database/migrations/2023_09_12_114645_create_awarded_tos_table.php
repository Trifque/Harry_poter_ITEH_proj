<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardedTosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awarded_tos', function (Blueprint $table) {
            $table->bigIncrements('awarded_to_id');
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
        Schema::table('awarded_tos', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('award_id');
            $table->dropForeign('post_id');
        });

        Schema::dropIfExists('awarded_tos');
    }
}
