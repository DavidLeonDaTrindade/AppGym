# AGENTS.md

## Filament Resources

Aqui viven los CRUDs y acciones del panel del entrenador.

## Reglas

- Mantener `form()` y `table()` alineados con el modelo real.
- Aplicar siempre scoping por entrenador en `getEloquentQuery()`.
- Si hay acciones de asignacion, validar clientes visibles y propiedad de registros.
- Si una columna o campo cambia, revisar tambien las vistas cliente si consumen ese dato.

## Recursos actuales

- `UserResource`
- `RoutineResource`
- `DietResource`
- `ClientRoutineResource`
- `ClientDietResource`
