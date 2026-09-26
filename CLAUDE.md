# Project notes for Claude

Website + admin panel for **International Peace School & College, Lakshmipur** (a new branch of the IPSC network; the Rajshahi branch site ipscraj.com was the starting reference). Real client. The owner reviews every change as a pull request.

## Stack
- Laravel 13, PHP 8.3+, MySQL, Blade + Tailwind CSS 4 (Vite) + Alpine.js on the public site
- Filament 5 admin panel at `/admin`
- Hosted on Hostinger, auto-deployed from `main`

## Rules
- Never push to `main` directly: work on a `feature/...` or `fix/...` branch and open a PR.
- Database changes only via migrations: add-only and reversible. No dropping or renaming columns that hold live data without a plan.
- English (`en`) is the default language, with Bangla (`bn`) one click away; every public page must work in both. The admin panel is in English. Don't mix languages within a section.
- Interface strings: `__('English text')` with translations in `lang/bn.json`. Page content: `lang/{bn,en}/site.php` until it moves to the database.
- Icons are inline SVG via `resources/views/partials/icon.blade.php` (no icon fonts).
- Keep it fast: compiled Tailwind only, self-hosted fonts, no CDN scripts.

## Roadmap
1. Public website (bilingual) — in progress
2. Admin modules in Filament: notices, events, admissions, gallery, careers, academics, contact messages, settings, roles
3. Event registration with Bkash payments
4. Student management (records, fees, results, attendance, parent logins)
