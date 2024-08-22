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
        DB::table('veiculos')->insert([
            'marca' => $veiculo->getMarca()->getValue(),
            'modelo' => $veiculo->getModelo()->getValue(),
            'ano' => $veiculo->getAno(),
            'cor' => $veiculo->getCor()->getValue(),
            'preco' => $veiculo->getPreco()->getValue(),
        ]);
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
            new VeiculoPreco($veiculo->preco)
        );
    }

    public function findAllAvailable(): array
    {
        $veiculos = DB::table('veiculos')->where('disponivel', true)->get()->toArray();

        return array_map(function ($veiculo) {
            return new Veiculo(
                new VeiculoMarca($veiculo->marca),
                new VeiculoModelo($veiculo->modelo),
                $veiculo->ano,
                new VeiculoCor($veiculo->cor),
                new VeiculoPreco($veiculo->preco)
            );
        }, $veiculos);
    }

    public function findAllSold(): array
    {
        $veiculos = DB::table('veiculos')->where('disponivel', false)->get()->toArray();

        return array_map(function ($veiculo) {
            return new Veiculo(
                new VeiculoMarca($veiculo->marca),
                new VeiculoModelo($veiculo->modelo),
                $veiculo->ano,
                new VeiculoCor($veiculo->cor),
                new VeiculoPreco($veiculo->preco)
            );
        }, $veiculos);
    }
}
