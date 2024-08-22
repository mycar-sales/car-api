<?php
declare(strict_types=1);

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarTodosVeiculosDisponiveisUseCase
 * @package App\Core\Domain\UseCases
 */
class BuscarTodosVeiculosDisponiveisUseCase
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
     * @return array
     */
    public function executar(): array
    {
        return $this->veiculoRepository->findAllAvailable();
    }
}

