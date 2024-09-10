### LARAVEL 11 - RESTful API.

***

[![PHP 8.2](https://img.shields.io/badge/php-8.2-%23777BB4?style=for-the-badge&logo=php&logoColor=black">)](https://www.php.net/releases/8_2_0.php)
[![Composer 2.7.9](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=Composer&logoColor=white>)](https://getcomposer.org/)
[![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)
[![Git](https://img.shields.io/badge/git-%23F05033.svg?style=for-the-badge&logo=git&logoColor=white)](https://git-scm.com/)
***
#### Requirement to add:

```
Makefile
```

***

#### Start server

```
make init
```

#### Stop server

```
make down
```

***
[Database SCHEMA ](https://dbdiagram.io/d/makarov-laravel-66dc3ccaeef7e08f0efc1143)
***

### Seed User & Partnership models to db

```
make seed-db
```

***

### Make Client

```json lines
// php artisan passport:client
// POST http://0.0.0.0/api/passport/token
{
    "grant_type": "password",
    "client_id": "client id",
    "client_secret": "client secret",
    "username": "user email",
    "password": "user password"
}
```


