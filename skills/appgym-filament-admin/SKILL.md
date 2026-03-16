---
name: appgym-filament-admin
description: Use when adding or changing trainer-facing admin features in AppGym with Filament, including client CRUDs, routines, diets, assignments, filters, ownership rules, and panel behavior.
---

# AppGym Filament Admin

Read these first:

- `/home/avid/proyecto/Proyecto/AppGym/AGENTS.md`
- `/home/avid/proyecto/Proyecto/AppGym/app/Providers/Filament/AdminPanelProvider.php`

Then load the relevant resource under `app/Filament/Resources/`.

## Use this skill for

- New trainer CRUDs in Filament
- Updating forms, tables, actions, or navigation
- Enforcing trainer ownership in resources
- Adding assignment flows from routines or diets to clients

## Working rules

- Trainer-facing work belongs in Filament, not in the client web area.
- Every query must stay scoped to the authenticated trainer when data is trainer-owned.
- For client selections, only show users with:
  - `role = client`
  - `trainer_id = auth()->id()`
- Keep labels in Spanish unless the project is explicitly changed.

## Typical workflow

1. Read the target resource and its `Pages/Manage...` file.
2. Confirm ownership rules in the model and policy.
3. Apply query scoping in `getEloquentQuery()`.
4. Add or update `form()` and `table()`.
5. If creating assignment actions, reuse existing routine/diet assignment patterns before inventing a new flow.
6. Verify `php artisan route:list` or the relevant Filament route still loads.

## Files to inspect on demand

- `app/Filament/Resources/UserResource.php`
- `app/Filament/Resources/RoutineResource.php`
- `app/Filament/Resources/DietResource.php`
- `app/Filament/Resources/ClientRoutineResource.php`
- `app/Filament/Resources/ClientDietResource.php`
- `app/Policies/*.php`
