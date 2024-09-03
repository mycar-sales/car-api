<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VeiculosSeeder extends Seeder
{
    public function run()
    {
        $veiculos = [
            ['marca' => 'Toyota', 'modelo' => 'Corolla', 'ano' => 2022, 'cor' => 'Branco', 'preco' => 100000.00, 'placa' => 'ABC-1234'],
            ['marca' => 'Honda', 'modelo' => 'Civic', 'ano' => 2021, 'cor' => 'Preto', 'preco' => 95000.00, 'placa' => 'DEF-5678'],
            ['marca' => 'Ford', 'modelo' => 'Mustang', 'ano' => 2020, 'cor' => 'Vermelho', 'preco' => 150000.00, 'placa' => 'GHI-9012'],
            ['marca' => 'Chevrolet', 'modelo' => 'Camaro', 'ano' => 2019, 'cor' => 'Amarelo', 'preco' => 120000.00, 'placa' => 'JKL-3456'],
            ['marca' => 'Nissan', 'modelo' => 'Altima', 'ano' => 2018, 'cor' => 'Azul', 'preco' => 80000.00, 'placa' => 'MNO-7890'],
            ['marca' => 'Hyundai', 'modelo' => 'Elantra', 'ano' => 2020, 'cor' => 'Cinza', 'preco' => 90000.00, 'placa' => 'PQR-2345'],
            ['marca' => 'Kia', 'modelo' => 'Optima', 'ano' => 2019, 'cor' => 'Prata', 'preco' => 85000.00, 'placa' => 'STU-6789'],
            ['marca' => 'Volkswagen', 'modelo' => 'Golf', 'ano' => 2017, 'cor' => 'Verde', 'preco' => 70000.00, 'placa' => 'VWX-3456'],
            ['marca' => 'Fiat', 'modelo' => 'Punto', 'ano' => 2016, 'cor' => 'Branco', 'preco' => 60000.00, 'placa' => 'YZA-1234'],
            ['marca' => 'Renault', 'modelo' => 'Clio', 'ano' => 2015, 'cor' => 'Azul', 'preco' => 55000.00, 'placa' => 'BCD-5678'],
            ['marca' => 'Mazda', 'modelo' => '3', 'ano' => 2018, 'cor' => 'Preto', 'preco' => 80000.00, 'placa' => 'EFG-9012'],
            ['marca' => 'Subaru', 'modelo' => 'Impreza', 'ano' => 2017, 'cor' => 'Vermelho', 'preco' => 85000.00, 'placa' => 'HIJ-3456'],
            ['marca' => 'Mitsubishi', 'modelo' => 'Lancer', 'ano' => 2016, 'cor' => 'Cinza', 'preco' => 75000.00, 'placa' => 'KLM-7890'],
            ['marca' => 'BMW', 'modelo' => '320i', 'ano' => 2015, 'cor' => 'Branco', 'preco' => 110000.00, 'placa' => 'NOP-2345'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'C200', 'ano' => 2018, 'cor' => 'Prata', 'preco' => 120000.00, 'placa' => 'QRS-6789'],
            ['marca' => 'Audi', 'modelo' => 'A4', 'ano' => 2017, 'cor' => 'Preto', 'preco' => 130000.00, 'placa' => 'TUV-3456'],
            ['marca' => 'Volvo', 'modelo' => 'S60', 'ano' => 2019, 'cor' => 'Azul', 'preco' => 140000.00, 'placa' => 'WXY-1234'],
            ['marca' => 'Peugeot', 'modelo' => '308', 'ano' => 2020, 'cor' => 'Vermelho', 'preco' => 90000.00, 'placa' => 'ZAB-5678'],
            ['marca' => 'Citroën', 'modelo' => 'C4', 'ano' => 2018, 'cor' => 'Branco', 'preco' => 95000.00, 'placa' => 'CDE-9012'],
            ['marca' => 'Jeep', 'modelo' => 'Renegade', 'ano' => 2019, 'cor' => 'Verde', 'preco' => 110000.00, 'placa' => 'FGH-3456'],
            ['marca' => 'Land Rover', 'modelo' => 'Range Rover', 'ano' => 2021, 'cor' => 'Cinza', 'preco' => 220000.00, 'placa' => 'IJK-7890'],
            ['marca' => 'Jaguar', 'modelo' => 'XE', 'ano' => 2020, 'cor' => 'Preto', 'preco' => 210000.00, 'placa' => 'LMN-2345'],
            ['marca' => 'Ferrari', 'modelo' => '488', 'ano' => 2019, 'cor' => 'Vermelho', 'preco' => 500000.00, 'placa' => 'OPQ-6789'],
            ['marca' => 'Lamborghini', 'modelo' => 'Huracán', 'ano' => 2018, 'cor' => 'Amarelo', 'preco' => 600000.00, 'placa' => 'RST-3456'],
            ['marca' => 'Porsche', 'modelo' => '911', 'ano' => 2020, 'cor' => 'Prata', 'preco' => 450000.00, 'placa' => 'UVW-1234'],
            ['marca' => 'Tesla', 'modelo' => 'Model S', 'ano' => 2021, 'cor' => 'Azul', 'preco' => 300000.00, 'placa' => 'XYZ-5678'],
            ['marca' => 'Alfa Romeo', 'modelo' => 'Giulia', 'ano' => 2017, 'cor' => 'Branco', 'preco' => 120000.00, 'placa' => 'ABC-9012'],
            ['marca' => 'Maserati', 'modelo' => 'Ghibli', 'ano' => 2018, 'cor' => 'Preto', 'preco' => 250000.00, 'placa' => 'DEF-3456'],
            ['marca' => 'Aston Martin', 'modelo' => 'DB11', 'ano' => 2019, 'cor' => 'Verde', 'preco' => 500000.00, 'placa' => 'GHI-6789'],
            ['marca' => 'Bentley', 'modelo' => 'Continental', 'ano' => 2021, 'cor' => 'Cinza', 'preco' => 600000.00, 'placa' => 'JKL-1234'],
        ];

        foreach ($veiculos as &$veiculo) {
            $veiculo['disponivel'] = true;  // Set default value for 'disponivel'
        }

        DB::table('veiculos')->insert($veiculos);
    }
}
