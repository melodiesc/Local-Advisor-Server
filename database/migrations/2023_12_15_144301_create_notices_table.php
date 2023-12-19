<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('user_id')->constrained('users');
            $table->text('comment');
            $table->integer('rate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notices');
    }
}