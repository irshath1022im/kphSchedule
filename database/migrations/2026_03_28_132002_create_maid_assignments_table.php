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
        Schema::create('maid_assignments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('maid_id');
            $table->unsignedBigInteger('service_request_period_id');
            $table->foreign('service_request_period_id')->references('id')->on('service_request_periods')->onDelete('cascade');
            $table->foreign('maid_id')->references('id')->on('maids')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maid_assignments');
    }
};
