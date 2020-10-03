include .env

DOCKER_ARGS=--log-level ERROR
API_PHP_CLI=api-php-cli
FRONTEND_NODE_CLI=frontend-node-cli

init: docker-clear-down docker-build docker-up frontend-init api-init
up: docker-up
down: docker-down
restart: docker-down docker-up
build: docker-build
lint: api-lint
analyze: api-analyze
test: api-test

docker-build: docker-build-gateway \
 	docker-build-frontend \
 	docker-build-frontend-node-cli \
 	docker-build-api \
 	docker-build-api-php-fpm \
 	docker-build-api-php-cli

docker-build-gateway:
	@docker build -t ${REGISTRY}/todoapp-gateway:${IMAGE_TAG} \
		-f gateway/docker/${ENV}/nginx/Dockerfile gateway/docker

docker-build-frontend:
	@docker build -t ${REGISTRY}/todoapp-frontend:${IMAGE_TAG} \
		-f frontend/docker/${ENV}/nginx/Dockerfile frontend/docker

docker-build-frontend-node-cli:
	@docker build -t ${REGISTRY}/todoapp-frontend-node-cli:${IMAGE_TAG} \
		-f frontend/docker/${ENV}/node/Dockerfile frontend/docker

docker-build-api:
	@docker build -t ${REGISTRY}/todoapp-api:${IMAGE_TAG} \
		-f api/docker/${ENV}/nginx/Dockerfile api/docker

docker-build-api-php-fpm:
	@docker build -t ${REGISTRY}/todoapp-api-php-fpm:${IMAGE_TAG} \
		-f api/docker/${ENV}/php-fpm/Dockerfile api/docker

docker-build-api-php-cli:
	@docker build -t ${REGISTRY}/todoapp-api-php-cli:${IMAGE_TAG} \
		-f api/docker/${ENV}/php-cli/Dockerfile api/docker

docker-up:
	@docker-compose $(DOCKER_ARGS) up -d

docker-down:
	@docker-compose $(DOCKER_ARGS) down --remove-orphans

docker-clear-down:
	@docker-compose $(DOCKER_ARGS) down -v --remove-orphans

frontend-init: frontend-yarn-install frontend-yarn-build

frontend-yarn-install:
	@docker-compose $(DOCKER_ARGS) run --rm $(FRONTEND_NODE_CLI) yarn install
	@$(MAKE) -s frontend-chown

frontend-yarn-build:
	@docker-compose $(DOCKER_ARGS) run --rm $(FRONTEND_NODE_CLI) yarn run build
	@$(MAKE) -s frontend-chown

frontend-shell:
	@docker-compose $(DOCKER_ARGS) run --rm $(FRONTEND_NODE_CLI) /bin/bash
	@$(MAKE) -s frontend-chown

frontend-chown:
	@docker-compose $(DOCKER_ARGS) run --rm $(FRONTEND_NODE_CLI) chown -R 1000:1000 ./

api-init: api-composer-install

api-composer-install:
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) composer install
	@$(MAKE) -s api-chown

api-lint:
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) composer lint
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) composer cs-check
	@$(MAKE) -s api-chown

api-analyze:
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) composer psalm

api-test:
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) composer phpunit

api-shell:
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) /bin/bash
	@$(MAKE) -s api-chown

api-chown:
	@docker-compose $(DOCKER_ARGS) run --rm $(API_PHP_CLI) chown -R 1000:1000 ./
