# AGENTS.md

## Dominio y modelos

Aqui vive el modelo de negocio de AppGym.

## Modelos principales

- `User`
- `Routine`
- `RoutineExercise`
- `Diet`
- `ClientRoutine`
- `ClientDiet`

## Invariantes

- Un cliente pertenece a un solo entrenador.
- Los registros trainer-owned deben referenciar `trainer_id`.
- Las asignaciones activas deben resolver la actual por cliente.
- Guardar una asignacion activa nueva desactiva la anterior del mismo tipo.

## Reglas

- Si cambias relaciones, revisar migraciones, policies y recursos Filament.
- Mantener casts y fillable alineados con la base de datos.
