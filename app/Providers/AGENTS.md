# AGENTS.md

## Providers

Esta carpeta registra infraestructura de aplicacion, gates y paneles.

## Reglas

- Registrar aqui gates y policies globales.
- Mantener `Filament` aislado en `Providers/Filament/`.
- Si cambias acceso por rol, revisar:
  - `AppServiceProvider.php`
  - `User.php`
  - middleware y rutas relacionadas

## Archivos clave

- `AppServiceProvider.php`
- `Filament/AdminPanelProvider.php`
