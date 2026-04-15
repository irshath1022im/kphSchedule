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
        Schema::create('service_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_request_id');
            $table->foreign('service_request_id')->references('id')->on('service_requests')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->date('service_date');
            $table->date('end_date')->nullable();
            $table->boolean('material_consumption')->default(true);
            $table->text('description')->nullable();
            $table->integer('worked_hours')->default(0);
            $table->integer('assigned_maids')->default(0);
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_charges');
    }
};
