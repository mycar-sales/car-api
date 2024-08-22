<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\UseCases;

use App\Core\Domain\Repositories\VeiculoRepositoryInterface;
use App\Core\Domain\UseCases\CadastrarVeiculoUseCase;
use InvalidArgumentException;
use Tests\TestCase;
use Mockery;

/**
 * Class CadastrarVeiculoUseCaseTest
 * @package Tests\Unit\Core\Domain\UseCases
 */
final class CadastrarVeiculoUseCaseTest extends TestCase
{
    /**
     * @var VeiculoRepositoryInterface|VeiculoRepositoryInterface&Mockery\MockInterface&Mockery\LegacyMockInterface|Mockery\MockInterface&Mockery\LegacyMockInterface
     */
    private VeiculoRepositoryInterface $veiculoRepository;
    /**
     * @var CadastrarVeiculoUseCase
     */
    private CadastrarVeiculoUseCase $cadastrarVeiculoUseCase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->veiculoRepository = Mockery::mock(VeiculoRepositoryInterface::class);
        $this->cadastrarVeiculoUseCase = new CadastrarVeiculoUseCase($this->veiculoRepository);
    }

    /**
     * @return void
     */
    public function testVeiculoCanBeRegistered(): void
    {
        $data = [
            'marca' => 'Toyota',
            'modelo' => 'Corolla',
            'ano' => 2022,
            'cor' => 'Red',
            'preco' => 10000.00
        ];

        $this->veiculoRepository->shouldReceive('save')->once();

        $this->cadastrarVeiculoUseCase->execute($data);

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testVeiculoCannotBeRegisteredWithInvalidData(): void
    {
        $data = [
            'marca' => '',
            'modelo' => '',
            'ano' => 0,
            'cor' => '',
            'preco' => 0
        ];

        $this->expectException(InvalidArgumentException::class);

        $this->cadastrarVeiculoUseCase->execute($data);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
