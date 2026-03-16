---
name: appgym-context
description: Use when working on AppGym and you need the project-specific functional and technical context, including roles, routes, stack, boundaries, and current architecture.
---

# AppGym Context

Read `/home/avid/proyecto/Proyecto/AppGym/AGENTS.md` first.

## Use this skill for

- Understanding the project before implementing changes
- Keeping work isolated to `Proyecto/AppGym`
- Respecting the current trainer/client split
- Remembering the agreed stack: Laravel, Filament, MySQL, Docker

## Current rules

- Do not modify `FMoli`; it is a separate project.
- Keep trainer admin work in Filament.
- Keep client access in the web area outside Filament.
- Do not introduce native mobile scope unless the user explicitly asks for it.

## Load on demand

- If the task touches routes, read `routes/web.php`.
- If it touches login or access, read `app/Http/Controllers/Auth/AuthenticatedSessionController.php`.
- If it touches the client area, read `app/Http/Controllers/ClientDashboardController.php`.
- If it touches trainer CRUDs, read the relevant file under `app/Filament/Resources/`.
