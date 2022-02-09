<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Services\UrlShortener\ShortenedUrlEntity;

/**
 * App\Models\ShortenedUrl
 *
 * @property int $id
 * @property string $original_url
 * @property string $path
 * @property int $redirects
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl whereRedirects($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortenedUrl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShortenedUrl extends Model implements ShortenedUrlEntity
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shortened_urls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'original_url', 'path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * Get value of shortened url.
     */
    public function getUrl(): string
    {
        return \route('url-shortener.redirect', ['shortened_url' => $this->path]);
    }

    /**
     * Get original url.
     */
    public function getOriginalUrl(): string
    {
        return $this->original_url;
    }

    /**
     * Increment "redirects" column.
     */
    public function incrementRedirects(): int
    {
        return $this->increment('redirects', 1);
    }
}
