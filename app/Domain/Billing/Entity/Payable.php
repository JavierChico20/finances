<?php

declare(strict_types=1);

namespace App\Domain\Billing\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'payables')]
class Payable
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(type: 'string', length: 160)]
    private string $descricao;

    #[ORM\Column(type: 'integer')]
    private int $valorEmCentavos;

    #[ORM\Column(type: 'string', length: 3)]
    private string $moeda;

    #[ORM\Column(type: 'date_immutable')]
    private DateTimeImmutable $vencimento;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $parcela = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $totalParcelas = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $pagoEm = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $comprovantePath = null;

    public function __construct(
        string $id,
        string $descricao,
        int $valorEmCentavos,
        string $moeda,
        DateTimeImmutable $vencimento,
        ?int $parcela = null,
        ?int $totalParcelas = null
    ) {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->valorEmCentavos = $valorEmCentavos;
        $this->moeda = strtoupper($moeda);
        $this->vencimento = $vencimento;
        $this->parcela = $parcela;
        $this->totalParcelas = $totalParcelas;
    }

    // getters (pode gerar depois conforme necessidade)
    public function id(): string { return $this->id; }
    public function descricao(): string { return $this->descricao; }
    public function valorEmCentavos(): int { return $this->valorEmCentavos; }
    public function moeda(): string { return $this->moeda; }
    public function vencimento(): DateTimeImmutable { return $this->vencimento; }
    public function parcela(): ?int { return $this->parcela; }
    public function totalParcelas(): ?int { return $this->totalParcelas; }
    public function pagoEm(): ?DateTimeImmutable { return $this->pagoEm; }
    public function comprovantePath(): ?string { return $this->comprovantePath; }

    // regras de negócio
    public function marcarComoPago(DateTimeImmutable $quando, ?string $comprovantePath = null): void
    {
        $this->pagoEm = $quando;
        $this->comprovantePath = $comprovantePath;
    }
}
