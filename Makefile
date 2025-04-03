up-build-local:
	docker compose --file docker-compose.local.yml up --build -d
up-local:
	docker compose --file docker-compose.local.yml up -d
down-local:
	docker compose --file docker-compose.local.yml down -d