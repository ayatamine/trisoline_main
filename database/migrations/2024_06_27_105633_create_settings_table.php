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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name', 255);
            $table->string('app_logo', 255);
            $table->string('phone_number', 255)->nullable();
            $table->string('address', 255);
            $table->string('contact_email', 255);
            $table->string('facebook_link', 255)->nullable();
            $table->string('youtube_link', 255)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->string('linkedin_link', 255)->nullable();
            $table->string('twitter_link', 255)->nullable();
            $table->mediumText('intro_text')->nullable();
            $table->mediumText('intro_text_ar')->nullable();
            $table->mediumText('intro_sliding_words')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('video_section_link')->nullable();
            $table->mediumText('about_text')->nullable();
            $table->mediumText('about_text_ar')->nullable();
            $table->mediumText('vision_text')->nullable();
            $table->mediumText('vision_text_ar')->nullable();
            $table->mediumText('goals_text')->nullable();
            $table->mediumText('goals_text_ar')->nullable();
            $table->mediumText('values_text')->nullable();
            $table->mediumText('values_text_ar')->nullable();
            $table->string('default_lang')->default('ar');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
