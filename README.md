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

## Serve

- Serve the application with artisan CLI then open the app on the browser on `http://localhost:8000`

```shell
php artisan serve
```

- If you want to use laravel sail, turn off any service/web server that used port 80 on your local machine
  start your docker service then you can update the `.env` file contents

```dotenv
APP_URL=http://localhost
DB_HOST=mysql
```

serve with sail artisan CLI then open the app on the browser on `http://localhost`

```shell
./vendor/bin/sail up -d
```

run migration with command

```shell
./vendor/bin/sail artisan migrate
```
