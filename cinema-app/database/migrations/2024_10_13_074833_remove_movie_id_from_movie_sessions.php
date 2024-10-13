<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveMovieIdFromMovieSessions extends Migration
{
    public function up()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            // Удаляем внешнее ключевое ограничение, если оно существует
            $table->dropForeign(['movie_id']);
            // Теперь можно удалить столбец
            $table->dropColumn('movie_id');
        });
    }

    public function down()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained('movies');
        });
    }
}
