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
        Schema::create('service_media_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_card_id')
                    ->nullable()
                    ->constrained('service_cards')
                    ->nullOnDelete();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('file');
            $table->string('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_media_cards');
    }
};
