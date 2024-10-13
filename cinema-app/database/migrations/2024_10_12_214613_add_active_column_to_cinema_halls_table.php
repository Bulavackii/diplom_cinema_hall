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
    if (!Schema::hasColumn('cinema_halls', 'active')) {
        Schema::table('cinema_halls', function (Blueprint $table) {
            $table->boolean('active')->default(true);
        });
    }
}

public function down()
{
    if (Schema::hasColumn('cinema_halls', 'active')) {
        Schema::table('cinema_halls', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}

};
