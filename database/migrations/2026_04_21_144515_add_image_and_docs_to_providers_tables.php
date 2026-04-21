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
        Schema::table('transports', function (Blueprint $table) {
            $table->string('image')->nullable()->after('type');
            $table->string('license_doc')->nullable()->after('image');
        });

        Schema::table('cooperatives', function (Blueprint $table) {
            $table->string('certificate')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->dropColumn(['image', 'license_doc']);
        });

        Schema::table('cooperatives', function (Blueprint $table) {
            $table->dropColumn('certificate');
        });
    }
};
