test:
	rm -rf tests/tmp/cache
	php vendor/bin/phpstan analyse ./src ./tests --level max
	php vendor/bin/phpcs --standard=PSR12 ./src ./tests
	php vendor/bin/tester ./tests
