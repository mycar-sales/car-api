<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\UpdateVeiculoUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

/**
 * Class UpdateVeiculoController
 * @package App\Http\Controllers
 * @OA\Put(
 *     path="/v1/veiculos/{id}",
 *     summary="Atualizar veículo",
 *     description="Atualiza as informações de um veículo existente.",
 *     tags={"Veículos"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID do veículo a ser atualizado",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"marca", "modelo", "ano", "cor", "preco", "placa"},
 *                 @OA\Property(property="marca", type="string", example="Toyota"),
 *                 @OA\Property(property="modelo", type="string", example="Corolla"),
 *                 @OA\Property(property="ano", type="integer", example=2022),
 *                 @OA\Property(property="cor", type="string", example="Prata"),
 *                 @OA\Property(property="preco", type="number", format="float", example=10000.00),
 *                 @OA\Property(property="placa", type="string", example="XYZ-1234"),
 *                 @OA\Property(property="disponivel", type="boolean", example=true),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Veículo atualizado com sucesso",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Veículo atualizado com sucesso")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Erro de validação dos dados fornecidos",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Erro de validação")
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
class UpdateVeiculoController extends Controller
{

    /**
     * @var UpdateVeiculoUseCase
     */
    private UpdateVeiculoUseCase $updateVeiculoUseCase;

    /**
     * @param UpdateVeiculoUseCase $updateVeiculoUseCase
     */
    public function __construct(UpdateVeiculoUseCase $updateVeiculoUseCase)
    {
        $this->updateVeiculoUseCase = $updateVeiculoUseCase;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $data = $request->validate(
                [
                    'marca' => self::STRING_REQUIRED_MAX_255,
                    'modelo' => self::STRING_REQUIRED_MAX_255,
                    'ano' => 'required|integer|min:1900|max:' . date('Y'),
                    'cor' => self::STRING_REQUIRED_MAX_255,
                    'preco' => 'required|numeric|min:0',
                    'placa' => 'required|string|max:10',
                    'disponivel' => 'nullable|boolean',
                ]
            );

            $this->updateVeiculoUseCase->executar($id, $data);

            return response()->json(['message' => 'Veículo atualizado com sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(
                ['message' => match (true) {
                    $e instanceof NotFoundHttpException => $e->getMessage(),
                    $e instanceof BadRequestHttpException => $e->getMessage(),
                    default => 'Erro interno do servidor',
                }],
                match (true) {
                    $e instanceof NotFoundHttpException => 404,
                    $e instanceof BadRequestHttpException => 400,
                    default => 500,
                }
            );
        }
    }
}
