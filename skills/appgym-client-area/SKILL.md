---
name: appgym-client-area
description: Use when building or updating the client-facing web area in AppGym, including dashboard, routine view, diet view, navigation, empty states, and responsive presentation.
---

# AppGym Client Area

Read these first:

- `/home/avid/proyecto/Proyecto/AppGym/AGENTS.md`
- `/home/avid/proyecto/Proyecto/AppGym/routes/web.php`
- `/home/avid/proyecto/Proyecto/AppGym/app/Http/Controllers/ClientDashboardController.php`

Then read the relevant Blade views under `resources/views/client/`.

## Use this skill for

- Dashboard changes for clients
- Routine and diet page updates
- Responsive UI improvements
- Empty states and client messaging
- Keeping the client experience separate from trainer admin

## Working rules

- Keep client UI outside Filament.
- Show only the authenticated client's current active assignments.
- Prefer clear empty states over broken or blank sections.
- Keep copy in Spanish.
- Preserve mobile readability.

## Data expectations

- Current routine comes from `clientRoutineAssignments()->current()`
- Current diet comes from `clientDietAssignments()->current()`
- Views should tolerate `null` assignment safely

## Files to inspect on demand

- `app/Http/Controllers/ClientDashboardController.php`
- `resources/views/components/layouts/app.blade.php`
- `resources/views/client/dashboard.blade.php`
- `resources/views/client/routine.blade.php`
- `resources/views/client/diet.blade.php`
- `resources/views/client/partials/nav.blade.php`
