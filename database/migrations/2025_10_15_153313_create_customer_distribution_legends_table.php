<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_distribution_legends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_distribution_id')
                  ->constrained('customer_distributions')
                  ->noActionOnDelete();
            $table->string('hex')->unique();
            $table->string('legenda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_distribution_legends');
    }
};
