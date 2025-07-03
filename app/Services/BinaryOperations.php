<?php

namespace App\Services;

/**
 * Service gérant les opérations binaires bit à bit et arithmétiques.
 */
class BinaryOperations
{
    /**
     * Effectue un ET logique bit à bit entre deux chaînes binaires.
     *
     * @param string $a Première chaîne binaire
     * @param string $b Deuxième chaîne binaire
     * @return string Résultat binaire de l'opération AND
     */
    public function andOperation(string $a, string $b): string
    {
        return $this->bitwise($a, $b, 'and');
    }

    /**
     * Effectue un OU logique bit à bit entre deux chaînes binaires.
     *
     * @param string $a Première chaîne binaire
     * @param string $b Deuxième chaîne binaire
     * @return string Résultat binaire de l'opération OR
     */
    public function orOperation(string $a, string $b): string
    {
        return $this->bitwise($a, $b, 'or');
    }

    /**
     * Effectue un OU exclusif (XOR) bit à bit entre deux chaînes binaires.
     *
     * @param string $a Première chaîne binaire
     * @param string $b Deuxième chaîne binaire
     * @return string Résultat binaire de l'opération XOR
     */
    public function xorOperation(string $a, string $b): string
    {
        return $this->bitwise($a, $b, 'xor');
    }

    /**
     * Effectue une multiplication arithmétique entre deux chaînes binaires.
     *
     * @param string $a Chaîne binaire représentant un entier
     * @param string $b Chaîne binaire représentant un entier
     * @return string Résultat binaire de la multiplication
     */
    public function multiplyOperation(string $a, string $b): string
    {
        $decA = bindec($a);
        $decB = bindec($b);
        return decbin($decA * $decB);
    }

    /**
     * Effectue une division arithmétique entière entre deux chaînes binaires.
     *
     * @param string $a Dividende binaire
     * @param string $b Diviseur binaire
     * @return string Résultat binaire de la division ou 'Erreur' si division par zéro
     */
    public function divideOperation(string $a, string $b): string
    {
        $decA = bindec($a);
        $decB = bindec($b);

        if ($decB === 0) {
            return 'Erreur';
        }

        return decbin(intdiv($decA, $decB));
    }

    /**
     * Calcule l'expression suivante : ((a + b) * c) / d sur des binaires.
     *
     * @param string $a Binaire représentant un entier
     * @param string $b Binaire représentant un entier
     * @param string $c Binaire représentant un entier
     * @param string $d Binaire représentant un entier (≠ 0)
     * @return string Résultat binaire de l'expression ou 'Erreur' si division par zéro
     */
    public function complexOperation(string $a, string $b, string $c, string $d): string
    {
        $decA = bindec($a);
        $decB = bindec($b);
        $decC = bindec($c);
        $decD = bindec($d);

        if ($decD === 0) {
            return 'Erreur';
        }

        $result = (($decA + $decB) * $decC) / $decD;

        return decbin((int) $result);
    }

    /**
     * Méthode privée utilisée pour effectuer les opérations logiques bit à bit.
     *
     * @param string $a Première chaîne binaire
     * @param string $b Deuxième chaîne binaire
     * @param string $operation Nom de l'opération ('and', 'or', 'xor')
     * @return string Résultat binaire après application de l'opération
     */
    private function bitwise(string $a, string $b, string $operation): string
    {
        $result = '';

        for ($i = 0; $i < strlen($a); $i++) {
            $bitA = $a[$i];
            $bitB = $b[$i];

            $result .= match ($operation) {
                'and' => ($bitA === '1' && $bitB === '1') ? '1' : '0',
                'or'  => ($bitA === '1' || $bitB === '1') ? '1' : '0',
                'xor' => ($bitA !== $bitB) ? '1' : '0',
            };
        }

        return $result;
    }
}
