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
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('cooperative_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('transport_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['cooperative_id']);
            $table->dropColumn('cooperative_id');
            $table->dropForeign(['transport_id']);
            $table->dropColumn('transport_id');
            $table->dropForeign(['hotel_id']);
            $table->dropColumn('hotel_id');
        });
    }
};
