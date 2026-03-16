# Filament Resource Map

- `UserResource`
  - Purpose: trainer CRUD of clients
  - Constraints: only clients of current trainer
- `RoutineResource`
  - Purpose: trainer CRUD of routines
  - Includes: repeater for exercises, assign action
- `DietResource`
  - Purpose: trainer CRUD of diets
  - Includes: assign action
- `ClientRoutineResource`
  - Purpose: direct routine assignments
- `ClientDietResource`
  - Purpose: direct diet assignments

## Repeated patterns

- `Hidden::make('trainer_id')->default(fn () => auth()->id())`
- `getEloquentQuery()->where('trainer_id', auth()->id())`
- client selects filtered by `role=client` and `trainer_id=auth()->id()`
