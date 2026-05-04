# Deployment checklist (MVP)

## App config
- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Set `APP_URL=https://your-domain`
- Set `APP_KEY` (run `php artisan key:generate --force` once if not set)

## Database
- Configure `DB_CONNECTION` + credentials in `.env`
- Run migrations:

```bash
php artisan migrate --force
```

## Storage (uploads)
- If you use local public storage:

```bash
php artisan storage:link
```

- If you use S3, configure `FILESYSTEM_DISK=s3` + `AWS_*` env vars.

## Performance
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Queue / sessions (if needed)
- This project uses `QUEUE_CONNECTION=database` and `SESSION_DRIVER=database` by default.
- Ensure a queue worker runs if you add queued jobs:

```bash
php artisan queue:work --tries=1
```

## Health check
- `GET /up`

## Admin access
- Create an account via `/register`, then set `users.is_admin = 1`.
