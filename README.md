# Laravel E‑Commerce MVP (COD)

**Name:** Umer  
**Roll No:** cosc231101048

## Project Overview

This is a simple e-commerce MVP built with Laravel:
- Storefront: `/` (featured), `/products`, `/products/{slug}`, `/categories/{slug}`
- Cart: `/cart`
- Checkout (Cash on Delivery): `/checkout`
- Admin (basic CRUD): `/admin` (requires `is_admin = 1`)

**Project Demo Video:** [Watch on Google Drive](https://drive.google.com/file/d/1dO-IcgrZN-9SN5l53lBNBgzvTY6NnPvg/view?usp=sharing)

## Local setup

```bash
cd laravel-ecommerce
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Make an admin user

Register a user via `/register`, then in Tinker:

```bash
php artisan tinker
>>> \App\Models\User::query()->where('email', 'you@example.com')->update(['is_admin' => true]);
```

## Tests

```bash
php artisan test
```

## Deployment

See `DEPLOYMENT.md`.
# larvel-ecommerce
