<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('attending', ['yes', 'no', 'maybe'])->default('maybe');
            $table->boolean('allergies')->default(false);
            $table->text('allergies_description')->nullable();
            $table->text('providing_stuff')->nullable();
            $table->boolean('drinking_alcohol')->default(false);
            $table->boolean('bringing_fursuit')->default(false);
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_options');
    }
};
