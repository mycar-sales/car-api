<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosVendidosUseCase;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * Class BuscarTodosVeiculosVendidosController
 * @package App\Http\Controllers
 */
class BuscarTodosVeiculosVendidosController extends Controller
{
    /**
     * @var BuscarTodosVeiculosVendidosUseCase
     */
    private BuscarTodosVeiculosVendidosUseCase $buscarTodosVeiculosVendidosUseCase;

    /**
     * @param BuscarTodosVeiculosVendidosUseCase $buscarTodosVeiculosVendidosUseCase
     */
    public function __construct(BuscarTodosVeiculosVendidosUseCase $buscarTodosVeiculosVendidosUseCase)
    {
        $this->buscarTodosVeiculosVendidosUseCase = $buscarTodosVeiculosVendidosUseCase;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $veiculos = $this->buscarTodosVeiculosVendidosUseCase->executar();

            return response()->json($veiculos);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno do servidor'], 500);
        }
    }
}
