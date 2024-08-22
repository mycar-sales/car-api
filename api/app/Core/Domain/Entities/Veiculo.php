<?php
declare(strict_types=1);

namespace App\Core\Domain\Entities;

use App\Core\Domain\ValueObjects\VeiculoMarca;
use App\Core\Domain\ValueObjects\VeiculoModelo;
use App\Core\Domain\ValueObjects\VeiculoCor;
use App\Core\Domain\ValueObjects\VeiculoPreco;

/**
 * Class Veiculo
 * @package App\Core\Domain\Entities
 */
class Veiculo
{
    /**
     * @var VeiculoMarca
     */
    private VeiculoMarca $marca;
    /**
     * @var VeiculoModelo
     */
    private VeiculoModelo $modelo;
    /**
     * @var int
     */
    private int $ano;
    /**
     * @var VeiculoCor
     */
    private VeiculoCor $cor;
    /**
     * @var VeiculoPreco
     */
    private VeiculoPreco $preco;

    /**
     * @param VeiculoMarca $marca
     * @param VeiculoModelo $modelo
     * @param int $ano
     * @param VeiculoCor $cor
     * @param VeiculoPreco $preco
     */
    public function __construct(
        VeiculoMarca  $marca,
        VeiculoModelo $modelo,
        int           $ano,
        VeiculoCor    $cor,
        VeiculoPreco  $preco
    )
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->cor = $cor;
        $this->preco = $preco;
    }

    /**
     * @return VeiculoMarca
     */
    public function getMarca(): VeiculoMarca
    {
        return $this->marca;
    }

    /**
     * @return VeiculoModelo
     */
    public function getModelo(): VeiculoModelo
    {
        return $this->modelo;
    }

    /**
     * @return int
     */
    public function getAno(): int
    {
        return $this->ano;
    }

    /**
     * @return VeiculoCor
     */
    public function getCor(): VeiculoCor
    {
        return $this->cor;
    }

    /**
     * @return VeiculoPreco
     */
    public function getPreco(): VeiculoPreco
    {
        return $this->preco;
    }

    /**
     * @param VeiculoMarca $marca
     */
    public function setMarca(VeiculoMarca $marca): void
    {
        $this->marca = $marca;
    }

    /**
     * @param VeiculoModelo $modelo
     */
    public function setModelo(VeiculoModelo $modelo): void
    {
        $this->modelo = $modelo;
    }

    /**
     * @param int $ano
     */
    public function setAno(int $ano): void
    {
        $this->ano = $ano;
    }

    /**
     * @param VeiculoCor $cor
     */
    public function setCor(VeiculoCor $cor): void
    {
        $this->cor = $cor;
    }

    /**
     * @param VeiculoPreco $preco
     */
    public function setPreco(VeiculoPreco $preco): void
    {
        $this->preco = $preco;
    }
}
