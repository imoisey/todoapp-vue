DOCKER_ARGS=--log-level ERROR
API_PHP_CLI=api-php-cli

init: docker-clear-down docker-build docker-up
up: docker-up
down: docker-down
restart: docker-down docker-up

docker-build:
	@docker-compose $(DOCKER_ARGS) build

docker-up:
	@docker-compose $(DOCKER_ARGS) up -d

docker-down:
	@docker-compose $(DOCKER_ARGS) down --remove-orphans

docker-clear-down:
	@docker-compose $(DOCKER_ARGS) down -v --remove-orphans

api-shell:
	@docker-compose $(DOCKER_ARGS) exec $(API_PHP_CLI) /bin/bash
	@$(MAKE) -s chown

chown:
	@docker-compose $(DOCKER_ARGS) exec $(API_PHP_CLI) chown -R 1000:1000 ./