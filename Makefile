DOCKER_COMPOSE_DIR=./
DOCKER_COMPOSE_FILE=./docker-compose.yaml
DOCKER_COMPOSE=docker-compose -f $(DOCKER_COMPOSE_FILE) --project-directory $(DOCKER_COMPOSE_DIR)
DOCKER_CONTAINER=lm-backend
DOCKER_EXEC=docker exec $(DOCKER_CONTAINER)

.PHONY: build
build:
ifeq ("$(wildcard $(DOCKER_COMPOSE_DIR)/.env)", "")
	cp $(DOCKER_COMPOSE_DIR)/.env.example $(DOCKER_COMPOSE_DIR)/.env \
	&& sed -i 's/USER_NAME=.*/USER_NAME='$(shell id -un)'/' $(DOCKER_COMPOSE_DIR)/.env \
	&& sed -i 's/USER_UID=.*/USER_UID='$(shell id -u)'/' $(DOCKER_COMPOSE_DIR)/.env \
	&& sed -i 's/USER_GROUP=.*/USER_GROUP='$(shell id -g -n)'/' $(DOCKER_COMPOSE_DIR)/.env \
	&& sed -i 's/USER_GROUPID=.*/USER_GROUPID='$(shell id -g)'/' $(DOCKER_COMPOSE_DIR)/.env
endif

	$(DOCKER_COMPOSE) build

.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) stop

.PHONY: open
open:
	docker exec -it $(DOCKER_CONTAINER) sh

.PHONY: run-tests
run-tests:
	$(DOCKER_EXEC) php artisan test
