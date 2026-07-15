<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('group')->index();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('text');
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
        });

        Schema::create('navigation_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('navigation_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('navigation_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('navigation_items')->nullOnDelete();
            $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->nullable()->index();
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('target')->default('_self');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['navigation_group_id', 'parent_id', 'is_active', 'sort_order'], 'navigation_items_tree_index');
        });

        $this->seedDefaults();
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
        Schema::dropIfExists('navigation_groups');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('settings');
    }

    private function seedDefaults(): void
    {
        $now = now();

        DB::table('settings')->insert([
            ['group' => 'general', 'key' => 'site_name', 'value' => 'LearnCore LMS', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'general', 'key' => 'short_name', 'value' => 'LearnCore', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'logo', 'value' => 'backend/dist/img/logo.png', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'dark_logo', 'value' => 'backend/dist/img/logo.png', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'favicon', 'value' => 'backend/dist/img/spilogo.png', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'header_logo', 'value' => 'backend/dist/img/logo.png', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'footer_logo', 'value' => 'backend/dist/img/logo.png', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'hero_image', 'value' => null, 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'primary_color', 'value' => '#ff5b00', 'type' => 'color', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'branding', 'key' => 'secondary_color', 'value' => '#2563eb', 'type' => 'color', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'contact', 'key' => 'address', 'value' => 'Phnom Penh, Cambodia', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'contact', 'key' => 'phone', 'value' => '(855) 23 999 999', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'contact', 'key' => 'email', 'value' => 'info@learncore.com', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'social_links', 'key' => 'facebook', 'value' => 'https://www.facebook.com/', 'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'social_links', 'key' => 'youtube', 'value' => 'https://www.youtube.com/', 'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'footer', 'key' => 'copyright', 'value' => 'LearnCore LMS All rights reserved.', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['group' => 'footer', 'key' => 'privacy_url', 'value' => '#', 'type' => 'url', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $mainId = DB::table('navigation_groups')->insertGetId([
            'name' => 'Main',
            'slug' => 'main',
            'sort_order' => 10,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $aboutId = DB::table('navigation_groups')->insertGetId([
            'name' => 'About',
            'slug' => 'about',
            'sort_order' => 20,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $moreId = DB::table('navigation_groups')->insertGetId([
            'name' => 'More',
            'slug' => 'more',
            'sort_order' => 30,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('navigation_items')->insert([
            ['navigation_group_id' => $mainId, 'title' => 'Home', 'slug' => 'home', 'url' => '/learning', 'icon' => 'fas fa-home', 'sort_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $mainId, 'title' => 'Courses', 'slug' => 'courses', 'url' => '/learning/courses', 'icon' => 'fas fa-graduation-cap', 'sort_order' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $mainId, 'title' => 'Programs', 'slug' => 'programs', 'url' => '/learning/programs', 'icon' => 'fas fa-layer-group', 'sort_order' => 30, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $aboutId, 'title' => 'About LearnCore', 'slug' => 'about-learncore', 'url' => '/learning/about', 'icon' => 'fas fa-info-circle', 'sort_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $aboutId, 'title' => 'Welcome Speech', 'slug' => 'welcome-speech', 'url' => '/learning/about/welcome-speech', 'icon' => 'fas fa-comment-dots', 'sort_order' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $aboutId, 'title' => 'General Information', 'slug' => 'general-information', 'url' => '/learning/about/general-info', 'icon' => 'fas fa-university', 'sort_order' => 30, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $aboutId, 'title' => 'Vision / Mission / Goal', 'slug' => 'vision-mission-goal', 'url' => '/learning/about/vision-mission-goal', 'icon' => 'fas fa-bullseye', 'sort_order' => 40, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $aboutId, 'title' => 'Services & Recreation', 'slug' => 'services-recreation', 'url' => '/learning/about/services-recreation', 'icon' => 'fas fa-swimming-pool', 'sort_order' => 50, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $aboutId, 'title' => 'Alumni', 'slug' => 'alumni', 'url' => '/learning/about/alumni', 'icon' => 'fas fa-user-graduate', 'sort_order' => 60, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $moreId, 'title' => 'Contact', 'slug' => 'contact', 'url' => '/learning/about#contact', 'icon' => 'fas fa-envelope', 'sort_order' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['navigation_group_id' => $moreId, 'title' => 'FAQ', 'slug' => 'faq', 'url' => '/learning/faqs', 'icon' => 'fas fa-question-circle', 'sort_order' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
};
