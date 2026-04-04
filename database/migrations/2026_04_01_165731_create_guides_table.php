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
        Schema::create('guides', function (Blueprint $table) {
            $table->id() ;
               $table->string('name');
               $table->string('phone');
               $table->string('language');
               $table->string('experience');
               $table->string('price');
               $table->string('image');
               $table->string('description');
               $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
               $table->boolean('status')->default(true);
               $table->boolean('is_deleted')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
