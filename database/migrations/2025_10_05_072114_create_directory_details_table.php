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
        Schema::create('directory_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('directory_id')
                  ->constrained('directories')
                  ->restrictOnDelete();
            $table->string('icon')->nullable();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('file_path'); // path di storage/public/files/
            $table->string('file_type')->nullable(); // pdf, jpg, docx, dll
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directory_details');
    }
};
