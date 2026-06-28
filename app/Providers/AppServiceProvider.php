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
        //
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
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">កំពុងដំណើរការ...</span>
                    </div>
                </div>
            '),
        );

        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
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
    }
}
