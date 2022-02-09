<?php

declare(strict_types=1);

namespace App\Contracts\Services\UrlShortener;

use App\Data\Url;

interface UrlShortenerService
{
    /**
     * Create shortened URL.
     */
    public function create(Url $url): ShortenedUrlEntity;

    /**
     * Track redirect to shortened url.
     */
    public function trackRedirect(ShortenedUrlEntity $url);
}
