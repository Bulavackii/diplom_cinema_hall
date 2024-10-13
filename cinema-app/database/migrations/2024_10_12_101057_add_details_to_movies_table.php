<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('movies', function (Blueprint $table) {
        // Проверяем, существует ли столбец 'country' перед добавлением
        if (!Schema::hasColumn('movies', 'country')) {
            $table->string('country')->nullable();
        }
        // Проверяем, существует ли столбец 'genre' перед добавлением
        if (!Schema::hasColumn('movies', 'genre')) {
            $table->string('genre')->nullable();
        }
        // Удаляем или закомментируем строку для 'poster_url', если она присутствует
        // $table->string('poster_url')->nullable();
    });
}


    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['country', 'genre', 'poster_url']);
        });
    }
};
