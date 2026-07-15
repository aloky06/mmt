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
        Schema::table('bravo_cars', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_cars', 'price_per_km')) {
                $table->decimal('price_per_km', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('bravo_cars', 'price_4hr')) {
                $table->decimal('price_4hr', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('bravo_cars', 'price_8hr')) {
                $table->decimal('price_8hr', 12, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bravo_cars', function (Blueprint $table) {
            $table->dropColumn(['price_per_km', 'price_4hr', 'price_8hr']);
        });
    }
};
