COMPOSE=docker-compose --env-file .env

.PHONY: up down restart build logs ps

up:
	$(COMPOSE) up -d --build

down:
	$(COMPOSE) down -v --remove-orphans

build:
	$(COMPOSE) build

restart:
	$(MAKE) down
	$(MAKE) up

logs:
	$(COMPOSE) logs -f --tail=100

ps:
	$(COMPOSE) ps

product-console:
	$(COMPOSE) exec product-service php bin/console

order-console:
	$(COMPOSE) exec order-service php bin/console

order-worker:
	$(COMPOSE) exec order-service php bin/console messenger:consume async -vv

product-worker:
	$(COMPOSE) exec product-service php bin/console messenger:consume async -vv

clear-cache:
	$(MAKE) product-console ARGS="cache:clear"
	$(MAKE) order-console ARGS="cache:clear"
