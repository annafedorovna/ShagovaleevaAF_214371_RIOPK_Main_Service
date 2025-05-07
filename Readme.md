# Course work insurance
---

## Remember

The configuration of the database **must be the same on both sides** .


`Laravel`, `docker`, `php`, `mysql`, `unit tests`, `jwt`

### Install Libraries from Composer

```sh
docker-compose run --rm pt_composer install
```


### Clear/Clean the project

```sh
docker-compose run --rm pt_artisan clear:data
docker-compose run --rm pt_artisan cache:clear
docker-compose run --rm pt_artisan view:clear
docker-compose run --rm pt_artisan route:clear
docker-compose run --rm pt_artisan clear-compiled
docker-compose run --rm pt_artisan config:cache
```

### Generate Keys

```sh
docker-compose run --rm pt_artisan key:generate
```

### Create storage link
```
docker-compose run --rm pt_artisan storage:link
```

### Run migrations && seeders

```sh
docker-compose run --rm pt_artisan migrate
docker-compose run --rm pt_artisan db:seed
```


### Testing
```sh
docker-compose run --rm pt_php vendor/bin/phpunit

docker-compose run --rm jwt_artisan test 
```