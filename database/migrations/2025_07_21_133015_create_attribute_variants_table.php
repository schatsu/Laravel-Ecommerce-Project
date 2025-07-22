<?php

use App\Models\AttributeValue;
use App\Models\ProductVariant;
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
        Schema::create('attribute_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductVariant::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Attribute::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(AttributeValue::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_variants');
    }
};
