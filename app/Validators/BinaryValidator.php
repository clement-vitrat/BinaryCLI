<?php

namespace App\Validators;

/**
 * Validator pour les chaînes binaires.
 */
class BinaryValidator
{
    /**
     * Vérifie si une chaîne est une représentation binaire valide (seulement 0 et 1).
     *
     * @param string $binary Chaîne à valider
     * @return bool Vrai si la chaîne est binaire, faux sinon
     */
    public function isValidBinary(string $binary): bool
    {
        return preg_match('/^[01]+$/', $binary) === 1;
    }
}
