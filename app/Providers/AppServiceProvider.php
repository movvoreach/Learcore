<?php

namespace App\Providers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Ktith\Laravelexceptionnotifier\Events\ExceptionNotifier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\Filament\Support\Contracts\LoadingIndicator::class, \App\Support\CustomLoadingIndicator::class);
        $this->app->bind(\Filament\Auth\Http\Responses\Contracts\LoginResponse::class, \App\Http\Responses\FilamentLoginResponse::class);
        $this->app->extend('translation.loader', fn ($loader, $app) => new \App\Translation\DatabaseTranslationLoader(
            $loader,
            $app->make(\App\Services\Localization\LocalizationService::class),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_START,
            fn (): string => Blade::render('
                <div wire:loading class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/30 backdrop-blur-[2px]">
                    <div class="flex flex-col items-center gap-3 p-6 bg-white dark:bg-gray-900 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-800">
                        <x-filament::loading-indicator class="h-10 w-10 text-primary-600 dark:text-primary-400" />
                    </div>
                </div>
            '),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => '<link rel="stylesheet" href="'.asset('backend/plugins/fontawesome-free/css/all.min.css').'">'
        );

        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');

            // ── Security Headers ────────────────────────────────────────────
            // Injected on every response to harden the HTTP layer against
            // clickjacking, MIME-sniffing, and information leakage attacks.
            \Illuminate\Support\Facades\Event::listen(
                \Illuminate\Foundation\Http\Events\RequestHandled::class,
                function (\Illuminate\Foundation\Http\Events\RequestHandled $event): void {
                    $response = $event->response;

                    if (! method_exists($response, 'header')) {
                        return;
                    }

                    // Prevent clickjacking — deny embedding in iframes
                    $response->header('X-Frame-Options', 'SAMEORIGIN');

                    // Prevent MIME-type sniffing
                    $response->header('X-Content-Type-Options', 'nosniff');

                    // Prevent sending referrer outside origin
                    $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

                    // Disable browser features not used by this app
                    $response->header('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

                    // Legacy XSS protection (for older browsers)
                    $response->header('X-XSS-Protection', '1; mode=block');

                    // Remove server fingerprinting headers
                    $response->headers->remove('X-Powered-By');
                    $response->headers->remove('Server');
                }
            );
        }

        Gate::before(function ($user): ?bool {
            return $user->hasRole('super_admin') ? true : null;
        });

        Table::configureUsing(function (Table $table): void {
            $table->deferLoading();
        });

        TextInput::configureUsing(function (TextInput $component): void {
            $component->placeholder(function (TextInput $component) {
                $label = $component->getLabel();
                if (empty($label)) {
                    return null;
                }
                return 'បញ្ចូល' . str_replace('*', '', $label);
            });
        });

        Select::configureUsing(function (Select $component): void {
            $component->placeholder(function (Select $component) {
                $label = $component->getLabel();
                if (empty($label)) {
                    return 'ជ្រើសរើសជម្រើស';
                }
                return 'ជ្រើសរើស' . str_replace('*', '', $label);
            });
        });

        DatePicker::configureUsing(function (DatePicker $component): void {
            $component->placeholder(function (DatePicker $component) {
                $label = $component->getLabel();
                if (empty($label)) {
                    return 'ជ្រើសរើសថ្ងៃ';
                }
                return 'ជ្រើសរើស' . str_replace('*', '', $label);
            });
        });

        Queue::failing(function (JobFailed $event) {
            if (config('exception-notifier.exception_notify_enabled')) {
                event(new ExceptionNotifier($event->exception));
            }
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            \App\Models\ActivityLog::create([
                'action' => 'logged_in',
                'model_type' => get_class($event->user),
                'model_id' => $event->user->id ?? null,
                'user_id' => $event->user->id ?? null,
                'ip_address' => request()->ip(),
            ]);
        });

        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            if ($event->user) {
                \App\Models\ActivityLog::create([
                    'action' => 'logged_out',
                    'model_type' => get_class($event->user),
                    'model_id' => $event->user->id,
                    'user_id' => $event->user->id,
                    'ip_address' => request()->ip(),
                ]);
            }
        });

        \Filament\Actions\Action::configureUsing(function (\Filament\Actions\Action $action): void {
            if (in_array($action->getName(), ['create', 'save'])) {
                $action->extraAttributes([
                    'x-init' => '$watch(\'isProcessing\', (value) => { if (value) processingMessage = \'កំពុងបញ្ចូល...\' })',
                ]);
            }
        });
    }
}
