.PHONY: test phpstan phpcs phpmd phpcpd all

# Lance les tests avec Artisan
test:
	vendor/bin/php artisan test

# Lance PHPStan avec le niveau max
phpstan:
	vendor/bin/phpstan analyse app tests --level max

# Lance PHP CS Fixer avec autorisation des fixeurs risqués
phpcs:
	vendor/bin/php-cs-fixer fix --allow-risky=yes

# Lance PHP Mess Detector avec règles choisies
phpmd:
	vendor/bin/phpmd app,text codesize,unusedcode,naming

# Lance PHP Copy/Paste Detector
phpcpd:
	vendor/bin/phpcpd app tests

# Tout lancer en une seule commande
all: test phpstan phpcs phpmd phpcpd
