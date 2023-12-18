<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notice_id')->constrained('notices');
            $table->foreignId('owner_id')->constrained('owners');
            $table->text('content');
            $table->timestamps();

            // $table->foreign('notice_id')->references('id')->on('notices')->onDelete('cascade');
            // $table->foreign('owner_id')->references('id')->on('owner')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
}