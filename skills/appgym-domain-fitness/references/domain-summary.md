# Domain Summary

## User

- `role`
- `is_active`
- `trainer_id`
- `notes`

## Trainer-owned content

- `Routine`
- `Diet`
- direct assignment records

## Assignment records

- `ClientRoutine`
- `ClientDiet`

Important behavior:

- current scope uses date window plus `is_active`
- saving an active assignment deactivates older active assignments for that client
