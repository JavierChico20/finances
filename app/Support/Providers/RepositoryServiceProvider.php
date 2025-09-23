<?php

declare(strict_types=1);

namespace App\Support\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Billing\Repository\PayableRepository;
use App\Infrastructure\Doctrine\Repository\DoctrinePayableRepository;
use Doctrine\ORM\EntityManagerInterface;

final class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PayableRepository::class, function ($app) {
            /** @var EntityManagerInterface $em */
            $em = $app->make(EntityManagerInterface::class);
            return new DoctrinePayableRepository($em);
        });
    }

    public function boot(): void
    {
        // “Unit of Work” simples: flush no final da request
        $this->app->terminating(function () {
            if ($this->app->bound(EntityManagerInterface::class)) {
                $em = $this->app->make(EntityManagerInterface::class);
                if ($em->isOpen()) {
                    $em->flush();
                }
            }
        });
    }
}
