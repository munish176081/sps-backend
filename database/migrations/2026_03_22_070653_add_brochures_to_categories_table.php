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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('project_book_image')->nullable()->after('gallery');
            $table->string('project_book_file')->nullable();

            $table->string('range_image')->nullable();
            $table->string('range_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'project_book_image',
                'project_book_file',
                'range_image',
                'range_file',
            ]);
        });
    }
};
