<?php

declare(strict_types=1);

namespace App\Core\Domain\Veiculos\UseCases;

use App\Core\Domain\Veiculos\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarTodosVeiculosVendidosUseCase
 * @package App\Core\Domain\Veiculos\UseCases
 */
class BuscarTodosVeiculosVendidosUseCase extends BaseUseCase
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
     * @return BuscarTodosVeiculosVendidosUseCase
     */
    public function executar(): self
    {
        $this->veiculos = $this->veiculoRepositorio->findAllSold();
        return $this;
    }
}
