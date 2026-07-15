<?php

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $translations = [
            'en' => [
                'groups.main' => 'Main',
                'groups.about' => 'About',
                'groups.more' => 'More',
                'items.home' => 'Home',
                'items.courses' => 'Courses',
                'items.programs' => 'Programs',
                'items.about-learncore' => 'About LearnCore',
                'items.welcome-speech' => 'Welcome Speech',
                'items.general-information' => 'General Information',
                'items.vision-mission-goal' => 'Vision / Mission / Goal',
                'items.services-recreation' => 'Services & Recreation',
                'items.alumni' => 'Alumni',
                'items.contact' => 'Contact',
                'items.faq' => 'FAQ',
            ],
            'km' => [
                'groups.main' => 'ម៉ឺនុយ',
                'groups.about' => 'អំពីយើង',
                'groups.more' => 'ច្រើនទៀត',
                'items.home' => 'ទំព័រដើម',
                'items.courses' => 'មុខវិជ្ជាសិក្សា',
                'items.programs' => 'កម្មវិធីសិក្សា',
                'items.about-learncore' => 'អំពី LearnCore',
                'items.welcome-speech' => 'សុន្ទរកថាស្វាគមន៍',
                'items.general-information' => 'ព័ត៌មានទូទៅ',
                'items.vision-mission-goal' => 'ចក្ខុវិស័យ / បេសកកម្ម / គោលដៅ',
                'items.services-recreation' => 'សេវាកម្ម និងការកម្សាន្ត',
                'items.alumni' => 'អតីតសិស្ស',
                'items.contact' => 'ទំនាក់ទំនង',
                'items.faq' => 'សំណួរញឹកញាប់',
            ],
            'fr' => [
                'groups.main' => 'Menu',
                'groups.about' => 'À propos',
                'groups.more' => 'Plus',
                'items.home' => 'Accueil',
                'items.courses' => 'Cours',
                'items.programs' => 'Programmes',
                'items.about-learncore' => 'À propos de LearnCore',
                'items.welcome-speech' => 'Mot de bienvenue',
                'items.general-information' => 'Informations générales',
                'items.vision-mission-goal' => 'Vision / Mission / Objectif',
                'items.services-recreation' => 'Services et loisirs',
                'items.alumni' => 'Anciens élèves',
                'items.contact' => 'Contact',
                'items.faq' => 'FAQ',
            ],
            'zh' => [
                'groups.main' => '菜单',
                'groups.about' => '关于我们',
                'groups.more' => '更多',
                'items.home' => '首页',
                'items.courses' => '课程',
                'items.programs' => '项目',
                'items.about-learncore' => '关于 LearnCore',
                'items.welcome-speech' => '欢迎致辞',
                'items.general-information' => '基本信息',
                'items.vision-mission-goal' => '愿景 / 使命 / 目标',
                'items.services-recreation' => '服务与活动',
                'items.alumni' => '校友',
                'items.contact' => '联系我们',
                'items.faq' => '常见问题',
            ],
        ];

        Language::query()->get()->each(function (Language $language) use ($translations): void {
            $values = $translations[$language->code] ?? $translations[$language->locale] ?? $translations['en'];

            foreach ($values as $key => $value) {
                Translation::query()->updateOrCreate(
                    [
                        'language_id' => $language->id,
                        'group' => 'navigation',
                        'key' => $key,
                    ],
                    ['value' => $value],
                );
            }
        });
    }

    public function down(): void
    {
        Translation::query()
            ->where('group', 'navigation')
            ->whereIn('key', [
                'groups.main',
                'groups.about',
                'groups.more',
                'items.home',
                'items.courses',
                'items.programs',
                'items.about-learncore',
                'items.welcome-speech',
                'items.general-information',
                'items.vision-mission-goal',
                'items.services-recreation',
                'items.alumni',
                'items.contact',
                'items.faq',
            ])
            ->delete();
    }
};
