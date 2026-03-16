# AGENTS.md

## Panel del entrenador

Aqui vive la administracion interna construida con Filament.

## Objetivo

- CRUD de clientes
- CRUD de rutinas
- CRUD de dietas
- Asignaciones de rutinas y dietas

## Reglas

- Toda query trainer-owned debe filtrarse por `auth()->id()`.
- Los clientes visibles en selects deben cumplir:
  - `role = client`
  - `trainer_id = auth()->id()`
- Mantener etiquetas en espanol.
- No mover funciones del cliente final a Filament.

## Archivos importantes

- `Resources/`
- `../Providers/Filament/AdminPanelProvider.php`
