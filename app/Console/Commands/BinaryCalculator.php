<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BinaryOperations;
use App\Validators\BinaryValidator;

/**
 * Commande CLI pour une calculatrice binaire.
 * Permet d'effectuer des opérations binaires classiques et avancées :
 * - ET, OU, XOR bit à bit
 * - Multiplication et division entière
 * - Expression ((a + b) * c) / d
 */
class BinaryCalculator extends Command
{
    /**
     * Signature de la commande artisan à utiliser dans le terminal.
     * Exemple d'appel : php artisan binary:calc
     *
     * @var string
     */
    protected $signature = 'binary:calc';

    /**
     * Courte description de la commande, affichée dans "php artisan list".
     *
     * @var string
     */
    protected $description = 'Calculatrice binaire en ligne de commande';

    /**
     * Service pour effectuer les opérations binaires.
     *
     * @var BinaryOperations
     */
    private BinaryOperations $operations;

    /**
     * Validateur de chaînes binaires (pour s'assurer que les entrées ne contiennent que des 0 et 1).
     *
     * @var BinaryValidator
     */
    private BinaryValidator $validator;

    /**
     * Constructeur de la commande.
     * Injection des dépendances BinaryOperations et BinaryValidator.
     *
     * @param BinaryOperations $operations
     * @param BinaryValidator $validator
     */
    public function __construct(BinaryOperations $operations, BinaryValidator $validator)
    {
        parent::__construct();
        $this->operations = $operations;
        $this->validator = $validator;
    }

    /**
     * Point d'entrée principal de la commande.
     * Gère l'interface interactive en CLI pour effectuer les calculs binaires.
     *
     * @return int
     */
    public function handle()
    {
        // Affiche un en-tête coloré pour l'interface CLI
        $this->info('<options=bold;fg=cyan>--------------------------------------------------------</>');
        $this->info('<options=bold;fg=cyan>                 CALCULATRICE BINAIRE CLI               </>');
        $this->info('<options=bold;fg=cyan>--------------------------------------------------------</>');
        $this->newLine();

        // Présentation et instructions
        $this->line('Bienvenue dans la calculatrice binaire CLI !');
        $this->line('Vous pouvez effectuer les opérations suivantes :');
        $this->line('  - and  : ET logique');
        $this->line('  - or   : OU logique');
        $this->line('  - xor  : OU exclusif logique');
        $this->line('  - mul  : Multiplication binaire');
        $this->line('  - div  : Division entière binaire');
        $this->line('  - calc : ((a + b) * c) / d');
        $this->newLine();
        $this->line('Commandes : and, or, xor, mul, div, calc, help, exit');

        // Boucle principale interactive
        while (true) {
            // Demande de commande utilisateur
            $input = trim($this->ask('>>'));

            // Quitter l'application
            if ($input === 'exit') {
                $this->info('Fermeture...');
                break;
            }

            // Affichage de l'aide
            if ($input === 'help') {
                $this->showHelp();
                continue;
            }

            // Découpage de la commande en parties
            $parts = preg_split('/\s+/', $input);
            $op = strtolower($parts[0]);

            /**
             * Cas 1 : opérations binaires simples à 2 opérandes (and, or, xor, mul, div)
             */
            if (in_array($op, ['and', 'or', 'xor', 'mul', 'div'], true) && count($parts) === 3) {
                [$op, $a, $b] = $parts;

                // Validation des binaires
                if (!$this->validator->isValidBinary($a) || !$this->validator->isValidBinary($b)) {
                    $this->error('Entrées invalides : uniquement des 0 et 1');
                    continue;
                }

                // Longueur égale pour les opérations bit à bit
                if (in_array($op, ['and', 'or', 'xor'], true) && strlen($a) !== strlen($b)) {
                    $this->error('Les deux binaires doivent avoir la même longueur');
                    continue;
                }

                // Sélection et exécution de l’opération
                $result = match ($op) {
                    'and' => $this->operations->andOperation($a, $b),
                    'or'  => $this->operations->orOperation($a, $b),
                    'xor' => $this->operations->xorOperation($a, $b),
                    'mul' => $this->operations->multiplyOperation($a, $b),
                    'div' => $this->operations->divideOperation($a, $b),
                    default => null,
                };

                // Résultat ou gestion d'erreur
                if ($result === 'Erreur') {
                    $this->error('Erreur : division par zéro');
                } elseif ($result === null) {
                    $this->error("Commande inconnue : $op");
                } else {
                    $this->info("Résultat : $result");
                }

                continue;
            }

            /**
             * Cas 2 : opération complexe ((a + b) * c) / d
             */
            if ($op === 'calc' && count($parts) === 5) {
                [, $a, $b, $c, $d] = $parts;

                // Validation des 4 entrées
                if (
                    !$this->validator->isValidBinary($a) ||
                    !$this->validator->isValidBinary($b) ||
                    !$this->validator->isValidBinary($c) ||
                    !$this->validator->isValidBinary($d)
                ) {
                    $this->error('Entrées invalides : uniquement des 0 et 1');
                    continue;
                }

                // Calcul du résultat via le service
                $result = $this->operations->complexOperation($a, $b, $c, $d);

                if ($result === 'Erreur') {
                    $this->error('Erreur : division par zéro dans le calcul');
                } else {
                    $this->info("Résultat : $result");
                }

                continue;
            }

            // Commande non reconnue
            $this->error('Utilisation : <operation> <binaire1> <binaire2> [<binaire3> <binaire4>]');
        }

        // Fin de commande
        return 0;
    }

    /**
     * Affiche le message d’aide (liste des commandes).
     *
     * @return void
     */
    private function showHelp()
    {
        $this->line(<<<'HELP'
            Commandes disponibles :

            and  <bin1> <bin2>        : ET logique bit à bit
            or   <bin1> <bin2>        : OU logique bit à bit
            xor  <bin1> <bin2>        : XOR bit à bit
            mul  <bin1> <bin2>        : Multiplication binaire
            div  <bin1> <bin2>        : Division entière binaire
            calc <a> <b> <c> <d>      : Calcul complexe ((a + b) * c) / d
            help                     : Affiche ce message d'aide
            exit                     : Quitte la calculatrice

        HELP);
    }
}
