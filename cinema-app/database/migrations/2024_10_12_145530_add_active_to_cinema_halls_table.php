<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveToCinemaHallsTable extends Migration
{
    public function up()
    {
        Schema::table('cinema_halls', function (Blueprint $table) {
            $table->boolean('active')->default(false);
        });
    }

    public function down()
    {
        Schema::table('cinema_halls', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }

};
