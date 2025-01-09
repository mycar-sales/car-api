<?php

declare(strict_types=1);

namespace App\Core\Domain\Veiculos\UseCases;

use App\Core\Domain\Veiculos\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarTodosVeiculosDisponiveisUseCase
 * @package App\Core\Domain\Veiculos\UseCases
 */
class BuscarTodosVeiculosDisponiveisUseCase extends BaseUseCase
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
     * Executa o caso de uso e carrega os veículos disponíveis.
     *
     * @return self
     */
    public function executar(): self
    {
        $this->veiculos = $this->veiculoRepository->findAllAvailable();
        return $this;
    }
}
