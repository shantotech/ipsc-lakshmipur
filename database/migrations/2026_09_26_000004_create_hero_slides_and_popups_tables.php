<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('media_type', 10)->default('image'); // image | video
            $table->string('image')->nullable();                 // photo, or poster for a video
            $table->string('video')->nullable();
            $table->string('eyebrow_en')->nullable();
            $table->string('eyebrow_bn')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_bn')->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_bn')->nullable();
            $table->string('button_label_en')->nullable();
            $table->string('button_label_bn')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_bn')->nullable();
            $table->text('body_en')->nullable();
            $table->text('body_bn')->nullable();
            $table->string('image')->nullable();
            $table->string('button_label_en')->nullable();
            $table->string('button_label_bn')->nullable();
            $table->string('button_url')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popups');
        Schema::dropIfExists('hero_slides');
    }
};
