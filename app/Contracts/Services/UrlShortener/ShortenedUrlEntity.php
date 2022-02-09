<?php

declare(strict_types=1);

namespace App\Contracts\Services\UrlShortener;

interface ShortenedUrlEntity
{
    /**
     * Get value of shortened url.
     */
    public function getUrl(): string;

    /**
     * Get original url.
     */
    public function getOriginalUrl(): string;

    /**
     * Increment "redirects" column.
     */
    public function incrementRedirects(): int;
}
