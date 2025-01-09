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
class Veiculo extends BaseEntity
{
    /**
     * @param VeiculoMarca $marca
     * @param VeiculoModelo $modelo
     * @param int $ano
     * @param VeiculoCor $cor
     * @param VeiculoPreco $preco
     * @param $placa
     * @param bool $disponivel
     * @param int|null $id
     */
    public function __construct(
        private VeiculoMarca $marca,
        private VeiculoModelo $modelo,
        private int $ano,
        private VeiculoCor $cor,
        private VeiculoPreco $preco,
        private $placa,
        private bool $disponivel = true,
        private ?int $id = null
    ) {
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

    /**
     * @return mixed
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    public function isDisponivel(): bool
    {
        return $this->disponivel;
    }

    /**
     * @param mixed $placa
     */
    public function setPlaca($placa): void
    {
        $this->placa = $placa;
    }

    public function setDisponivel(bool $disponivel): void
    {
        $this->disponivel = $disponivel;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
