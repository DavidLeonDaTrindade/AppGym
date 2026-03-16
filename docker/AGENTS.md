# AGENTS.md

## Docker

Infraestructura local de AppGym.

## Servicios actuales

- `app`
- `db`

## Reglas

- Mantener `docker-compose.yml`, `Dockerfile` y `.env.example` alineados.
- No cambiar puertos o nombres de servicio sin actualizar documentacion.
- La imagen PHP debe ser compatible con la version exigida por Composer.

## Valores actuales

- web: `localhost:8080`
- mysql host: `db`
- mysql puerto host: `3308`
