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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('show_projects_section')->default(true);
            $table->boolean('show_testimonials_section')->default(true);
            $table->boolean('show_blog_section')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('favicon')->nullable();
            $table->string('meta_description')->nullable();
            $table->mediumText('meta_keywords')->nullable();
            $table->string('turkey_phone_number')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('show_projects_section');
            $table->dropColumn('show_testimonials_section');
            $table->dropColumn('show_blog_section');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_image');
            $table->dropColumn('favicon');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('turkey_phone_number');
        });
    }
};
