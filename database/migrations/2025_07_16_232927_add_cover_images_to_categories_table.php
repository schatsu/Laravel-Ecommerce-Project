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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('landing_cover_image')->nullable()->after('is_landing');
            $table->string('featured_cover_image')->nullable()->after('is_featured');
            $table->string('collection_cover_image')->nullable()->after('is_collection');
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('landing_cover_image');
            $table->dropColumn('featured_cover_image');
            $table->dropColumn('collection_cover_image');
        });
    }
};
