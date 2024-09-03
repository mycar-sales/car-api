<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\UseCases\CadastrarVeiculoUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Exception;

/**
 * Class CadastrarVeiculoController
 * @package App\Http\Controllers
 * @OA\Info(title="API de Veículos", version="1.0.0")
 * @OA\Server(url="http://localhost/api/v1", description="API para gerenciamento de veículos")
 */
class CadastrarVeiculoController extends Controller
{
    /**
     * @param CadastrarVeiculoUseCase $cadastrarVeiculoUseCase
     */
    public function __construct(
        private CadastrarVeiculoUseCase $cadastrarVeiculoUseCase
    ) {
    }
    /**
     * @OA\Post(
     *     path="/veiculos",
     *     summary="Cadastrar um novo veículo",
     *     tags={"Veículos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="marca", type="string", example="Toyota"),
     *             @OA\Property(property="modelo", type="string", example="Corolla"),
     *             @OA\Property(property="ano", type="integer", example=2022),
     *             @OA\Property(property="cor", type="string", example="Red"),
     *             @OA\Property(property="preco", type="number", format="float", example=10000.00),
     *             @OA\Property(property="placa", type="string", example="ABC-1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Veículo cadastrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Veículo cadastrado com sucesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
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
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = $request->validate(
                [
                'marca' => self::STRING_REQUIRED_MAX_255,
                'modelo' => self::STRING_REQUIRED_MAX_255,
                'ano' => 'required|integer|min:1900|max:' . date('Y'),
                'cor' => self::STRING_REQUIRED_MAX_255,
                'preco' => 'required|numeric|min:0',
                'placa' => 'required|string|max:8',
                ]
            );

            $this->cadastrarVeiculoUseCase->execute($data);

            return response()->json(['message' => 'Veículo cadastrado com sucesso'], 201);
        } catch (BadRequestHttpException | Exception $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                match (true) {
                $e instanceof BadRequestHttpException => 400,
                default => 500,
                }
            );
        }
    }
}
