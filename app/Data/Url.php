<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class Url extends DataTransferObject
{
    public readonly string $value;

    public function __tostring(): string
    {
        return $this->value;
    }
}
