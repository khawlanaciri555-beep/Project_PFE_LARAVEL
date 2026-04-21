<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the check constraint that restricts roles.
        // We will rely on application-level validation.
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-adding the constraint might fail if there are new roles in the DB
    }
};
