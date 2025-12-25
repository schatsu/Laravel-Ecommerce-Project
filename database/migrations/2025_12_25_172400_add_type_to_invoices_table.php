<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('type')->default('delivery')->after('user_id'); // delivery, billing
            $table->boolean('default_delivery')->default(false)->after('default_invoice');
            $table->boolean('default_billing')->default(false)->after('default_delivery');
        });

        // Mevcut varsayılan adresleri güncelle
        DB::table('invoices')
            ->where('default_invoice', true)
            ->update([
                'default_delivery' => true,
                'default_billing' => true,
            ]);
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['type', 'default_delivery', 'default_billing']);
        });
    }
};
