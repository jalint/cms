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
        Schema::create("company_profiles", function (Blueprint $table) {
            $table->id();
            $table->string("hero_title_id");
            $table->string("hero_title_en");
            $table->string("badge_id");
            $table->string("badge_en");
            $table->text("title_id");
            $table->text("title_en");
            $table->text("description_id");
            $table->text("description_en");
            $table->text("visi_id");
            $table->text("visi_en");
            $table->text("misi_id");
            $table->text("misi_en");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("company_profiles");
    }
};
