# AGENTS.md

## Rutas

Esta carpeta define la entrada HTTP y consola.

## Reglas

- Mantener las rutas de cliente fuera de Filament.
- Mantener redirecciones por rol coherentes con auth actual.
- Evitar mezclar responsabilidades de entrenador y cliente en una misma ruta.

## Convenciones actuales

- `/admin`: entrenador
- `/login`: acceso comun
- `/dashboard`: resumen cliente
- `/mi-rutina`: rutina cliente
- `/mi-dieta`: dieta cliente
