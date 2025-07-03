#!/bin/bash

check_bin() {
    if [ ! -f "$1" ]; then
        echo "Outil manquant : $1"
        return 1
    fi
    return 0
}

echo "Lancement des tests PHPUnit..."
php artisan test
if [ $? -ne 0 ]; then
    echo "Les tests PHPUnit ont échoué."
    exit 1
fi

echo "Analyse PHPStan..."
check_bin vendor/bin/phpstan && vendor/bin/phpstan analyse app tests --level max
if [ $? -ne 0 ]; then
    echo "L'analyse PHPStan a échoué."
    exit 1
fi 

echo "Formatage avec PHP CS Fixer..."
check_bin vendor/bin/php-cs-fixer && vendor/bin/php-cs-fixer fix --allow-risky=yes
if [ $? -ne 0 ]; then
    echo "Le formatage avec PHP CS Fixer a échoué."
    exit 1
fi

echo "Analyse PHPMD..."
check_bin vendor/bin/phpmd && vendor/bin/phpmd app,text codesize,unusedcode,naming
if [ $? -ne 0 ]; then
    echo "L'analyse PHPMD a échoué."
    exit 1
fi

echo "Analyse des duplications avec PHPCPD..."
check_bin vendor/bin/phpcpd && vendor/bin/phpcpd app tests
if [ $? -ne 0 ]; then
    echo "L'analyse des duplications avec PHPCPD a échoué."
    exit 1
fi

echo "Fin des analyses."
