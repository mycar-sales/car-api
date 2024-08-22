<?php
declare(strict_types=1);

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\Veiculo;

/**
 *
 */
interface VeiculoRepositoryInterface
{
    /**
     * @param Veiculo $veiculo
     * @return void
     */
    public function save(Veiculo $veiculo): void;

    /**
     * @param int $id
     * @return Veiculo|null
     */
    public function findById(int $id): ?Veiculo;

    /**
     * @return array
     */
    public function findAllAvailable(): array;

    /**
     * @return array
     */
    public function findAllSold(): array;
}

