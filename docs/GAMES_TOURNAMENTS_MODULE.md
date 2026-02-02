# ArenaMind — Games & Tournaments Module (Symfony 6.4)
Version: 1.0  
Date: 2026-02-01  
Owner: Games & Tournaments Module Team Member (you)

## 1) What this module is
ArenaMind is an esports platform. This module delivers:
- Public browsing of **Games** and **Tournaments**
- Admin CRUD for **Games**, **Tournaments**, and **Predictions**
- Logged-in user feature: **Predictions** (users predict tournament outcomes)

Tech constraints:
- Symfony 6.4 + Doctrine ORM + Doctrine Migrations
- MySQL 8+
- Twig (server-side rendering)
- Symfony Security roles

---

## 2) Scope (what I will build)
### Included
**Entities**
- Game
- Tournament
- Prediction
- Relation to User (if authentication exists) OR fallback to string username

**Public Pages (Twig)**
- `/` Home (stats + highlighted tournaments)
- `/games` Games list
- `/tournaments` Tournaments list (filters: status + game)
- `/tournaments/{id}` Tournament details

**User Pages (Twig)**
- `/predictions` My predictions
- `/predictions/new/{tournamentId}` Create prediction (ROLE_USER)

**Admin Pages**
- `/admin/games` CRUD (ROLE_ADMIN)
- `/admin/tournaments` CRUD (ROLE_ADMIN)
- `/admin/predictions` Manage predictions (ROLE_ADMIN)

### Not included
- Team/player management
- Brackets/match system beyond basic tournament fields
- Payments/streaming/live system

---

## 3) Data Model
### Game
- id (PK)
- name (string, unique)
- description (text)
- genre (string, nullable)
- image (string, nullable)
- createdAt (datetime_immutable)
Relations:
- One Game -> Many Tournaments

### Tournament
- id (PK)
- title (string)
- description (text, nullable)
- startDate (datetime)
- endDate (datetime)
- maxTeams (int)
- status (string enum-like: UPCOMING | ONGOING | FINISHED)
- createdAt (datetime_immutable)
Relations:
- Many Tournaments -> One Game
- One Tournament -> Many Predictions

### Prediction
- id (PK)
- tournament (ManyToOne)
- user (ManyToOne) OR username(string) if no User entity exists
- predictedWinner (string) OR predictedTeamId (int)
- predictedScore (string/int, nullable)
- isCorrect (bool, nullable)
- createdAt (datetime_immutable)
Relations:
- Many Predictions -> One Tournament
- Many Predictions -> One User (if auth exists)

Assumption (lowest-risk):
- If the project already has `App\Entity\User`, Prediction uses ManyToOne(User).
- If not, use `username` string field temporarily (and refactor later).

---

## 4) Security Rules (Mandatory)
- Admin routes require `ROLE_ADMIN`
- Prediction create/list requires `ROLE_USER`
- Public pages are accessible to visitors

Where enforced:
- Access control in `security.yaml` (route patterns)
- Controller-level protection with `#[IsGranted('ROLE_...')]` where needed

---

## 5) Work Plan (Step-by-step delivery)
### Phase A — Entities + Migrations
1. Create entities Game, Tournament, Prediction
2. Add relations (Game<->Tournament, Tournament<->Prediction, Prediction<->User if exists)
3. Add validation constraints
4. Generate migration + run migrate
5. Optional: fixtures for demo data

Deliverable:
- Schema managed via migrations, no manual SQL

### Phase B — Public Controllers + Repositories
1. HomeController: stats (tournament count + optional featured tournaments)
2. TournamentController:
   - list with filters (status, game)
   - show details
3. GameController: list
4. Repository helper methods:
   - TournamentRepository::findByFilters(status, game)
   - TournamentRepository::countAll()
   - PredictionRepository::findByUser(user)

Deliverable:
- Routes return correct DB-backed data

### Phase C — Twig UI
1. base layout: navbar + footer
2. home page
3. tournament index cards + filters
4. tournament show page
5. games list
6. prediction pages (new + index)

Deliverable:
- Pages render clean, responsive, consistent

### Phase D — Admin CRUD
Option 1 (default): Symfony Maker CRUD (Twig-based)
- `php bin/console make:crud Game`
- `php bin/console make:crud Tournament`
- `php bin/console make:crud Prediction`
Then:
- move routes under `/admin/...` prefix (or create admin controllers under namespace + route prefix)

Deliverable:
- Admin can create/edit/delete safely, secured by ROLE_ADMIN

### Phase E — Finalization
- Manual test user stories
- Fix N+1 issues (joins, eager load)
- README screenshots (optional)
- Entity UML (optional)

---

## 6) Team Git Workflow (important)
### Branch naming
- `feature/games-tournaments-<short>`
Examples:
- `feature/games-entity`
- `feature/tournament-pages`
- `feature/predictions`

### Commits (small and readable)
- One logical change per commit
- Message format:
  - `Add Game entity + migration`
  - `Implement tournament list filters`
  - `Secure admin routes`

### Pull request checklist (before merge)
- [ ] `php bin/console doctrine:migrations:migrate` works on clean DB
- [ ] No schema changes without migration files committed
- [ ] Public routes work without login
- [ ] Admin routes blocked without ROLE_ADMIN
- [ ] Prediction routes blocked without ROLE_USER
- [ ] No controller route collisions (unique paths)
- [ ] No N+1 obvious issues on list pages

### Migration coordination rule (to avoid conflicts)
- Always pull latest main before generating migrations:
  - `git checkout main && git pull`
  - `git checkout feature/...`
- If two PRs add migrations, merge order matters.
- If conflict happens:
  - rebase branch on main
  - regenerate migration only if necessary
  - never manually edit DB schema outside migrations

---

## 7) Antigravity Usage (how we use AI safely)
Antigravity works best with “step prompts”.

Prompt template:
"Implement ONLY the next step. Keep changes minimal. List files touched. Provide local verification steps."

After each step:
- run verification
- commit
- push

---

## 8) Useful Commands
```bash
# server
symfony serve -d

# DB
php bin/console doctrine:database:create

# entities + migrations
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# controllers + CRUD
php bin/console make:controller
php bin/console make:crud
php bin/console make:form
```
