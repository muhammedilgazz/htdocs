<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Yeni alanlar ekle
            if (!Schema::hasColumn('blogs', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (!Schema::hasColumn('blogs', 'content')) {
                $table->longText('content')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('blogs', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('content');
            }
            if (!Schema::hasColumn('blogs', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('excerpt');
            }
            if (!Schema::hasColumn('blogs', 'tags')) {
                $table->string('tags')->nullable()->after('featured_image');
            }
            if (!Schema::hasColumn('blogs', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('tags');
            }
            if (!Schema::hasColumn('blogs', 'views')) {
                $table->unsignedInteger('views')->default(0)->after('status');
            }
            if (!Schema::hasColumn('blogs', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('views');
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'content', 'excerpt', 'featured_image',
                'tags', 'status', 'views', 'published_at'
            ]);
        });
    }
};
