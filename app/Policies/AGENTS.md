# AGENTS.md

## Policies

Aqui viven las reglas de autorizacion de AppGym.

## Reglas

- Toda policy trainer-owned debe validar propiedad por `trainer_id`.
- No dar acceso transversal entre entrenadores.
- Los clientes no deben obtener permisos de gestion.
- Si cambias una policy, revisar tambien:
  - `app/Providers/AppServiceProvider.php`
  - el recurso Filament o controlador que dependa de ella

## Casos actuales

- `UserPolicy`: clientes del entrenador
- `RoutinePolicy`: rutinas del entrenador
- `DietPolicy`: dietas del entrenador
- `ClientRoutinePolicy`: asignaciones de rutina del entrenador
- `ClientDietPolicy`: asignaciones de dieta del entrenador
