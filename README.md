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

- English is the default (`APP_LOCALE=en`). URLs are prefixed with the language: `/en/...` and `/bn/...`. The root `/` redirects to the default language.
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

The site is served from `public_html/ipsc/public` (subdomain document root). The project lives in `public_html/ipsc`; its root `.htaccess` refuses all web requests, so only `public/` is reachable.

CSS/JS is built locally (`npm run build`) and `public/build` is committed, so the server doesn't need Node.js.

After the server pulls the latest `main`, run:

```bash
cd ~/domains/modomake.agency/public_html/ipsc
bash deploy.sh
```

`deploy.sh` installs PHP packages, runs migrations, links storage and refreshes caches.

Server `.env` essentials: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://<domain>`, `APP_NOINDEX=true` while on the temporary domain, and the `DB_*` values from hPanel.

Database changes only go through migrations: add-only and reversible. Back up the database before any deploy that includes a migration.
