DOCKER_ARGS=--log-level ERROR
API_PHP_CLI=api-php-cli
FRONTEND_NODE_CLI=frontend-node-cli

init: docker-clear-down docker-build docker-up
up: docker-up
down: docker-down
restart: docker-down docker-up
build: docker-build frontend-build

docker-build:
	@docker-compose $(DOCKER_ARGS) build

docker-up:
	@docker-compose $(DOCKER_ARGS) up -d

docker-down:
	@docker-compose $(DOCKER_ARGS) down --remove-orphans

docker-clear-down:
	@docker-compose $(DOCKER_ARGS) down -v --remove-orphans

frontend-build:
	@docker-compose $(DOCKER_ARGS) exec $(FRONTEND_NODE_CLI) yarn run build
	@$(MAKE) -s chown

frontend-shell:
	@docker-compose $(DOCKER_ARGS) exec $(FRONTEND_NODE_CLI) /bin/bash
	@$(MAKE) -s chown

api-shell:
	@docker-compose $(DOCKER_ARGS) exec $(API_PHP_CLI) /bin/bash
	@$(MAKE) -s chown

chown:
	@docker-compose $(DOCKER_ARGS) exec $(API_PHP_CLI) chown -R 1000:1000 ./
	@docker-compose $(DOCKER_ARGS) exec $(FRONTEND_NODE_CLI) chown -R 1000:1000 ./