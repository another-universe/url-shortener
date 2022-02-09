<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Services\UrlShortener\UrlShortenerService;
use App\Models\ShortenedUrl;
use App\Http\Requests\ShortenUrlRequest;
use App\Http\Resources\ShortenedUrlResource;
use App\Data\Url;
use App\Jobs\TrackRedirectToUrlJob;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class UrlShortenerController extends Controller
{
    /**
     * Show view.
     */
    public function index(): Response
    {
        return \response()->view('url-shortener.index');
    }

    /**
     * Shorten URL.
     */
    public function shorten(ShortenUrlRequest $request, UrlShortenerService $service): JsonResponse
    {
        $url = new Url(value: $request->input('url'));
        /** @var \App\Contracts\Services\UrlShortener\ShortenedUrlEntity */
        $shortenedUrl = $service->create($url);

        return ShortenedUrlResource::make($shortenedUrl)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Redirect to url.
     */
    public function redirect(ShortenedUrl $shortenedUrl): RedirectResponse
    {
        $originalUrl = $shortenedUrl->getOriginalUrl();
        TrackRedirectToUrlJob::dispatchAfterResponse($shortenedUrl);

        return \redirect()->away($originalUrl);
    }
}
