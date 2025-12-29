<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('type')->default('delivery')->after('user_id');
            $table->boolean('default_delivery')->default(false)->after('default_invoice');
            $table->boolean('default_billing')->default(false)->after('default_delivery');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['type', 'default_delivery', 'default_billing']);
        });
    }
};
