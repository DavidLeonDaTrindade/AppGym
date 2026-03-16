---
name: appgym-domain-fitness
description: Use when changing AppGym's core fitness domain model, including users, trainer-client ownership, routines, exercises, diets, assignment rules, migrations, and model relationships.
---

# AppGym Domain Fitness

Read these first:

- `/home/avid/proyecto/Proyecto/AppGym/AGENTS.md`
- `/home/avid/proyecto/Proyecto/AppGym/app/Models/User.php`

Then load the specific related model and migration.

## Use this skill for

- New domain entities
- Migration changes
- Relationship updates
- Assignment activation rules
- Business-rule updates around trainer/client ownership

## Core invariants

- One client belongs to one trainer in v1.
- Trainer-owned records must always be traceable by `trainer_id`.
- Client assignment reads must resolve to the current active record.
- New active assignments should deactivate previous active ones of the same type for the same client.

## Working rules

- Update model, migration, policy, and UI query scope together when ownership changes.
- Prefer explicit relationships over hidden query assumptions.
- Keep naming aligned with existing models:
  - `Routine`
  - `RoutineExercise`
  - `Diet`
  - `ClientRoutine`
  - `ClientDiet`

## Files to inspect on demand

- `app/Models/*.php`
- `database/migrations/*.php`
- `app/Policies/*.php`
- `database/seeders/DatabaseSeeder.php`
- `database/factories/UserFactory.php`
