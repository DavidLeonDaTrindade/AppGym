---
name: skill-template
description: Base template for creating new Codex skills in AppGym. Use when defining a new project-specific skill with workflows, references, scripts, or assets.
---

# Skill Template

Use this folder as the starting point for new skills in `AppGym`.

## Expected structure

- `SKILL.md`: required metadata and instructions
- `agents/openai.yaml`: UI metadata for skill listings
- `scripts/`: deterministic helpers or automation
- `references/`: docs to load only when needed
- `assets/`: templates or non-context output files

## How to adapt this template

1. Rename the folder using lowercase letters, digits, and hyphens only.
2. Replace the `name` and `description` in the frontmatter.
3. Keep only instructions that Codex would not already know.
4. Move detailed docs into `references/` instead of bloating `SKILL.md`.
5. Add scripts only when repeatability or reliability matters.

## Writing guidance

- Keep `SKILL.md` concise.
- Describe when the skill should trigger.
- Document the workflow in ordered steps when sequence matters.
- Link to `references/` files directly from this file when they are needed.
