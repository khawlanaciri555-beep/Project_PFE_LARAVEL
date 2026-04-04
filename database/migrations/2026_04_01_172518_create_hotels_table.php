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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['hotel','resort', 'apartment', 'villa','riad', 'other']);
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('image');
            $table->integer('price');
            $table->string('description');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('availability')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
