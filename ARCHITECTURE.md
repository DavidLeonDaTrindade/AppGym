# Architecture

## Objetivo funcional

La aplicacion tiene dos perfiles:

- `trainer`: administra clientes, rutinas, dietas y asignaciones.
- `client`: inicia sesion y consulta su rutina y dieta actuales.

Solo pueden acceder usuarios creados por un entrenador.

## Flujo actual

- Home: `/`
- Login: `/login`
- Logout: `/logout`
- Panel entrenador: `/admin`
- Dashboard cliente: `/dashboard`
- Rutina cliente: `/mi-rutina`
- Dieta cliente: `/mi-dieta`

## Dominio principal

- `User`
  - `role`
  - `is_active`
  - `trainer_id`
  - `notes`
- `Routine`
- `RoutineExercise`
- `Diet`
- `ClientRoutine`
- `ClientDiet`

## Reglas de negocio

- Un cliente pertenece a un solo entrenador en v1.
- Un entrenador solo ve y edita sus propios clientes y contenidos.
- Un cliente solo ve sus asignaciones activas.
- Al guardar una asignacion activa nueva para un cliente, la previa del mismo tipo se desactiva.

## Capas actuales

- Filament gestiona la experiencia del entrenador.
- Blade gestiona la experiencia del cliente.
- Policies y gates separan acceso por rol y propiedad.
- Docker levanta `app` y `db`.

## Archivos clave

- `app/Models/User.php`
- `app/Providers/AppServiceProvider.php`
- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `app/Http/Controllers/ClientDashboardController.php`
- `routes/web.php`

## Usuario inicial

- email: `trainer@appgym.local`
- password: `password`
