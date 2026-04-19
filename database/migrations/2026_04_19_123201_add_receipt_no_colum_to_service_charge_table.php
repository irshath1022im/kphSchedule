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
        Schema::table('service_charges', function (Blueprint $table) {
            //
            $table->string('receipt_no')->nullable()->after('amount');
            $table->string('payment_method')->nullable()->after('receipt_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_charges', function (Blueprint $table) {
            //
            $table->dropColumn('receipt_no');
            $table->dropColumn('payment_method');
        });
    }
};
