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
            $table->json('gallery')->nullable()->after('image');
        });
        Schema::table('cooperatives', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('image');
        });
        Schema::table('transports', function (Blueprint $table) {
            $table->json('gallery')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('gallery');
        });
        Schema::table('cooperatives', function (Blueprint $table) {
            $table->dropColumn('gallery');
        });
        Schema::table('transports', function (Blueprint $table) {
            $table->dropColumn('gallery');
        });
    }
};
