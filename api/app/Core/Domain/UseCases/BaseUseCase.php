<?php
declare(strict_types=1);

namespace App\Core\Domain\UseCases;

/**
 * Class BaseUseCase
 * @package App\Core\Domain\UseCases
 */
abstract class BaseUseCase
{
    /**
     * @var array
     */
    protected array $veiculos = [];

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($veiculo) {
            return [
                'marca' => $veiculo->getMarca()->getValue(),
                'modelo' => $veiculo->getModelo()->getValue(),
                'ano' => $veiculo->getAno(),
                'cor' => $veiculo->getCor()->getValue(),
                'preco' => $veiculo->getPreco()->getValue(),
                'disponivel' => $veiculo->isDisponivel(),
                'placa' => $veiculo->getPlaca()
            ];
        }, $this->veiculos);
    }
}
