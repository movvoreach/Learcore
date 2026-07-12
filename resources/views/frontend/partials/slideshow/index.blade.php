@php
    $slides = [
        [
            'image' => asset('backend/dist/img/slide/Slider-scaled.jpg'),
            'badge_icon' => 'fas fa-graduation-cap',
            'badge' => 'វេទិកាសិក្សាឌីជីថល',
            'title' => 'ប្រព័ន្ធគ្រប់គ្រងការសិក្សាទំនើប',
            'highlight' => 'សម្រាប់ស្ថាប័នអប់រំ និងអ្នកសិក្សា',
            'description' => 'LearnCore LMS ជួយរៀបចំមុខវិជ្ជា មេរៀន សកម្មភាពសិក្សា និងការតាមដានវឌ្ឍនភាពឱ្យមានរបៀបច្បាស់លាស់ សុវត្ថិភាព និងងាយស្រួលប្រើប្រាស់សម្រាប់សិស្ស គ្រូបង្រៀន និងអ្នកគ្រប់គ្រង។',
            'primary_text' => 'ចូលប្រើប្រព័ន្ធ',
            'primary_url' => route('login'),
            'secondary_text' => 'មើលមុខវិជ្ជាសិក្សា',
            'secondary_url' => route('frontend.courses'),
        ],
        [
            'image' => asset('backend/dist/img/slide/SPI-Campus-no-logo-Crop.png'),
            'badge_icon' => 'fas fa-book-open',
            'badge' => 'មាតិកាសិក្សាមានរចនាសម្ព័ន្ធ',
            'title' => 'គាំទ្រការរៀន និងបង្រៀន',
            'highlight' => 'តាមរយៈមេរៀន ឯកសារ និងវីដេអូ',
            'description' => 'អ្នកសិក្សាអាចចូលមើលព័ត៌មានវគ្គសិក្សា មេរៀន ឯកសារបង្រៀន និងសម្ភារៈបន្ថែមបានយ៉ាងងាយស្រួល ខណៈគ្រូបង្រៀនអាចរៀបចំមាតិកា និងតាមដានការចូលរួមបានប្រកបដោយប្រសិទ្ធភាព។',
            'primary_text' => 'ចូលរៀនតាមប្រព័ន្ធ',
            'primary_url' => route('login'),
            'secondary_text' => 'ស្វែងរកមុខវិជ្ជា',
            'secondary_url' => route('frontend.courses'),
        ],
        [
            'image' => asset('backend/dist/img/slide/Commencement-Day-2025-51-scaled.jpg'),
            'badge_icon' => 'fas fa-chart-line',
            'badge' => 'តាមដាន និងវាយតម្លៃ',
            'title' => 'ទិន្នន័យសិក្សាច្បាស់លាស់',
            'highlight' => 'សម្រាប់ការសម្រេចចិត្តបានល្អប្រសើរ',
            'description' => 'ប្រព័ន្ធផ្តល់ព័ត៌មានសង្ខេបអំពីវគ្គសិក្សា មេរៀន កាលវិភាគ ការចូលរួម និងលទ្ធផលសិក្សា ដើម្បីឱ្យគ្រូបង្រៀន និងអ្នកគ្រប់គ្រងអាចតាមដានដំណើរការអប់រំបានទាន់ពេលវេលា។',
            'primary_text' => 'ចូលផ្ទាំងគ្រប់គ្រង',
            'primary_url' => route('login'),
            'secondary_text' => 'អំពីប្រព័ន្ធ',
            'secondary_url' => route('frontend.about'),
        ],
    ];
@endphp

