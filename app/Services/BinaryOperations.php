<?php

namespace App\Services;

/**
 * Service gérant les opérations binaires bit à bit.
 */
class BinaryOperations
{
    /**
     * Effectue un ET logique bit à bit entre deux chaînes binaires.
     *
     * @param string $a Première chaîne binaire
     * @param string $b Deuxième chaîne binaire
     * @return string Résultat binaire
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
     * @return string Résultat binaire
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
     * @return string Résultat binaire
     */
    public function xorOperation(string $a, string $b): string
    {
        return $this->bitwise($a, $b, 'xor');
    }

    /**
     * Méthode interne qui réalise l'opération binaire bit à bit.
     *
     * @param string $a Première chaîne binaire
     * @param string $b Deuxième chaîne binaire
     * @param string $operation 'and', 'or' ou 'xor'
     * @return string Résultat binaire
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
