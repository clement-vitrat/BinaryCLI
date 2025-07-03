<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Test d'intégration de la commande CLI BinaryCalculator.
 * Simule des entrées utilisateur et vérifie les sorties dans le terminal.
 */
class BinaryCalculatorCommandTest extends TestCase
{
    /** @test Vérifie une opération AND complète via l’interface CLI */
    public function test_command_execution_with_and_operation()
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'and 1101 1011')
            ->expectsOutput('Résultat : 1001')
            ->expectsQuestion('>>', 'exit')
            ->expectsOutput('Fermeture...')
            ->assertExitCode(0);
    }

    /** @test Vérifie la détection d’une entrée invalide non binaire */
    public function test_command_with_invalid_binary()
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'and 1101 10a1')
            ->expectsOutput('Entrées invalides : uniquement des 0 et 1')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /** @test Vérifie la détection de chaînes binaires de longueurs différentes */
    public function test_command_with_mismatched_length()
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'xor 101 1111')
            ->expectsOutput('Les deux binaires doivent avoir la même longueur')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }
}
