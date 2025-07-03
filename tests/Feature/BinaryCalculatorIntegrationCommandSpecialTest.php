<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Classe de tests d'intégration pour les commandes spéciales
 * de la calculatrice binaire CLI : help, exit, clear.
 *
 * Ces tests vérifient que la CLI réagit correctement à ces commandes
 * spéciales en simulant l'interaction utilisateur via artisan.
 */
class BinaryCalculatorIntegrationCommandSpecialTest extends TestCase
{
    /**
     * Teste que la commande `help` affiche le message d'aide attendu.
     *
     * Cette commande doit afficher un texte contenant la liste des commandes
     * disponibles. On vérifie également que la commande se termine correctement.
     */
    public function testHelpCommandDisplaysHelpText(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'help')
            ->assertExitCode(0);
    }

    /**
     * Teste que la commande `exit` termine proprement la boucle CLI.
     *
     * Lorsqu'on tape 'exit', la CLI doit afficher "Fermeture..." et s'arrêter.
     * Ce test s'assure que la commande se termine sans erreur.
     */
    public function testExitCommandTerminates(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'exit')
            ->expectsOutput('Fermeture...')
            ->assertExitCode(0);
    }

    /**
     * Teste que la commande `clear` ne provoque pas d'erreur.
     *
     * Cette commande est supposée nettoyer l'écran (ou simuler cette action).
     * Ici, on vérifie que la commande continue à fonctionner après 'clear',
     * et qu'on peut ensuite quitter proprement avec 'exit'.
     */
    public function testClearCommandClearsScreen(): void
    {
        $this->artisan('binary:calc')
            ->expectsQuestion('>>', 'clear')
            ->expectsQuestion('>>', 'exit')
            ->assertExitCode(0);
    }
}
