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
        Schema::table('hotels', function (Blueprint $table) {
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
        });

        Schema::table('cooperatives', function (Blueprint $table) {
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
        });

        Schema::table('transports', function (Blueprint $table) {
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropConstrainedForeignId('place_id');
        });

        Schema::table('cooperatives', function (Blueprint $table) {
            $table->dropConstrainedForeignId('place_id');
        });

        Schema::table('transports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('place_id');
        });
    }
};
