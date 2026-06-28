<?php

namespace Ktith\Laravelexceptionnotifier\Listeners;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ktith\Laravelexceptionnotifier\Events\ExceptionNotifier;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SendApplicationExceptionNotification
{
    /**
     * @var \Throwable
     */
    private $exception;

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(ExceptionNotifier $event)
    {
        if (! config('exception-notifier.exception_notify_enabled')) {
            return;
        }

        $telegramToken = config('exception-notifier.telegram-error.token');
        $telegramChatId = config('exception-notifier.telegram-error.chat_id');

        if (blank($telegramToken) || blank($telegramChatId)) {
            Log::warning('Telegram exception notifier is enabled but token or chat id is missing.');
            return;
        }

        $userAgent = request()->header('user-agent', 'N/A');
        $ip = request()->ip();
        $ipInfo = null;

        try {
            $ipInfo = Http::timeout(2)
                ->acceptJson()
                ->get("https://ipinfo.io/{$ip}/json")
                ->object();
        } catch (\Exception $exception) {
            Log::debug('Unable to fetch IP info for exception notifier.', [
                'message' => $exception->getMessage(),
            ]);
        }

        $this->exception = $event->exception;
        $errorMessage = $this->exception->getMessage();

        if (
            config('exception-notifier.enable_notify_when_access_not_found')
            && $this->exception instanceof NotFoundHttpException
        ) {
            $errorMessage = 'Route not found! URL requested: '.url()->current();
        }

        $message = Str::limit($this->buildMessage($errorMessage, $ipInfo, $ip, $userAgent), 4000, '...');

        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->asForm()
                ->post('https://api.telegram.org/bot'.$telegramToken.'/sendMessage', [
                    'chat_id' => $telegramChatId,
                    'text' => $message,
                ]);

            if ($response->failed()) {
                Log::warning('Telegram exception notification failed.', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Exception $exception) {
            Log::warning('Telegram exception notification could not be sent.', [
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function buildMessage(string $errorMessage, ?object $ipInfo, ?string $ip, string $userAgent): string
    {
        $title = "🚨 Exceptions from ".config('app.name')." ".config('app.env')." 🚨\n";

        $body = $errorMessage."\n\n".
            "⚙️Env • ".config('app.env')."\n".
            "❗️File • ".$this->exception->getFile()." ".
            "🚀Line • ".$this->exception->getLine()."\n\n".
            "🕛 ".now('Asia/Phnom_Penh')->toRfc850String()."\n".
            "📍 ".($ipInfo->loc ?? 'N/A')."\n".
            "🔗 ".url()->current()."\n".
            "📶 WIFI • ".($ip ?? 'N/A')."\n".
            "🌍 ".($ipInfo->region ?? 'N/A')."\n".
            "📱 ".$userAgent;

        if (auth()->check()) {
            $body = $body."\n"."🤵‍♂️ ".auth()->user()->name."\n";
        }

        return $title."\n".$body;
    }
}
