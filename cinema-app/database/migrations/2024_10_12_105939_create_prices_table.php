<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_session_id')->nullable();
            $table->unsignedBigInteger('cinema_hall_id')->nullable();
            $table->enum('seat_type', ['standard', 'vip']);
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->foreign('movie_session_id')
                ->references('id')->on('movie_sessions')
                ->onDelete('cascade');
            $table->foreign('cinema_hall_id')
                ->references('id')->on('cinema_halls')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
