# AGENTS.md

## HTTP Layer

Esta carpeta contiene login, logout, middleware y controladores web.

## Responsabilidades

- autenticacion web
- redireccion por rol
- bloqueo de usuarios inactivos
- dashboard y vistas cliente

## Reglas

- `trainer` redirige a `/admin`
- `client` redirige a `/dashboard`
- usuarios inactivos no deben permanecer autenticados
- la experiencia cliente debe mantenerse fuera de Filament

## Archivos clave

- `Controllers/Auth/AuthenticatedSessionController.php`
- `Controllers/ClientDashboardController.php`
- `Middleware/EnsureUserIsActive.php`
