<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Contracts\Services\UrlShortener\ShortenedUrlEntity;
use App\Contracts\Services\UrlShortener\UrlShortenerService;
use Throwable;

class TrackRedirectToUrlJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly ShortenedUrlEntity $shortenedUrl,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(UrlShortenerService $service): void
    {
        try {
            $service->trackRedirect($this->shortenedUrl);
        } catch (Throwable $e) {
            \report($e);
            // Тут мы делаем просто репорт, но необходимо рассматривать это больше как псевдо код.
// Просто предполагается, что мы каким-то образом обрабатываем исключение: повторяем попытку, делаем ещё что-то и т.д.
        }
    }
}
