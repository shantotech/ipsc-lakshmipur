# International Peace School & College, Lakshmipur — Website

The public website (Bangla + English) and admin panel for the Lakshmipur branch of International Peace School & College.

- **Website:** Laravel 13 + Blade, Tailwind CSS 4 (compiled with Vite), Alpine.js
- **Admin panel:** Filament 5 at `/admin`
- **Database:** MySQL
- **Hosting:** Hostinger (auto-deploy from the `main` branch)

## Requirements

- PHP 8.3 or newer (with `intl`, `mbstring`, `pdo_mysql`, `gd`, `zip`)
- Composer 2
- Node.js 20 or newer
- MySQL 8

## Local setup

```bash
git clone https://github.com/shantotech/ipsc-lakshmipur.git
cd ipsc-lakshmipur

composer install              # first time only: run `composer update` if there is no composer.lock yet
cp .env.example .env          # then fill in the DB_* values
php artisan key:generate
php artisan migrate
php artisan storage:link

npm install
npm run build                 # or `npm run dev` while working on the design

php artisan make:filament-user   # create your admin login
php artisan serve                # open http://localhost:8000
```

The admin panel is at `http://localhost:8000/admin`.

## Languages

- Bangla is the default. URLs are prefixed with the language: `/bn/...` and `/en/...`. The root `/` redirects to `/bn`.
- Interface text lives in `lang/bn.json` and `lang/en.json` (keyed by the English text).
- Page content lives in `lang/bn/site.php` and `lang/en/site.php` until the admin modules take it over.

## Project layout

| Path | What's there |
|---|---|
| `routes/web.php` | All public pages |
| `app/Http/Controllers/PageController.php` | Renders the public pages |
| `app/Support/` | Small helpers (Bangla numbers/dates, demo notices and gallery data) |
| `resources/views/layouts/` | Site layout (header, footer) |
| `resources/views/pages/` | One view per page |
| `resources/views/partials/` | Reusable pieces (page header, icons, cards) |
| `resources/css/app.css` | Tailwind theme: brand colors and fonts |
| `app/Providers/Filament/AdminPanelProvider.php` | Admin panel setup |

## Workflow

1. All changes go through GitHub. Never edit files directly on the server.
2. Work happens on a branch (`feature/...`, `fix/...`) and is opened as a pull request.
3. Merging into `main` deploys to the live site.

## Deploying (Hostinger)

After Hostinger pulls the latest `main`, these commands must run on the server (via SSH or a deploy script):

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
npm ci && npm run build        # or commit the built assets if Node isn't available on the server
```

Database changes only go through migrations: add-only and reversible. Back up the database before any deploy that includes a migration.
