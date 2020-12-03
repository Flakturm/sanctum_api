Laravel 8 + Sanctum + API Tokens

## Local setup

### Install the dependencies

```bash
composer ins
npm i
```

### Setup `.env` file

```bash
cp .env.example .env
##
# adjust database settings to use sqlite or mysql
##
nano .env
##
# generate APP_KEY
##
php artisan key:generate
```

### Run migrations + seeding (optional)

```bash
php artisan migrate --seed
```

## Deployment in production

### Setup

```bash
# install dependencies
composer ins
npm i

# setup env
cp .env.production .env
##
# Adjust the following:
# - APP_URL
# - SANCTUM_STATEFUL_DOMAINS
# - SESSION_DOMAIN
# - Database related vars
##
nano .env
php artisan key:generate

# run migrations
php artisan migrate --seed
```

### Cache essentials

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Note**: You're going to use a subdomain for the backend.

That's it.

## Resources

- <https://laravel.com/docs/8.x/sanctum>
