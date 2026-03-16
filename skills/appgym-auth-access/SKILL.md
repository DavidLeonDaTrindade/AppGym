---
name: appgym-auth-access
description: Use when working on login, logout, active-user checks, trainer/client routing, middleware, gates, policies, or any access-control behavior in AppGym.
---

# AppGym Auth Access

Read these first:

- `/home/avid/proyecto/Proyecto/AppGym/AGENTS.md`
- `/home/avid/proyecto/Proyecto/AppGym/routes/web.php`
- `/home/avid/proyecto/Proyecto/AppGym/app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `/home/avid/proyecto/Proyecto/AppGym/app/Http/Middleware/EnsureUserIsActive.php`

## Use this skill for

- Login and logout changes
- Redirects by role
- Blocking inactive users
- Policies and gate changes
- Protecting trainer vs client boundaries

## Working rules

- `trainer` goes to `/admin`.
- `client` goes to `/dashboard`.
- Inactive users must not remain authenticated.
- Client area must stay outside Filament.
- Filament access is only for active trainers.

## Validation checklist

- Guest can open `/login`
- Inactive user cannot log in
- Trainer redirects to `/admin`
- Client redirects to `/dashboard`
- Client cannot access trainer panel
- Trainer-only resources remain protected by query scope and policy

## Files to inspect on demand

- `app/Models/User.php`
- `app/Providers/AppServiceProvider.php`
- `app/Policies/*.php`
- `app/Providers/Filament/AdminPanelProvider.php`
- `tests/Feature/AppGymAccessTest.php`
