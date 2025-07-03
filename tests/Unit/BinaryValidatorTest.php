<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Validators\BinaryValidator;

/**
 * Test unitaire de la classe BinaryValidator.
 * Vérifie la validation des chaînes binaires.
 */
class BinaryValidatorTest extends TestCase
{
    private BinaryValidator $validator;

    /**
     * Initialise l’instance de BinaryValidator avant chaque test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new BinaryValidator();
    }

    /** @test Vérifie qu'une chaîne binaire valide est reconnue comme telle */
    public function test_valid_binary(): void
    {
        $this->assertTrue($this->validator->isValidBinary('10101'));
        $this->assertTrue($this->validator->isValidBinary('000'));
    }

    /** @test Vérifie qu'une chaîne non binaire est rejetée */
    public function test_invalid_binary(): void
    {
        $this->assertFalse($this->validator->isValidBinary('10201'));
        $this->assertFalse($this->validator->isValidBinary('abc'));
        $this->assertFalse($this->validator->isValidBinary(''));
    }
}
