# AGENTS.md

## Proyecto

`AppGym` es una aplicacion web de entrenamiento personal construida en:

- Laravel 12
- Filament v3
- MySQL
- Docker

## Reglas globales

- Trabajar solo dentro de `/home/avid/proyecto/Proyecto/AppGym`.
- No tocar `FMoli`; es otro proyecto.
- Mantener separadas el area de entrenador y el area de cliente.
- No introducir app movil nativa salvo que se pida expresamente.
- No romper compatibilidad con la arquitectura actual.

## Zonas principales

- `app/`: backend Laravel
- `app/Filament/`: panel del entrenador
- `app/Http/`: auth, middleware y controladores web
- `app/Models/`: dominio fitness
- `database/`: migraciones, seeders y factories
- `resources/views/`: interfaz Blade
- `routes/`: rutas web y consola
- `docker/`: infraestructura local
- `skills/`: contexto reusable para prompts futuros

## Carga adicional

Si hace falta mas contexto, leer:

- [ARCHITECTURE.md](/home/avid/proyecto/Proyecto/AppGym/ARCHITECTURE.md)
