<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\BuscarVeiculoPorIdUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

/**
 * Class BuscarVeiculoPorIdController
 * @package App\Http\Controllers
 * @OA\Get(
 *     path="/veiculos/{id}",
 *     summary="Buscar um veículo pelo ID",
 *     tags={"Veículos"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do veículo",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Veículo encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="marca", type="string", example="Toyota"),
 *             @OA\Property(property="modelo", type="string", example="Corolla"),
 *             @OA\Property(property="ano", type="integer", example=2022),
 *             @OA\Property(property="cor", type="string", example="Red"),
 *             @OA\Property(property="preco", type="number", format="float", example=10000.00),
 *             @OA\Property(property="placa", type="string", example="ABC-1234"),
 *             @OA\Property(property="disponivel", type="bolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Veículo não encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Veículo não encontrado")
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
class BuscarVeiculoPorIdController extends Controller
{
    /**
     * @var BuscarVeiculoPorIdUseCase
     */
    private BuscarVeiculoPorIdUseCase $buscarVeiculoPorIdUseCase;

    /**
     * @param BuscarVeiculoPorIdUseCase $buscarVeiculoPorIdUseCase
     */
    public function __construct(BuscarVeiculoPorIdUseCase $buscarVeiculoPorIdUseCase)
    {
        $this->buscarVeiculoPorIdUseCase = $buscarVeiculoPorIdUseCase;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $veiculo = $this->buscarVeiculoPorIdUseCase->executar($id);

            if ($veiculo === null) {
                throw new NotFoundHttpException('Veículo não encontrado');
            }

            return response()->json($veiculo->toArray());
        } catch (NotFoundHttpException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno do servidor'], 500);
        }
    }
}

