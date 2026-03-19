<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {

            // Hero Section
            $table->string('banner_image')->nullable()->after('status');
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();

            // Overview
            $table->longText('overview')->nullable();

            // Specifications (JSON)
            $table->json('specs')->nullable();

            // Collections
            $table->string('collections_title')->nullable();
            $table->text('collections_description')->nullable();

            // FAQs (JSON)
            $table->json('faqs')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'banner_image',
                'title',
                'subtitle',
                'overview',
                'specs',
                'collections_title',
                'collections_description',
                'faqs',
                'meta_title',
                'meta_description',
            ]);
        });
    }
};
