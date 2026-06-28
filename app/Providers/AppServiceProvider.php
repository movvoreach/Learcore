<?php

namespace App\Providers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Table;
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
        if (config('app.env') === 'production' || str_contains(request()->getHost(), 'onrender.com')) {
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
