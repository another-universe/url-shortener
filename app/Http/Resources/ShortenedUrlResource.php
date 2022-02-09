<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Contracts\Services\UrlShortener\ShortenedUrlEntity;

class ShortenedUrlResource extends JsonResource
{
    public function __construct(ShortenedUrlEntity $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'url' => $this->resource->getUrl(),
        ];
    }
}
