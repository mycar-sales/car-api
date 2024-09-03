<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Core\Domain\Entities\Veiculo;
use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoPreco;
use Illuminate\Support\Facades\DB;

class VeiculoRepository implements VeiculoRepositoryInterface
{
    public function save(Veiculo $veiculo): void
    {
        DB::table('veiculos')->insert(
            [
            'marca' => $veiculo->getMarca()->getValue(),
            'modelo' => $veiculo->getModelo()->getValue(),
            'ano' => $veiculo->getAno(),
            'cor' => $veiculo->getCor()->getValue(),
            'preco' => $veiculo->getPreco()->getValue(),
            'placa' => $veiculo->getPlaca(),
            ]
        );
    }

    public function update(Veiculo $veiculo): void
    {
        DB::table('veiculos')
            ->where('id', $veiculo->getId())
            ->update(
                [
                'marca' => $veiculo->getMarca()->getValue(),
                'modelo' => $veiculo->getModelo()->getValue(),
                'ano' => $veiculo->getAno(),
                'cor' => $veiculo->getCor()->getValue(),
                'preco' => $veiculo->getPreco()->getValue(),
                'placa' => $veiculo->getPlaca(),
                'disponivel' => $veiculo->isDisponivel(),
                ]
            );
    }

    public function findById(int $id): ?Veiculo
    {
        $veiculo = DB::table('veiculos')->where('id', $id)->first();

        if (!$veiculo) {
            return null;
        }

        return new Veiculo(
            new VeiculoMarca($veiculo->marca),
            new VeiculoModelo($veiculo->modelo),
            $veiculo->ano,
            new VeiculoCor($veiculo->cor),
            new VeiculoPreco((float) $veiculo->preco),
            $veiculo->placa,
            (bool) $veiculo->disponivel
        );
    }

    public function findAllAvailable(): array
    {
        $veiculos = DB::table('veiculos')
            ->where('disponivel', true)
            ->orderBy('preco')
            ->get()->toArray();

        return array_map(
            function ($veiculo) {
                return new Veiculo(
                    new VeiculoMarca($veiculo->marca),
                    new VeiculoModelo($veiculo->modelo),
                    $veiculo->ano,
                    new VeiculoCor($veiculo->cor),
                    new VeiculoPreco((float) $veiculo->preco),
                    $veiculo->placa,
                );
            },
            $veiculos
        );
    }

    public function findAllSold(): array
    {
        $veiculos = DB::table('veiculos')
            ->where('disponivel', false)
            ->orderBy('preco')
            ->get()->toArray();

        return array_map(
            function ($veiculo) {
                return new Veiculo(
                    new VeiculoMarca($veiculo->marca),
                    new VeiculoModelo($veiculo->modelo),
                    $veiculo->ano,
                    new VeiculoCor($veiculo->cor),
                    new VeiculoPreco((float) $veiculo->preco),
                    $veiculo->placa,
                );
            },
            $veiculos
        );
    }

    public function sum ($a, $b)
    {
        if($a && $b){
            return $a + $b;
        }

        return 0;
    }

    public function sub ($a, $b)
    {
        if($a && $b){
            return $a - $b;
        }

        return 0;
    }

    public function mult ($a, $b)
    {
        if($a && $b){
            return $a * $b;
        }

        return 0;
    }

    public function div ($a, $b)
    {
        if($a && $b){
            return $a / $b;
        }
        return 0;
    }

}
