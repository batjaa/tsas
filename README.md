# First-Time Setup

## 1. Install prerequisites

Install Homebrew (if needed), then Composer, Node.js (LTS), and Docker Desktop:

```bash
brew install composer
brew install node
```

Open Docker Desktop and make sure Docker is running before continuing.

## 2. Configure Composer auth for Laravel Nova

Use your Nova account email + license key:

```bash
composer config http-basic.nova.laravel.com <email> <license-key>
```

## 3. Install PHP dependencies

```bash
composer install
```

## 4. Create and update environment config

Copy the env file:

```bash
cp .env.example .env
```

This project runs MySQL in Docker (`compose.yaml`), so update `.env` from SQLite defaults to MySQL values:

```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=tsas
DB_USERNAME=sail
DB_PASSWORD=password
```

Then generate the app key:

```bash
php artisan key:generate
```

## 5. Start containers

```bash
./vendor/bin/sail up -d
```

## 6. Run database migrations

```bash
./vendor/bin/sail artisan migrate
```

## 7. Install frontend dependencies (for Vite assets)

```bash
npm install
npm run build
```

## 8. Generate test product data

```bash
./vendor/bin/sail artisan db:seed --class=Database\\Seeders\\ProductSeeder
```

# Development

Run the app stack:

```bash
./vendor/bin/sail up
```

# Admin (Nova)

Visit `/nova`.

Publish Nova assets and create an admin user if needed:

```bash
./vendor/bin/sail artisan nova:publish
./vendor/bin/sail artisan nova:user
```
