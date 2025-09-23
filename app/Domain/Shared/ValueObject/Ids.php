<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Symfony\Component\Uid\Ulid;

final class Ids
{
    public static function newUlid(): string
    {
        return (string) new Ulid();
    }
}
