<?php

declare(strict_types=1);

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateVeiculoUseCase
{
    private VeiculoRepositoryInterface $veiculoRepository;

    public function __construct(VeiculoRepositoryInterface $veiculoRepository)
    {
        $this->veiculoRepository = $veiculoRepository;
    }

    public function executar(int $id, array $data): void
    {
        $veiculo = $this->veiculoRepository->findById($id);

        if ($veiculo === null) {
            throw new NotFoundHttpException('Veículo não encontrado');
        }

        $veiculo->setId($id);
        $veiculo->setMarca(new VeiculoMarca($data['marca']));
        $veiculo->setModelo(new VeiculoModelo($data['modelo']));
        $veiculo->setAno($data['ano']);
        $veiculo->setCor(new VeiculoCor($data['cor']));
        $veiculo->setPreco(new VeiculoPreco($data['preco']));
        $veiculo->setPlaca($data['placa']);
        $veiculo->setDisponivel($data['disponivel'] ?? $veiculo->isDisponivel());

        $this->veiculoRepository->update($veiculo);
    }
}
