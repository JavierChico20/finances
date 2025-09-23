<?php

declare(strict_types=1);

namespace App\Domain\Billing\Repository;

use App\Domain\Billing\Entity\Payable;

interface PayableRepository
{
    public function byId(string $id): ?Payable;
    public function add(Payable $p): void;
    public function remove(Payable $p): void;

    /** @return list<Payable> */
    public function listByPeriod(\DateTimeImmutable $from, \DateTimeImmutable $to): array;
}
