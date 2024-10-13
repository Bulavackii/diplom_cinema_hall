<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMovieIdToMovieSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            // Проверяем, существует ли уже столбец movie_id
            if (!Schema::hasColumn('movie_sessions', 'movie_id')) {
                $table->unsignedBigInteger('movie_id')->nullable()->after('cinema_hall_id');
                $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            // Проверяем, существует ли столбец movie_id, прежде чем его удалять
            if (Schema::hasColumn('movie_sessions', 'movie_id')) {
                $table->dropForeign(['movie_id']);
                $table->dropColumn('movie_id');
            }
        });
    }
}
