# AGENTS.md

## Middleware

Middleware HTTP de AppGym.

## Reglas

- Usar middleware para checks transversales y repetibles.
- No meter aqui logica de dominio compleja.
- Si un middleware afecta autenticacion, validar tambien rutas y redirecciones.

## Middleware actual

- `EnsureUserIsActive.php`
