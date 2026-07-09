<footer class="learning-footer">
    <div class="learning-footer__inner">
        <div class="learning-footer-brand">
            <a class="learning-footer-logo" href="{{ route('dashboard') }}">
                <span><i class="fas fa-book-open"></i></span>
                <strong>Moodle LMS</strong>
            </a>

            <p>
                ប្រព័ន្ធគ្រប់គ្រងការសិក្សាសម្រាប់សាលា សិស្ស គ្រូបង្រៀន
                និងការរៀនតាមឌីជីថល។
            </p>
        </div>

        <div class="learning-footer-links">
            <h3>មាតិកា</h3>

            <a href="{{ route('frontend.courses') }}">
                មុខវិជ្ជាសិក្សា
            </a>

            <a href="{{ route('frontend.courses') }}">
                វគ្គសិក្សាពេញនិយម
            </a>

            <a href="#news">
                ព័ត៌មាន
            </a>
        </div>

        <div class="learning-footer-links">
            <h3>ជំនួយ</h3>

            <a href="#faq">
                FAQ
            </a>

            <a href="{{ route('login') }}">
                ចូលប្រើប្រាស់
            </a>

            <a href="{{ \Illuminate\Support\Facades\Route::has('register') ? route('register') : route('login') }}">
                ចុះឈ្មោះ
            </a>
        </div>

        <div class="learning-footer-contact">
            <h3>ទំនាក់ទំនង</h3>

            <p>
                <i class="fas fa-envelope"></i>
                info@learncore.local
            </p>

            <p>
                <i class="fas fa-location-dot"></i>
                Learning Center, Cambodia
            </p>

            <div class="learning-footer-social">
                <a href="https://facebook.com"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="https://t.me/MovVoreach"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Telegram">
                    <i class="fab fa-telegram-plane"></i>
                </a>

                <a href="https://youtube.com"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="learning-footer-bottom">
        <span>
            © {{ date('Y') }} Moodle LMS. រក្សាសិទ្ធិគ្រប់យ៉ាង។
        </span>

        <span>
            Powered by LearnCore
        </span>
    </div>
</footer>
