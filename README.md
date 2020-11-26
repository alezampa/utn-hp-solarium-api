# UTN HP Solarium API ☀


## Technology Stack 👨‍💻
- [Laravel](https://laravel.com/)
- [MySQL](https://mysql.com/)
- [PHP 7.3](https://php.net/)


# Steps

1. Clone the repo
2. Create a new database MySQL (e.g `solarium`) , characters UTF-8
3. `cd utn-hp-solarium-api`
4. Rename the file `.env.example` to `.env`. 
You can use this command 
```mv .env.example .env```

5. Edit the file `.env`

```php
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=solarium
    DB_USERNAME=root
    DB_PASSWORD=
```
6. `composer install`
7. `php artisan key:generate`
8. `php artisan migrate:fresh`
9. `php artisan jwt:secret`

## UI Project 🖥

The UI project -> [HERE](https://github.com/mp182/utn-hp-solarium-ui)

## Contact 📧

If you want to contact me you can reach me at <alezampa@gmail.com>.
