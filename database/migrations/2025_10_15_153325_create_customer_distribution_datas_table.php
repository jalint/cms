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
        Schema::create('customer_distribution_datas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_distribution_legend_id')
              ->constrained('customer_distribution_legends', 'id', 'fk_cd_legend_id')
              ->restrictOnDelete();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('name')->unique();
            $table->string('image');
            $table->string('title_id');
            $table->string('title_en');
            $table->text('description_id');
            $table->text('description_en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_distribution_data');
    }
};
