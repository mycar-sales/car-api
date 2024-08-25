<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosVendidosUseCase;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * Class BuscarTodosVeiculosVendidosController
 * @package App\Http\Controllers
 * @OA\Get(
 *     path="/veiculos/vendidos",
 *     summary="Buscar todos os veículos vendidos",
 *     tags={"Veículos"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de veículos vendidos",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="marca", type="string", example="Toyota"),
 *                     @OA\Property(property="modelo", type="string", example="Corolla"),
 *                     @OA\Property(property="ano", type="integer", example=2022),
 *                     @OA\Property(property="cor", type="string", example="Red"),
 *                     @OA\Property(property="preco", type="number", format="float", example=10000.00),
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Erro interno do servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Erro interno do servidor")
 *         )
 *     )
 * )
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
