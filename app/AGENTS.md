# AGENTS.md

## Backend Laravel

Esta carpeta contiene el backend principal de AppGym.

## Subzonas

- `Filament/`: panel del entrenador
- `Http/`: auth, controladores y middleware
- `Models/`: entidades del dominio
- `Policies/`: reglas de autorizacion
- `Providers/`: registro de gates, panel y servicios

## Reglas

- Mantener la logica de negocio fuera de las vistas.
- Mantener clara la separacion entre entrenador y cliente.
- Si una regla afecta propiedad o permisos, revisar tambien `Policies/` y `Providers/`.
- Mantener nombres del dominio alineados con el modelo actual.
