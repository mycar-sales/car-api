<?php

declare(strict_types=1);

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;

/**
 * Class BuscarTodosVeiculosDisponiveisUseCase
 * @package App\Core\Domain\UseCases
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
