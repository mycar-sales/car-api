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

            return response()->json($veiculo);
        } catch (NotFoundHttpException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro interno do servidor'], 500);
        }
    }
}

