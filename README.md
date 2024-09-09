### LARAVEL 11 - RESTful API.

***

#### Requirements:

```
Makefile
Docker
Git
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


