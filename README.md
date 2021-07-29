[![N|Solid](https://s3.eu-west-2.amazonaws.com/parent-documents/assets/parent_logo.png)](http://parent.eu)

# Assessment Solution

## Features

- Using Abstarct Factory Pattern.
- Using Repository Pattern.
- Unit tests coverage.
- Handle all Acceptance Criteria.
- easy to install in a Docker container.

## Installation

```sh
composer install
php artisan k:g
php artisan config:cache
php artisan serve
```

## Docker

Task is very easy to install and deploy in a Docker container.

By default, the Docker will expose port 8080, so change this within the
Dockerfile if necessary. When ready, simply use the Dockerfile to
build the image.

```sh
docker-compose up
```

Verify the server running by navigating to your server address in
your preferred browser.

```sh
localhost:8080
```

## Run API
You Can look at Endpoint using Postman here
[![N|Solid](https://miro.medium.com/max/1838/1*ap0NRizcKwuX5gfzKqEk6Q.png)](https://documenter.getpostman.com/view/12898163/TzJrBJde)

```sh
http://localhost:8080/api/v1/users
http://localhost:8080/api/v1/users?provider=DataProviderX
http://localhost:8080/api/v1/users?statusCode=refunded
http://localhost:8080/api/v1/users?balanceMin=120
http://localhost:8080/api/v1/users?balanceMax=320
http://localhost:8080/api/v1/users?balanceMin=120&balanceMax=320
http://localhost:8080/api/v1/users?currency=AED
http://localhost:8080/api/v1/users?page=2
http://localhost:8080/api/v1/users?provider=DataProviderX&statusCode=refunded&balanceMin=120&balanceMax=320&currency=AED&page=2
```

## Test
```sh
php artisan test 
```

[![N|Solid](https://i.ibb.co/rwHCCnX/task.png)](https://nodesource.com/products/nsolid)

## License

MIT
