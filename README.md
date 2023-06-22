## About this app

This application was made as a test task for the **dZENcode** company. The description of the task can be found in the file "comments-app-technical-task.pdf"

## Technologies used

* PHP+Laravel 10
* Mysql
* Redis
* Vue3

## How to run a project locally on linux

1. In linux terminal input: `git clone https://github.com/rexthuby/comments-test.git`
2. `cp .env.example .env`
3. `sudo composer update`
4. `sudo npm install`
5. `php artisan key:generate`
6. `sudo chmod 777 -R ./`
7. `docker-compose build`
8. `docker-compose up -d`
9. `docker exec -it phone_backend bash`
10. now in container terminal run `php artisan migrate --seed`
11. `exit`
12. `docker-compose restart`
13. in linux terminal `sudo chmod 777 -R ./`
