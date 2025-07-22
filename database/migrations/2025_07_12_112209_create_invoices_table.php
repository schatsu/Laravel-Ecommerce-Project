<?php

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Order;
use App\Models\User;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
//            $table->foreignIdFor(Order::class)->nullable()->constrained()->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('address');

            $table->foreignIdFor(Country::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(City::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(District::class)->constrained()->cascadeOnDelete();

            $table->string('identity_number')->nullable();

            $table->string('company_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('tax_office')->nullable();

            $table->boolean('default_invoice')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
