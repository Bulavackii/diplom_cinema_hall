<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieSessionMovieTable extends Migration
{
    public function up()
    {
        Schema::create('movie_session_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('movie_sessions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_session_movie');
    }
}



