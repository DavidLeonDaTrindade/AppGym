# AGENTS.md

## Filament Provider

Aqui se configura el panel del entrenador.

## Responsabilidades

- ruta del panel
- login del panel
- middleware del panel
- descubrimiento de recursos y paginas

## Reglas

- El panel es solo para entrenadores activos.
- No mezclar vistas cliente dentro de Filament.
- Si cambias middleware o auth del panel, revisar tambien login y policies.
