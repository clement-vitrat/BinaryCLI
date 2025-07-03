#!/bin/bash

echo "Lancement des tests PHPUnit..."
vendor/bin/php artisan test

echo "Analyse PHPStan..."
vendor/bin/phpstan analyse app tests --level max

echo "Formatage avec PHP CS Fixer..."
vendor/bin/php-cs-fixer fix --allow-risky=yes

echo "Analyse PHPMD..."
vendor/bin/phpmd app,text codesize,unusedcode,naming

echo "Analyse des duplications avec PHPCPD..."
vendor/bin/phpcpd app tests

echo "Fin des analyses."
