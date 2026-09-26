<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category', 30)->default('general')->index();

            // English is required; Bangla is optional and falls back to English.
            $table->string('title_en');
            $table->string('title_bn')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_bn')->nullable();
            $table->longText('body_en')->nullable();
            $table->longText('body_bn')->nullable();

            $table->string('attachment')->nullable();
            $table->date('published_on')->index();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(true)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
