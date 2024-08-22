<?php
declare(strict_types=1);

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;

/**
 * Class CadastrarVeiculoUseCase
 * @package App\Core\Domain\UseCases
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
            new VeiculoPreco($data['preco'])
        );
        $this->veiculoRepository->save($veiculo);
    }
}
