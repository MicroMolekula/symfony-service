up-build:
	docker compose up --build -d
up:
	docker compose up -d
down:
	docker compose down
up-prod:
	docker compose --file docker-compose.prod.yml down
	docker compose --file docker-compose.prod.yml up --build -d
	docker compose --file docker-compose.prod.yml exec php composer install