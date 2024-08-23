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
 */
class CadastrarVeiculoController extends Controller
{
    /**
     * @var CadastrarVeiculoUseCase
     */
    private CadastrarVeiculoUseCase $cadastrarVeiculoUseCase;

    /**
     * @param CadastrarVeiculoUseCase $cadastrarVeiculoUseCase
     */
    public function __construct(CadastrarVeiculoUseCase $cadastrarVeiculoUseCase)
    {
        $this->cadastrarVeiculoUseCase = $cadastrarVeiculoUseCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'marca' => 'required|string|max:255',
                'modelo' => 'required|string|max:255',
                'ano' => 'required|integer|min:1900|max:' . date('Y'),
                'cor' => 'required|string|max:255',
                'preco' => 'required|numeric|min:0',
            ]);

            $this->cadastrarVeiculoUseCase->execute($data);

            return response()->json(['message' => 'Veículo cadastrado com sucesso'], 201);
        } catch (BadRequestHttpException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno do servidor'], 500);
        }
    }
}
