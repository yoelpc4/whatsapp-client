# Whatsapp Client

An example project to utilize [whatsapp service](https://github.com/yoelpc4/whatsapp-service) with features:

- Manage sender
- Manage receiver
- Send message to person / group with log message

## Installation

- Install project dependencies

```shell
composer install
```

- Copy environment file then adjust the value with local machine configuration

```shell
cp .env.example .env
```

- Generate encryption key

```shell
php artisan key:generate
```

- Run migrations and seeders

```shell
php artisan migrate --seed
```

- Adjust the whatsapp service url on environment file

- Clear config in order to reflect changes from .env to the configuration file

```shell
php artisan config:clear
```

- Generate ide helper files

```shell
php artisan clear-compiled && php artisan ide-helper:generate && php artisan ide-helper:models -M && php artisan ide-helper:meta
```

## Serve

- If you use Laravel Valet you can skip this step and directly open the app on the browser
  based on `APP_URL` value on .env, else serve the application with artisan CLI then open the app on the browser
  on `http://localhost:8000`

```shell
php artisan serve
```

- If you want to use laravel sail you can serve with command

```shell
sail up
```
