<?php

declare(strict_types=1);

namespace App\Core\Domain\Veiculos\UseCases;

use App\Core\Domain\Veiculos\Entities\Veiculo;
use App\Core\Domain\Veiculos\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoCor;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoMarca;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoModelo;
use App\Core\Domain\Veiculos\ValueObjects\VeiculoPreco;

/**
 * Class CadastrarVeiculoUseCase
 * @package App\Core\Domain\Veiculos\UseCases
 */
class CadastrarVeiculoUseCase
{
    /**
     * @var VeiculoRepositoryInterface
     */
    private VeiculoRepositoryInterface $veiculoRepository;

    /**
     * @param VeiculoRepositoryInterface $veiculoRepository
     */
    public function __construct(VeiculoRepositoryInterface $veiculoRepository)
    {
        $this->veiculoRepository = $veiculoRepository;
    }

    /**
     * @param array $data
     * @return void
     */
    public function execute(array $data): void
    {
        $veiculo = new Veiculo(
            new VeiculoMarca($data['marca']),
            new VeiculoModelo($data['modelo']),
            $data['ano'],
            new VeiculoCor($data['cor']),
            new VeiculoPreco($data['preco']),
            $data['placa']
        );
        $this->veiculoRepository->save($veiculo);
    }
}
