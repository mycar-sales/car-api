<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\BuscarTodosVeiculosDisponiveisUseCase;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * Class BuscarTodosVeiculosDisponiveisController
 * @package App\Http\Controllers
 * @OA\Get(
 *     path="/veiculos/disponiveis",
 *     summary="Buscar todos os veículos disponíveis",
 *     tags={"Veículos"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de veículos disponíveis",
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
 *                     @OA\Property(property="placa", type="string", example="ABC-1234")
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

            return response()->json($veiculos->toArray());
        } catch (Exception $e) {
            return response()->json(['message' =>  'Erro interno do servidor'], 500);
        }
    }
}
