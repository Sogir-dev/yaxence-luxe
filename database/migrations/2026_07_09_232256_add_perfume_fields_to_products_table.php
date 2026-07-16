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
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->default('unisex')->after('slug'); // men, women, unisex
            $table->string('concentration')->nullable()->after('description'); // e.g. Eau de Parfum
            $table->unsignedSmallInteger('size_ml')->nullable()->after('concentration');
            $table->string('top_notes')->nullable()->after('size_ml');
            $table->string('heart_notes')->nullable()->after('top_notes');
            $table->string('base_notes')->nullable()->after('heart_notes');
            $table->boolean('featured')->default(false)->after('base_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'concentration', 'size_ml', 'top_notes', 'heart_notes', 'base_notes', 'featured',
            ]);
        });
    }
};
