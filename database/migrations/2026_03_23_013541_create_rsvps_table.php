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
        Schema::create('rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('attending')->nullable();
            $table->boolean('has_allergies')->default(false);
            $table->text('allergies')->nullable();
            $table->text('bringing')->nullable();
            $table->boolean('bringing_music_equipment')->default(false);
            $table->boolean('drinking_alcohol')->default(false);
            $table->boolean('bringing_fursuit')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
