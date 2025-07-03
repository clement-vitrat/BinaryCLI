<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BinaryOperations;
use App\Validators\BinaryValidator;

/**
 * Commande CLI pour calculatrice binaire.
 * Permet d'effectuer des opérations binaires (AND, OR, XOR) sur deux chaînes binaires de même longueur.
 */
class BinaryCalculator extends Command
{
    /**
     * Signature de la commande artisan (nom à utiliser dans le terminal).
     * Exemple : php artisan binary:calc
     * 
     * @var string
     */
    protected $signature = 'binary:calc';

    /**
     * Description courte de la commande, affichée dans la liste des commandes artisan.
     * 
     * @var string
     */
    protected $description = 'Calculatrice binaire en ligne de commande';

    /**
     * Instance du service gérant les opérations binaires.
     * 
     * @var BinaryOperations
     */
    private BinaryOperations $operations;

    /**
     * Instance du validateur pour vérifier que les chaînes sont bien binaires.
     * 
     * @var BinaryValidator
     */
    private BinaryValidator $validator;

    /**
     * Constructeur de la commande.
     * Injection des dépendances (service d'opérations et validateur).
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
     * Affiche une interface interactive en CLI pour saisir des opérations.
     * 
     * @return int
     */
    public function handle()
    {
        // Affiche un bandeau de bienvenue avec un style coloré en cyan gras
        $this->info('<options=bold;fg=cyan>--------------------------------------------------------</>');
        $this->info('<options=bold;fg=cyan>                 CALCULATRICE BINAIRE CLI               </>');
        $this->info('<options=bold;fg=cyan>--------------------------------------------------------</>');
        $this->newLine();

        // Instructions pour l'utilisateur
        $this->line('Bienvenue dans la calculatrice binaire CLI !');
        $this->line('Vous pouvez effectuer des opérations binaires simples :');
        $this->line('  - and : ET logique');
        $this->line('  - or  : OU logique');
        $this->line('  - xor : OU exclusif logique');
        $this->line('Entrez deux nombres binaires de même longueur.');
        $this->newLine();
        $this->line('Utilisez les commandes suivantes pour interagir :');
        $this->line('Commandes : and, or, xor, help, exit');

        // Boucle infinie pour garder l'interface interactive jusqu'à exit
        while (true) {
            // Demande une saisie utilisateur
            $input = trim($this->ask('>>'));

            // Gestion de la commande exit pour quitter la boucle et fermer la commande
            if ($input === 'exit') {
                $this->info('Fermeture...');
                break;
            }

            // Commande help pour afficher l'aide
            if ($input === 'help') {
                $this->showHelp();
                continue;
            }

            // Découpe la saisie en trois parties : opération, binaire1, binaire2
            $parts = preg_split('/\s+/', $input);

            // Vérifie que l'utilisateur a bien entré trois arguments
            if (count($parts) !== 3) {
                $this->error('Utilisation : <operation> <binaire1> <binaire2>');
                continue;
            }

            // Affectation des parties à des variables nommées
            [$op, $a, $b] = $parts;

            // Validation que les deux chaînes sont bien binaires (0 et 1 uniquement)
            if (!$this->validator->isValidBinary($a) || !$this->validator->isValidBinary($b)) {
                $this->error('Entrées invalides : uniquement des 0 et 1');
                continue;
            }

            // Vérification que les deux chaînes ont la même longueur
            if (strlen($a) !== strlen($b)) {
                $this->error('Les deux binaires doivent avoir la même longueur');
                continue;
            }

            // Sélection de l'opération à réaliser selon la commande entrée (and, or, xor)
            $result = match (strtolower($op)) {
                'and' => $this->operations->andOperation($a, $b),
                'or'  => $this->operations->orOperation($a, $b),
                'xor' => $this->operations->xorOperation($a, $b),
                // Si l'opération est inconnue, renvoie null
                default => null,
            };

            // Affiche un message d'erreur si commande inconnue, sinon le résultat
            if ($result === null) {
                $this->error("Commande inconnue : $op");
            } else {
                $this->info("Résultat : $result");
            }
        }

        // Fin de la commande avec succès
        return 0;
    }

    /**
     * Affiche le message d'aide avec la liste des commandes disponibles.
     * 
     * @return void
     */
    private function showHelp()
    {
        $this->line(<<<'HELP'

            Commandes :
            and <bin1> <bin2>   : Exécute un ET logique
            or <bin1> <bin2>    : Exécute un OU logique
            xor <bin1> <bin2>   : Exécute un XOR logique
            help                : Affiche ce message
            exit                : Quitte le programme

        HELP);
    }
}
