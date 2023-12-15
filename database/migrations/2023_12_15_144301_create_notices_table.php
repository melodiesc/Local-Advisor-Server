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
            $table->foreignId('owner_id')->constrained('owners');
            $table->text('comment');
            $table->integer('rate');
            $table->timestamps();

            // $table->foreign('notice_id')->references('id')->on('notices')->onDelete('cascade');
            // $table->foreign('owner_id')->references('id')->on('owner')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notices');
    }
}