<section class="learning-slideshow learning-slideshow--carousel" aria-label="Learning platform introduction">
    <div class="learning-slideshow__inner">
        <div class="learning-slide-carousel" data-learning-slideshow>
            <div class="learning-slide-track">
                @foreach($slides as $index => $slide)
                    <article
                        class="learning-slide-panel {{ $index === 0 ? 'is-active' : '' }}"
                        data-learning-slide
                        style="--slide-image: url('{{ $slide['image'] }}');"
                    >
                        <div class="learning-slide-copy">
                            <div class="learning-slide-badge">
                                <i class="{{ $slide['badge_icon'] }}" aria-hidden="true"></i>
                                <span>{{ $slide['badge'] }}</span>
                            </div>

                            <h1>
                                {{ $slide['title'] }}
                                <span>{{ $slide['highlight'] }}</span>
                            </h1>

                            <p>{{ $slide['description'] }}</p>

                            <div class="learning-slide-actions">
                                <a href="{{ $slide['primary_url'] }}" class="learning-slide-btn learning-slide-btn--primary">
                                    {{ $slide['primary_text'] }}
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>

                                <a href="{{ $slide['secondary_url'] }}" class="learning-slide-btn learning-slide-btn--ghost">
                                    {{ $slide['secondary_text'] }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="learning-slide-controls" aria-label="Slideshow controls">
                <button type="button" class="learning-slide-arrow" data-learning-prev data-no-loading aria-label="Previous slide">
                    <i class="fas fa-chevron-left" aria-hidden="true"></i>
                </button>

                <div class="learning-slide-dots">
                    @foreach($slides as $index => $slide)
                        <button
                            type="button"
                            class="{{ $index === 0 ? 'is-active' : '' }}"
                            data-learning-dot="{{ $index }}"
                            data-no-loading
                            aria-label="Show slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>

                <button type="button" class="learning-slide-arrow" data-learning-next data-no-loading aria-label="Next slide">
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <aside class="learning-notice-card">
            <div class="learning-notice-head">
                <div class="learning-notice-title">
                    <i class="far fa-bell" aria-hidden="true"></i>
                    <strong>ព័ត៌មាន និងសេចក្តីជូនដំណឹង</strong>
                </div>
                <span>ប្រចាំថ្ងៃ</span>
            </div>

            <div class="learning-notice-list">
                <article class="learning-notice-item">
                    <div>
                        <small>សេចក្តីជូនដំណឹងសិក្សា</small>
                        <h2>ការរៀបចំវគ្គសិក្សាសម្រាប់ឆ្នាំសិក្សា ២០២៥-២០២៦</h2>
                        <p>សិស្ស និស្សិត និងគ្រូបង្រៀនអាចចូលប្រើ LearnCore LMS ដើម្បីពិនិត្យមុខវិជ្ជា មេរៀន និងកាលវិភាគសិក្សាដែលបានធ្វើបច្ចុប្បន្នភាព។</p>
                    </div>
                    <time datetime="2026-07-10">July 10, 2026</time>
                </article>

                <article class="learning-notice-item">
                    <div>
                        <small>បច្ចុប្បន្នភាពប្រព័ន្ធ</small>
                        <h2>មុខវិជ្ជា និងមាតិកាសិក្សាត្រូវបានបន្ថែមជាបន្តបន្ទាប់</h2>
                        <p>គ្រូបង្រៀនអាចបន្ថែមមេរៀន ឯកសារ វីដេអូ និងសកម្មភាពសិក្សា ដើម្បីគាំទ្រការរៀនរបស់សិស្សឱ្យកាន់តែមានប្រសិទ្ធភាព។</p>
                    </div>
                    <time datetime="2026-07-05">July 05, 2026</time>
                </article>
            </div>
        </aside>
    </div>
</section>

@once
    <style>
        .learning-slideshow--carousel {
            background: #071750;
        }

        .learning-slideshow--carousel .learning-slideshow__inner {
            grid-template-columns: minmax(0, 1fr) minmax(360px, .42fr);
        }

        .learning-slide-carousel {
            position: relative;
            min-height: 570px;
            overflow: hidden;
        }

        .learning-slide-track,
        .learning-slide-panel {
            min-height: 570px;
        }

        .learning-slide-panel {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            background:
                linear-gradient(90deg, rgba(8, 21, 75, .94), rgba(8, 21, 75, .72) 52%, rgba(8, 21, 75, .36)),
                var(--slide-image) center / cover no-repeat;
            transition: opacity .55s ease, visibility .55s ease;
        }

        .learning-slide-panel.is-active {
            opacity: 1;
            visibility: visible;
            position: relative;
        }

        .learning-slide-panel .learning-slide-copy {
            max-width: 830px;
            padding: 64px 80px 92px 0;
        }

        .learning-slide-controls {
            position: absolute;
            left: 0;
            right: 36px;
            bottom: 26px;
            z-index: 4;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .learning-slide-arrow,
        .learning-slide-dots button {
            border: 0;
            cursor: pointer;
        }

        .learning-slide-arrow {
            width: 42px;
            height: 42px;
            display: inline-grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 50%;
            background: rgba(255, 255, 255, .11);
            color: #fff;
            transition: background .18s ease, transform .18s ease;
        }

        .learning-slide-arrow:hover {
            background: rgba(255, 255, 255, .2);
            transform: translateY(-1px);
        }

        .learning-slide-dots {
            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .learning-slide-dots button {
            width: 10px;
            height: 10px;
            padding: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .42);
            transition: width .2s ease, border-radius .2s ease, background .2s ease;
        }

        .learning-slide-dots button.is-active {
            width: 34px;
            border-radius: 999px;
            background: #ff9f1c;
        }

        @media (max-width: 1199.98px) {
            .learning-slideshow--carousel .learning-slideshow__inner {
                grid-template-columns: 1fr;
            }

            .learning-slide-panel .learning-slide-copy {
                padding-right: 0;
            }
        }

        @media (max-width: 767.98px) {
            .learning-slide-carousel,
            .learning-slide-track,
            .learning-slide-panel {
                min-height: 590px;
            }

            .learning-slide-panel {
                background:
                    linear-gradient(180deg, rgba(8, 21, 75, .95), rgba(8, 21, 75, .78)),
                    var(--slide-image) center / cover no-repeat;
            }

            .learning-slide-panel .learning-slide-copy {
                padding: 44px 0 88px;
            }

            .learning-slide-controls {
                right: 0;
                justify-content: center;
            }
        }
    </style>
@endonce

@push('scripts')
    <script>
        $(function() {
            const $carousel = $('[data-learning-slideshow]');

            if (!$carousel.length) {
                return;
            }

            const $slides = $carousel.find('[data-learning-slide]');
            const $dots = $carousel.find('[data-learning-dot]');
            let currentIndex = 0;
            let timer = null;

            function showSlide(index) {
                currentIndex = (index + $slides.length) % $slides.length;
                $slides.removeClass('is-active').eq(currentIndex).addClass('is-active');
                $dots.removeClass('is-active').eq(currentIndex).addClass('is-active');
            }

            function startTimer() {
                timer = window.setInterval(function() {
                    showSlide(currentIndex + 1);
                }, 5500);
            }

            function restartTimer() {
                window.clearInterval(timer);
                startTimer();
            }

            $carousel.find('[data-learning-prev]').on('click', function(event) {
                event.preventDefault();
                showSlide(currentIndex - 1);
                restartTimer();
            });

            $carousel.find('[data-learning-next]').on('click', function(event) {
                event.preventDefault();
                showSlide(currentIndex + 1);
                restartTimer();
            });

            $dots.on('click', function(event) {
                event.preventDefault();
                showSlide(Number($(this).data('learning-dot')));
                restartTimer();
            });

            startTimer();
        });
    </script>
@endpush
