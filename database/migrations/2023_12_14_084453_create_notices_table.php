<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeTable extends Migration
{
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('location_id');
            $table->text('comment');
            $table->integer('rate');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
