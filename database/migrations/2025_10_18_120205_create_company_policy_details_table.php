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
        Schema::create("company_policy_details", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("company_policy_id")
                ->constrained("company_policies")
                ->noActionOnDelete()
                ->noActionOnUpdate();
            $table->string("title_id");
            $table->string("title_en");
            $table->text("policy_id");
            $table->text("policy_en");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("company_policies_details");
    }
};
