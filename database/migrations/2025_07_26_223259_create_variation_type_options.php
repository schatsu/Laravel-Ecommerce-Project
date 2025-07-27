<?php

use App\Models\VariationType;
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
        Schema::create('variation_type_options', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(VariationType::class)->index()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_type_options');
    }
};
