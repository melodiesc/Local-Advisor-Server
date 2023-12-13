<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateIdToLocationsTable extends Migration
{
    
     


public function up(){Schema::table('locations', function (Blueprint $table) {$table->unsignedBigInteger('rate_id')->nullable();

            $table->foreign('rate_id')
                  ->references('id')
                  ->on('rates')
                  ->onDelete('cascade');
        });
    }

    
     

public function down(){Schema::table('locations', function (Blueprint $table) {$table->dropForeign(['rate_id']);$table->dropColumn('rate_id');});}
}