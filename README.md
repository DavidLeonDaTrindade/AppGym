# AppGym

Aplicación Laravel 12 para gestión de entrenamiento personal.

## Qué incluye

- Panel de entrenador con Filament en `/admin`
- Login para clientes y entrenadores
- CRUD de clientes
- CRUD de rutinas y dietas
- Asignación de rutinas y dietas a clientes
- Área cliente con dashboard, rutina y dieta

## Arranque con Docker

```bash
docker compose up --build -d
docker compose exec app composer install
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

## Accesos iniciales

- Entrenador:
  - email: `trainer@appgym.local`
  - password: `password`

## URLs

- Web cliente: `http://localhost:8080/login`
- Panel entrenador: `http://localhost:8080/admin`
