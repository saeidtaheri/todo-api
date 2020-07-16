# TODO API
Simple API To Play with Tasks!<br>

## Dockerized Environment:
- NGINX
- PHP-FPM
- MySQL

## Easy Installation (Only First Time)
Run below commands into your terminal:
```
git clone git@github.com:saeidtaheri/todo-api.git todo-api
cd todo-api
cp .env.example .env
docker-compose build
docker-compose up -d
```
NOTICE: Wait enough for docker to create database. Make sure it is up and running and then run:
```
make setup
```

## Makefile
You can see available make commands by typing `make` in the terminal.
