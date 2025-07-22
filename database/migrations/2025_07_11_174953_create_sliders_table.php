<?php

use App\Enums\Admin\SliderStatusEnum;
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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->index();
            $table->string('subtitle')->nullable()->index();
            $table->string('image')->nullable()->index();
            $table->string('link_title')->nullable()->index();
            $table->string('link_url')->nullable()->index();
            $table->integer('order')->default(1);
            $table->string('status')->default(SliderStatusEnum::ACTIVE)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
