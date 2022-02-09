<?php

declare(strict_types=1);

namespace App\Services\UrlShortener;

use App\Contracts\Services\UrlShortener\UrlShortenerService as ServiceContract;
use App\Contracts\Services\UrlShortener\ShortenedUrlEntity;
use App\Data\Url;
use App\Models\ShortenedUrl;
use Illuminate\Support\Str;
use App\Services\UrlShortener\Exceptions\GeneratePathException;

final class UrlShortenerService implements ServiceContract
{
    public function __construct(
        private int $pathLength,
    ) {
    }

    /**
     * Create shortened URL.
     */
    public function create(Url $url): ShortenedUrlEntity
    {
        return ShortenedUrl::resolveConnection()->transaction(function () use ($url) {
            $path = $this->generatePath();

            return ShortenedUrl::create([
                'original_url' => $url,
                'path' => $path,
            ]);
        });
    }

    /**
     * Generate unique path.
     *
     * @throws GeneratePathException
     */
    private function generatePath(): string
    {
        return \retry(5, function () {
            $path = Str::random($this->pathLength);

            if (ShortenedUrl::where('path', '=', $path)->exists()) {
                throw new GeneratePathException();
            }

            return $path;
        });
    }

    /**
     * Track redirect to shortened url.
     */
    public function trackRedirect(ShortenedUrlEntity $url): void
    {
        ShortenedUrl::resolveConnection()->transaction(static fn () => $url->incrementRedirects());
    }
}
