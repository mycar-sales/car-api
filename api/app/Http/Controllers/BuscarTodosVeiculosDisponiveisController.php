<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosDisponiveisUseCase;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * Class BuscarTodosVeiculosDisponiveisController
 * @package App\Http\Controllers
 */
class BuscarTodosVeiculosDisponiveisController extends Controller
{
    /**
     * @var BuscarTodosVeiculosDisponiveisUseCase
     */
    private BuscarTodosVeiculosDisponiveisUseCase $buscarTodosVeiculosDisponiveisUseCase;

    /**
     * @param BuscarTodosVeiculosDisponiveisUseCase $buscarTodosVeiculosDisponiveisUseCase
     */
    public function __construct(BuscarTodosVeiculosDisponiveisUseCase $buscarTodosVeiculosDisponiveisUseCase)
    {
        $this->buscarTodosVeiculosDisponiveisUseCase = $buscarTodosVeiculosDisponiveisUseCase;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $veiculos = $this->buscarTodosVeiculosDisponiveisUseCase->executar();

            return response()->json($veiculos);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno do servidor'], 500);
        }
    }
}
