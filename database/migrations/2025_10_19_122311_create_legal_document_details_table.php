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
        Schema::create("legal_document_details", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("legal_document_id")
                ->constrained("legal_documents")
                ->noActionOnDelete()
                ->noActionOnUpdate();
            $table->string("banner");
            $table->string("file");
            $table->string("title_id");
            $table->string("title_en");
            $table->text("description_id");
            $table->text("description_en");
            $table->boolean("is_highlight")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("legal_document_detail");
    }
};
