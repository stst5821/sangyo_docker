up:
		docker-compose up -d
stop:
		docker-compose stop
app:
		docker exec -ti sangyo-app bash
db:
		docker exec -ti sangyo-db bash -c 'psql -h 127.0.0.1 -p 5432 -U docker -d laravel_development'