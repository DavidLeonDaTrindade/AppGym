# AGENTS.md

## Configuracion Laravel

Esta carpeta contiene la configuracion del framework y de paquetes.

## Reglas

- Preferir cambios por variables de entorno antes que valores hardcodeados.
- Mantener coherencia entre `config/*`, `.env` y `.env.example`.
- Si un cambio afecta auth, revisar tambien `routes/`, `app/Http/` y `app/Providers/`.
- Si un cambio afecta Filament, revisar tambien `app/Providers/Filament/`.

## Archivos sensibles

- `app.php`
- `auth.php`
- `database.php`
- `services.php`
