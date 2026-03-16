# AGENTS.md

## Migrations

Migraciones del esquema de AppGym.

## Reglas

- Mantener el orden correcto cuando existan claves foraneas.
- Crear primero tablas base y luego tablas hijas.
- Si el esquema ya esta usado en Docker, preferir nuevas migraciones en vez de reescribir antiguas, salvo fase de arranque muy controlada.
- Tras cambios, validar con `migrate:fresh --seed` en entorno local.

## Dependencias actuales

- `users` antes que cualquier tabla del dominio
- `routines` antes que `routine_exercises`
- `diets` antes que `client_diets`
- `routines` antes que `client_routines`
