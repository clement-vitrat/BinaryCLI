<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\BinaryOperations;

/**
 * Test unitaire de la classe BinaryOperations.
 * Vérifie le bon fonctionnement des opérations logiques bit à bit.
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
    public function test_and_operation()
    {
        $this->assertEquals('1010', $this->service->andOperation('1111', '1010'));
    }

    /** @test Vérifie l'opération OR binaire */
    public function test_or_operation()
    {
        $this->assertEquals('1111', $this->service->orOperation('1101', '1011'));
    }

    /** @test Vérifie l'opération XOR binaire */
    public function test_xor_operation()
    {
        $this->assertEquals('0101', $this->service->xorOperation('1111', '1010'));
    }
}
