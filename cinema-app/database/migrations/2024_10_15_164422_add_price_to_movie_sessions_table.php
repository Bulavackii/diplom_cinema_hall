<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceFieldsToMovieSessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            // Проверка существования колонок перед добавлением
            if (!Schema::hasColumn('movie_sessions', 'price_regular')) {
                $table->decimal('price_regular', 8, 2)->default(0)->after('end_time');
            }
            if (!Schema::hasColumn('movie_sessions', 'price_vip')) {
                $table->decimal('price_vip', 8, 2)->default(0)->after('price_regular');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            $table->dropColumn(['price_regular', 'price_vip']);
        });
    }
}