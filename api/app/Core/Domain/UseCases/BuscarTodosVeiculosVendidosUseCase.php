<?php
declare(strict_types=1);

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarTodosVeiculosVendidosUseCase
 * @package App\Core\Domain\UseCases
 */
class BuscarTodosVeiculosVendidosUseCase
{
    /**
     * @var VeiculoRepositoryInterface
     */
    private VeiculoRepositoryInterface $veiculoRepositorio;

    /**
     * @param VeiculoRepositoryInterface $veiculoRepositorio
     */
    public function __construct(VeiculoRepositoryInterface $veiculoRepositorio)
    {
        $this->veiculoRepositorio = $veiculoRepositorio;
    }

    /**
     * @return array
     */
    public function executar(): array
    {
        return $this->veiculoRepositorio->findAllSold();
    }
}

