<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMoviesTableSetDefaultPosterUrl extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('poster_url')->default('images/posters/default.jpg')->change();
        });
    }

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('poster_url')->default(null)->change();
        });
    }
}
