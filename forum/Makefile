#Makefile

up:
	cd laradock && docker-compose up -d nginx mysql phpmyadmin

down:
	cd laradock && docker-compose down

bash: up
	cd laradock && docker-compose exec workspace bash
