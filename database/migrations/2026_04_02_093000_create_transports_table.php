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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['car', 'bus', 'taxi', 'plane']);
            $table->integer('price');
            $table->boolean('availability')->default(true);
            $table->string('description');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('phone');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
