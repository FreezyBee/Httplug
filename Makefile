test:
	php vendor/bin/phpstan analyse ./src ./tests --level 5
	php vendor/bin/phpcs --standard=PSR2 ./src ./tests
	php vendor/bin/tester ./tests
