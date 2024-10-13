<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id')->nullable()->after('id');
            
            // Добавьте внешний ключ, если необходимо
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('movie_sessions', function (Blueprint $table) {
            $table->dropForeign(['movie_id']);
            $table->dropColumn('movie_id');
        });
    }
    

};
