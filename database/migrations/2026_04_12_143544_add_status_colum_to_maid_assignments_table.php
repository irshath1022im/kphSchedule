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
        Schema::table('maid_assignments', function (Blueprint $table) {
            //
            $table->string('status')->default('assigned'); // New column with default value 'assigned'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maid_assignments', function (Blueprint $table) {
            //
            $table->dropColumn('status'); // Remove the column if rolling back
        });
    }
};
