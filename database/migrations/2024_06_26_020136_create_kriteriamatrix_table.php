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
        Schema::create('kriteriamatrix', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idkriteria1')->constrained('kriterias');
            $table->foreignId('idkriteria2')->constrained('kriterias');
            $table->decimal('value', 8, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteriamatrix');
    }
};
