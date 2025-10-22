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
        Schema::create("milestone_details", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("milestone_id")
                ->constrained("milestones")
                ->noActionOnDelete()
                ->noActionOnUpdate();
            $table->year("year")->unique();
            $table->string("image");
            $table->string("title_id");
            $table->string("title_en");
            $table->text("description_id");
            $table->text("description_en");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("milestone_details");
    }
};
