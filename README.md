### Installation

```sh
$ git clone https://github.com/tony3supriadi/laravel-docker.git
$ cd laravel-docker
```

### For Docker

```sh
$ nano docker-compose.yml
```
Change this code with your configuration.

```sh
$ # MYSQL Service
$ db:
....
$ MYSQL_DATABASE: "<your-db-name>"
$ MYSQL_ROOT_PASSWORD: "<your-db-password>"
....

$ # Phpmyadmin service
$ phpmyadmin:
....
$ environment:
$   - PMA_HOST=db
$   - MYSQL_ROOT_PASSWORD=<your-db-password>
....
```

### For Laravel
```sh
$ composer install
$ cp .env-example .env
$ php artisan key:generate
```

```sh
$ nano .env
```
Change this code with your configuration
```sh
$ DB_HOST=127.0.0.1    # Change with your ip address
$ DB_PORT=3306         # Change with dbport in docker-configuration
$ DB_DATABASE=laravel  # Change with dbname in docker-configuration
$ DB_USERNAME=root     # Change with dbuser in docker-configuration
$ DB_PASSWORD=         # Change with dbpass in docker-configuration
```
