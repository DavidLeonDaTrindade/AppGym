# AGENTS.md

## Tests

Pruebas automatizadas de AppGym.

## Reglas

- Priorizar tests de acceso, autorizacion y dominio.
- Si una regla de negocio cambia, añadir o ajustar test.
- Mantener separados `Feature` y `Unit`.

## Limitacion conocida

- En algunos entornos locales puede faltar `pdo_sqlite`; si pasa, documentarlo en vez de ocultarlo.
