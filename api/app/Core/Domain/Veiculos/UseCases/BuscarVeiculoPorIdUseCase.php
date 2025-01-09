<?php

declare(strict_types=1);

namespace App\Core\Domain\Veiculos\UseCases;

use App\Core\Domain\Veiculos\Entities\Veiculo;
use App\Core\Domain\Veiculos\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarVeiculoPorIdUseCase
 * @package App\Core\Application\UseCases
 */
class BuscarVeiculoPorIdUseCase extends BaseUseCase
{
    /**
     * @var VeiculoRepositoryInterface
     */
    private VeiculoRepositoryInterface $veiculoRepository;

    /**
     * @param VeiculoRepositoryInterface $veiculoRepositorio
     */
    public function __construct(VeiculoRepositoryInterface $veiculoRepositorio)
    {
        $this->veiculoRepository = $veiculoRepositorio;
    }

    /**
     * @param int $id
     * @return Veiculo|null
     */
    public function executar(int $id): ?Veiculo
    {
        return $this->veiculoRepository->findById($id);
    }
}
