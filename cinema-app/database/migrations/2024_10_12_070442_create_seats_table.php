<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Запуск миграции.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_hall_id')->constrained()->onDelete('cascade'); // Внешний ключ на зал
            $table->integer('row'); // Номер ряда
            $table->integer('seat_number'); // Номер места в ряду
            $table->enum('type', ['standard', 'vip']); // Тип места: стандартное или VIP
            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}