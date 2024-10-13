<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMoviesTableMakePosterUrlNullable extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('poster_url')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('poster_url')->nullable(false)->change();
        });
    }
}
