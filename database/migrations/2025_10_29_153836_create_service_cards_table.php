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
        Schema::create('service_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tab_id')
                  ->constrained('tabs')
                  ->restrictOnDelete();
            $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('service_cards')
                    ->nullOnDelete();
            $table->string('title_id'); // Analis Air
            $table->string('title_en');
            $table->string('background');
            $table->string('badge_id'); // Penjelasan Layanan
            $table->string('badge_en');
            $table->string('image')->nullable();
            $table->text('description_id');
            $table->text('description_en');
            $table->text('sub_description_id')->nullable();
            $table->text('sub_description_en')->nullable();
            $table->text('sub_description_one_id')->nullable();
            $table->text('sub_description_one_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_cards');
    }
};
