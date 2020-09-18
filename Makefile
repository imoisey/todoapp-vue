include .env

DOCKER_ARGS=--log-level ERROR
API_PHP_CLI=api-php-cli
FRONTEND_NODE_CLI=frontend-node-cli

init: docker-clear-down docker-build docker-up
up: docker-up
down: docker-down
restart: docker-down docker-up
build: docker-build frontend-build

docker-build: docker-build-gateway \
 	docker-build-frontend \
 	docker-build-frontend-node-cli \
 	docker-build-api \
 	docker-build-api-php-fpm \
 	docker-build-api-php-cli

docker-build-gateway:
	@docker build -t ${REGISTRY}/todoapp-gateway:${IMAGE_TAG} \
		-f api/docker/${ENV}/nginx/Dockerfile api/docker

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