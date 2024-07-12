<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alternatif_weights', function (Blueprint $table) {
            $table->decimal('weight', 20, 15)->change();
        });

        Schema::table('alternatif_matrix', function (Blueprint $table) {
            $table->decimal('value', 20, 15)->change();
        });

        Schema::table('criteria_weights', function (Blueprint $table) {
            $table->decimal('weight', 20, 15)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alternatif_weights', function (Blueprint $table) {
            $table->decimal('weight', 8, 4)->change();
        });

        Schema::table('alternatif_matrix', function (Blueprint $table) {
            $table->float('value')->change();
        });

        Schema::table('criteria_weights', function (Blueprint $table) {
            $table->float('weight')->change();
        });
    }
};
