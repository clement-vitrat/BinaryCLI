<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\BinaryOperations;

/**
 * Test unitaire de la classe BinaryOperations.
 * Vérifie le bon fonctionnement des opérations logiques et arithmétiques binaires.
 */
class BinaryOperationsTest extends TestCase
{
    private BinaryOperations $service;

    /**
     * Initialise l’instance de BinaryOperations avant chaque test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BinaryOperations();
    }

    /** @test Vérifie l'opération AND binaire */
    public function test_and_operation(): void
    {
        $this->assertEquals('1010', $this->service->andOperation('1111', '1010'));
    }

    /** @test Vérifie l'opération OR binaire */
    public function test_or_operation(): void
    {
        $this->assertEquals('1111', $this->service->orOperation('1101', '1011'));
    }

    /** @test Vérifie l'opération XOR binaire */
    public function test_xor_operation(): void
    {
        $this->assertEquals('0101', $this->service->xorOperation('1111', '1010'));
    }

    /** @test Vérifie l'opération de multiplication binaire */
    public function test_multiply_operation(): void
    {
        // 3 (011) * 5 (101) = 15 (1111)
        $this->assertEquals('1111', $this->service->multiplyOperation('011', '101'));
    }

    /** @test Vérifie l'opération de division binaire */
    public function test_divide_operation(): void
    {
        // 12 (1100) / 3 (0011) = 4 (100)
        $this->assertEquals('100', $this->service->divideOperation('1100', '0011'));
    }

    /** @test Vérifie que la division par zéro retourne "Erreur" */
    public function test_division_by_zero_returns_error(): void
    {
        $this->assertEquals('Erreur', $this->service->divideOperation('1010', '0000'));
    }

    /** @test Vérifie l'opération complexe ((a + b) * c) / d */
    public function test_complex_operation(): void
    {
        // a = 2 (10), b = 1 (01), c = 4 (100), d = 2 (10)
        // ((2 + 1) * 4) / 2 = (3 * 4) / 2 = 12 / 2 = 6 => 110
        $this->assertEquals('110', $this->service->complexOperation('10', '01', '100', '10'));
    }

    /** @test Vérifie que l'opération complexe échoue si division par zéro */
    public function test_complex_operation_divide_by_zero(): void
    {
        $this->assertEquals('Erreur', $this->service->complexOperation('10', '01', '100', '0000'));
    }
}
