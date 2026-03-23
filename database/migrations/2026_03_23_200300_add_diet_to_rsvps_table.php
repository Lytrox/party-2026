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
        Schema::table('rsvps', function (Blueprint $table) {
            $table->boolean('is_vegetarian')->default(false)->after('bringing_fursuit');
            $table->boolean('is_vegan')->default(false)->after('is_vegetarian');
        });
    }

    public function down(): void
    {
        Schema::table('rsvps', function (Blueprint $table) {
            $table->dropColumn(['is_vegetarian', 'is_vegan']);
        });
    }
};
