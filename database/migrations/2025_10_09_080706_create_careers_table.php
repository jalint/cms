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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('field_name_id');
            $table->string('field_name_en')->nullable();
            $table->string('major_id');
            $table->string('major_en')->nullable();
            $table->enum('employment_status', [
                'full_time',
                'part_time',
                'contract',
                'intern',
                'freelance',
            ])->nullable();
            $table->text('description_id');
            $table->text('description_en')->nullable();
            $table->string('google_form_link');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
