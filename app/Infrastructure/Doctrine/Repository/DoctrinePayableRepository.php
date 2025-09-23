<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Billing\Entity\Payable;
use App\Domain\Billing\Repository\PayableRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePayableRepository implements PayableRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function byId(string $id): ?Payable
    {
        return $this->em->find(Payable::class, $id);
    }

    public function add(Payable $p): void
    {
        $this->em->persist($p);
    }

    public function remove(Payable $p): void
    {
        $this->em->remove($p);
    }

    public function listByPeriod(\DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('p')
           ->from(Payable::class, 'p')
           ->where('p.vencimento BETWEEN :from AND :to')
           ->setParameter('from', $from)
           ->setParameter('to', $to)
           ->orderBy('p.vencimento', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
