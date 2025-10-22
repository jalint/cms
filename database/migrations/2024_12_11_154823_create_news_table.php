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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title_id');
            $table->string('title_en');
            $table->string('slug_id');
            $table->string('slug_en');
            $table->text('content_id');
            $table->text('content_en');
            $table->string('url_image');
            $table->tinyInteger('is_highlight');
            $table->integer('view_count')->default(0);
            $table->tinyInteger("is_auto_translate")->nullable();
            $table->tinyInteger("is_publish")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
