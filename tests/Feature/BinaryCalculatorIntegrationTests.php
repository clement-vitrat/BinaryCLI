<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Test d'intégration de la commande CLI BinaryCalculator.
 * Vérifie le bon fonctionnement des opérations logiques binaires via l'interface CLI.
 * Teste les différentes commandes (and, or, xor), la validation des entrées,
 * la gestion des erreurs, et les commandes help et exit.
 */
class BinaryCalculatorIntegrationTests extends TestCase
{
    /**
     * Test la commande avec une opération AND valide.
     *
     * Simule la saisie de la commande 'and 1100 1010' puis 'exit'.
     * Vérifie que le résultat affiché est bien '1000' et que la commande se termine sans erreur.
     */
    public function test_command_execution_with_and_operation(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'and 1100 1010')
            ->expectsOutput('Résultat : 1000')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /**
     * Test la commande avec une opération OR valide.
     *
     * Simule la saisie de la commande 'or 1100 1010' puis 'exit'.
     * Vérifie que le résultat affiché est bien '1110' et que la commande se termine sans erreur.
     */
    public function test_command_execution_with_or_operation(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'or 1100 1010')
            ->expectsOutput('Résultat : 1110')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /**
     * Test la commande avec une opération XOR valide.
     *
     * Simule la saisie de la commande 'xor 1100 1010' puis 'exit'.
     * Vérifie que le résultat affiché est bien '0110' et que la commande se termine sans erreur.
     */
    public function test_command_execution_with_xor_operation(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'xor 1100 1010')
            ->expectsOutput('Résultat : 0110')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /**
     * Test la commande avec une entrée binaire invalide.
     *
     * Simule la saisie d'une chaîne binaire invalide contenant un caractère autre que 0 ou 1.
     * Vérifie que l'erreur appropriée est affichée et que la commande se termine sans erreur.
     */
    public function test_command_with_invalid_binary(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'and 11002 1010')
            ->expectsOutput('Entrées invalides : uniquement des 0 et 1')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /**
     * Test la commande avec deux chaînes binaires de longueurs différentes.
     *
     * Simule la saisie de deux chaînes binaires de longueurs différentes.
     * Vérifie que le message d'erreur sur la longueur est affiché.
     */
    public function test_command_with_mismatched_length(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'or 110 1010')
            ->expectsOutput('Les deux binaires doivent avoir la même longueur')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /**
     * Test la commande avec une commande inconnue.
     *
     * Simule la saisie d'une commande non reconnue ('add').
     * Vérifie que le message d'erreur correspondant est affiché.
     */
    public function test_command_with_unknown_command(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'add 1100 1010')
            ->expectsOutput('Commande inconnue : add')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }

    /**
     * Test la commande d'aide (help).
     *
     * Simule la saisie de la commande 'help'.
     * Vérifie que le message d'aide est affiché avec les commandes disponibles.
     */
    public function test_command_help(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'help')
            ->expectsOutputToContain('Commandes :')
            ->expectsOutputToContain('and <bin1> <bin2>')
            ->expectsOutputToContain('exit')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }
}
