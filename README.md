# TSAS — Professional Work Uniforms (Мэргэжлийн Ажлын Хувцас)

E-commerce storefront for professional uniforms (cook, medical, service) serving the Mongolian market at [tsas.mn](https://tsas.mn).

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12, PHP 8.2+ |
| Auth | Laravel Breeze (session-based) |
| Admin | Laravel Nova 5 |
| Frontend | Blade templates, Alpine.js, Tailwind CSS v3 |
| Build | Vite 7 |
| Images | Intervention Image (WebP, 4 responsive variants) |
| Storage | Local disk or S3 (configurable) |
| Database | MySQL |
| Dev environment | Laravel Sail (Docker) |

## Project Structure

```
app/
├── Console/Commands/        # Artisan commands (sitemap:generate, etc.)
├── Helpers/ColorMap.php     # Mongolian color name → hex mapping
├── Http/Controllers/
│   ├── HomeController.php   # Homepage (featured products, categories, hero)
│   └── ProductController.php # Product listing + detail
├── Models/
│   ├── Product.php          # name, description, category, badge, is_featured
│   ├── ProductVariant.php   # sku, size, color, price, stock, is_available
│   └── ProductImage.php     # disk, path, variants (json), srcset support
├── Nova/                    # Admin panel resources + actions
│   ├── Product.php
│   ├── ProductVariant.php
│   ├── ProductImage.php
│   └── Actions/             # UploadProductImages, SetPrimaryImage
├── Observers/               # ProductImageObserver (cleanup on delete)
└── Services/
    └── ImageProcessingService.php  # Upload → orient → WebP → 4 size variants

resources/views/
├── components/
│   └── layouts/
│       └── storefront.blade.php    # Main storefront layout (SEO meta, OG tags)
│   └── storefront/
│       ├── header.blade.php        # Sticky header, mobile hamburger
│       ├── footer.blade.php
│       ├── hero.blade.php          # Image collage hero
│       ├── product-card.blade.php  # Product grid card
│       ├── profession-card.blade.php # Category card with icon
│       ├── responsive-image.blade.php # <img> with srcset
│       ├── phone-cta.blade.php
│       ├── about-quote.blade.php
│       ├── announcement-bar.blade.php
│       ├── mobile-bottom-bar.blade.php
│       └── wavy-divider.blade.php
├── pages/
│   ├── home.blade.php
│   ├── about.blade.php
│   ├── cart.blade.php
│   ├── account.blade.php
│   └── products/
│       ├── index.blade.php         # Grid with category filter
│       └── show.blade.php          # Detail with variant picker (Alpine.js)

config/
├── site.php          # phone number
└── media.php         # disk, format (webp), quality (80), variant sizes
```

## Routes

| Method | URI | Handler | Description |
|--------|-----|---------|-------------|
| GET | `/` | HomeController | Homepage with featured products, categories |
| GET | `/products` | ProductController@index | Product listing, optional `?category=` filter |
| GET | `/products/{id}` | ProductController@show | Product detail with variant picker |
| GET | `/about` | view | About page |
| GET | `/cart` | view | Cart (placeholder) |
| GET | `/account` | view | Account (placeholder) |
| GET | `/dashboard` | view | Auth dashboard (Breeze) |
| * | `/profile` | ProfileController | Profile CRUD (auth) |
| * | `/nova` | Nova | Admin panel (auth) |

## Data Model

```
Product
├── id, name, description, category, min_variant_price, is_featured, badge
├── has many → ProductVariant (sku, size, color, price, stock, is_available)
└── has many → ProductImage (disk, path, original_filename, mime_type, size, variants, order, is_primary)
```

- **Variants** represent size/color combinations, each with its own price and stock
- **Images** store the original path plus a `variants` JSON column with responsive sizes: thumbnail (150w), small (400w), medium (800w), large (1200w)
- All images auto-converted to WebP on upload via `ImageProcessingService`

## Design Tokens

| Token | Value |
|-------|-------|
| Concrete (background) | `#E8E4DF` |
| Charcoal (text/primary) | `#2D2926` |
| Safety Orange (accent/CTA) | `#E8651A` |
| Steel Blue (secondary) | `#4A6FA5` |
| Heading font | Oswald |
| Body font | Source Sans 3 |
| Mono font | JetBrains Mono |

## SEO

- Open Graph + Twitter Card meta tags on all pages (via storefront layout)
- Canonical URLs on every page
- JSON-LD structured data (Schema.org `Product`) on product pages
- `php artisan sitemap:generate` → `public/sitemap.xml`
- `robots.txt` with sitemap directive and disallow rules for private paths

---

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

## Coolify production

Coolify deploys `compose.yml` from `master`: PHP 8.4/Apache, MySQL 8.0, and a dedicated Laravel Nightwatch agent, with persistent database and local upload volumes. R2 remains the production media store. Copy the existing app key, database credentials, Nova license, and R2 credentials into Coolify runtime settings. Set `TRUSTED_PROXIES=*` behind the private ingress and `SESSION_SECURE_COOKIE=true`.

Configure `COMPOSER_AUTH` as a build-only secret containing Nova HTTP Basic credentials and enable Coolify build secrets. Set database passwords for both build and runtime interpolation. Keep `RUN_MIGRATIONS=false` while importing and verifying a migration snapshot; enable it during production cutover. No queue worker or scheduler is required by the current application.

Set `NIGHTWATCH_ENABLED=true`, the TSAS Production environment token as `NIGHTWATCH_TOKEN`, `NIGHTWATCH_INGEST_URI=nightwatch:2411`, `LOG_CHANNEL=stack`, and `LOG_STACK=stderr,nightwatch` in Coolify runtime settings. The agent runs from the same application image, restarts automatically, and accepts traffic only inside the container network; port 2411 is not published. Verify connectivity with `php artisan nightwatch:status` inside the app container and confirm requests in the TSAS Production dashboard. Nightwatch is disabled in `.env.example` and PHPUnit to keep local development and tests out of production telemetry.

## Production database maintenance

The Coolify Compose stack uses MySQL 8.4.11. Database volumes have versioned names so the pre-upgrade volumes can be retained for recovery. Back up and rehearse a restore before changing database versions; stop app writers and drain workers before the final copy.

Retained old volumes are migration snapshots, not replicas. Reconcile writes made after the upgrade before any rollback; never start an older database image against an upgraded data directory.
