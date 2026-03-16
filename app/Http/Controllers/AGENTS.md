# AGENTS.md

## Controllers

Aqui viven los controladores web de AppGym.

## Reglas

- Mantener controladores ligeros.
- Delegar reglas persistentes al modelo, policy o capa apropiada.
- No duplicar logica de acceso que ya exista en middleware o gates.

## Archivos actuales

- `Auth/AuthenticatedSessionController.php`
- `ClientDashboardController.php`
