<?php
declare(strict_types=1);

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarTodosVeiculosVendidosUseCase
 * @package App\Core\Domain\UseCases
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

