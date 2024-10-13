<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            $table->timestamp('end_time')->nullable(); // Добавляем колонку end_time
        });
    }

    public function down()
{
    if (Schema::hasColumn('movie_sessions', 'end_time')) {
        Schema::table('movie_sessions', function (Blueprint $table) {
        });
    }
}

};
