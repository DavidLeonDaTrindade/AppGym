# Access Rules

- Roles:
  - `trainer`
  - `client`
- Active flag:
  - `is_active = true` required for real access
- Client area routes:
  - `/dashboard`
  - `/mi-rutina`
  - `/mi-dieta`
- Trainer area:
  - `/admin`

## Current code anchors

- User role helpers in `app/Models/User.php`
- Gate registration in `app/Providers/AppServiceProvider.php`
- Login flow in `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- Active-user enforcement in `app/Http/Middleware/EnsureUserIsActive.php`
