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
        //
        Schema::table('service_charges', function (Blueprint $table) {
            $table->renameColumn('service_date', 'invoice_date');
            $table->dropForeign(['service_id']); // Drop the foreign key constraint if it exists
            $table->dropColumn('service_id'); // Drop the service_id column if it's no longer needed
            $table->dropColumn(['end_date', 'worked_hours', 'assigned_maids']); // Drop the end_date column if it's no longer needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('service_charges', function (Blueprint $table) {
            $table->renameColumn('invoice_date', 'service_date');
            $table->unsignedBigInteger('service_id')->nullable(); // Add the service_id column back if needed
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null'); // Add the foreign key constraint back if needed
        });
    }
};
