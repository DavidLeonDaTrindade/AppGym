---
name: appgym-docker-laravel
description: Use when working on Docker, environment setup, Laravel bootstrapping, database connectivity, container startup, migrations, or local run/debug workflows for AppGym.
---

# AppGym Docker Laravel

Read these first:

- `/home/avid/proyecto/Proyecto/AppGym/AGENTS.md`
- `/home/avid/proyecto/Proyecto/AppGym/docker-compose.yml`
- `/home/avid/proyecto/Proyecto/AppGym/Dockerfile`
- `/home/avid/proyecto/Proyecto/AppGym/.env.example`

## Use this skill for

- Docker compose updates
- PHP container setup
- MySQL environment fixes
- Local startup and migration issues
- Bootstrapping new environments

## Working rules

- Keep AppGym isolated from `FMoli`.
- Prefer MySQL in Docker for local runtime.
- Keep `.env.example` aligned with `docker-compose.yml`.
- If changing ports or service names, update docs and references together.

## Typical workflow

1. Confirm container names, ports, and env vars.
2. Check Laravel DB settings in `.env.example`.
3. Align `docker-compose.yml`, `Dockerfile`, and README if needed.
4. Run migrations after infra changes.
5. Confirm the app routes still load.

## Files to inspect on demand

- `docker-compose.yml`
- `Dockerfile`
- `docker/apache/000-default.conf`
- `.env`
- `.env.example`
- `README.md`
