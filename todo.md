# ArenaMind - Games & Tournaments Module Implementation Plan

## 0. Project Bootstrap (Team Repo or New Symfony App)
- **Goal:** Ensure this repo contains a working Symfony 6.4 app before any DB/migrations.
- **Subtasks:**
  - [x] If team repo exists: `git clone <repo>`, checkout `feature/games-tournaments-module`
  - [x] Else create app: `composer create-project symfony/skeleton:"6.4.*" .` then add: `composer require webapp orm twig maker security`
- **Files to touch:** `composer.json`, `symfony.lock`, `config/*`, `src/*`
- **Verification:** `php bin/console -V` runs successfully.
- **Est. Complexity:** M
- **Commit:** `Bootstrap Symfony project`

## 1. Database & Environment Setup
- **Goal:** Get the database running locally and schema initialized.
- **Subtasks:**
  - [x] Ensure MySQL service is running (Port 3306).
  - [x] Configure `DATABASE_URL` in `.env.local` (override default `.env`).
  - [x] Create database: `php bin/console doctrine:database:create`.
  - [x] Generate migration for User, Game, Tournament, Prediction: `php bin/console doctrine:migrations:diff`.
  - [x] Execute migration: `php bin/console doctrine:migrations:migrate`.
- **Files to touch:** `.env.local`, `migrations/*`
- **Verification:**
  - Run `php bin/console dbal:run-sql "SHOW TABLES"` -> Should list `user`, `game`, `tournament`, `prediction`.
- **Est. Complexity:** S
- **Commit:** `Setup DB and initial migrations`

## 2. Data Fixtures (Dummy Data)
- **Goal:** Populate DB with test data to verify UI.
- **Subtasks:**
  - [x] Install fixtures bundle: `composer require --dev orm-fixtures`.
  - [x] Create `AppFixtures` to load:
    - 5 Games (CS:GO, LoL, etc.).
    - 10 Tournaments (Upcoming, Ongoing, Finished).
    - 2 Users (admin, regular).
  - [x] Run fixtures: `php bin/console doctrine:fixtures:load`.
- **Files to touch:** `src/DataFixtures/AppFixtures.php`
- **Verification:**
  - Run `php bin/console dbal:run-sql "SELECT count(*) FROM game"` -> Should be > 0.
- **Est. Complexity:** S
- **Commit:** `Add fixtures for Games and Tournaments`

## 3. Base Layout & Assets (Bootstrap 5)
- **Goal:** Create the common shell for the application using Bootstrap 5 (CDN).
- **Subtasks:**
  - [ ] Setup `templates/base.html.twig`.
  - [ ] Add Bootstrap 5 CDN links (CSS in head, JS in body).
  - [ ] Create Navbar (Home, Games, Tournaments, Login).
  - [ ] Create Footer.
  - [ ] Ensure basic dark mode styling (custom CSS if needed or Bootstrap dark theme).
- **Files to touch:** `templates/base.html.twig`, `assets/app.css`
- **Verification:**
  - Open `/` in browser -> Should see Navbar + Footer with Bootstrap styles.
- **Est. Complexity:** M
- **Commit:** `Setup base layout with Bootstrap 5`

## 4. Public Pages: Home & Games
- **Goal:** Display landing page and list of games.
- **Subtasks:**
  - [ ] `HomeController`: Fetch Stats (total tournaments) + Featured Tournaments.
  - [ ] Template `home/index.html.twig`: Hero section + Stats.
  - [ ] `GameController`: List all games.
  - [ ] Template `game/index.html.twig`: Grid of Game cards.
- **Files to touch:** `src/Controller/HomeController.php`, `templates/home/index.html.twig`, `src/Controller/GameController.php`, `templates/game/index.html.twig`
- **Verification:**
  - `/` shows hero + data.
  - `/games` lists all games from fixtures.
- **Est. Complexity:** M
- **Commit:** `Implement Home and Game list pages`

## 5. Public Pages: Tournaments (List & Details)
- **Goal:** Browse and filter tournaments.
- **Subtasks:**
  - [ ] `TournamentController::index`: Handle `?status=UPCOMING` and `?game=ID` filters.
  - [ ] Template `tournament/index.html.twig`: Sidebar/Top filter + List of cards.
  - [ ] `TournamentController::show`: Detail view (Dates, Max Teams, Description).
  - [ ] Template `tournament/show.html.twig`: Full info + "Predict" button (if logged in).
- **Files to touch:** `src/Controller/TournamentController.php`, `templates/tournament/index.html.twig`, `templates/tournament/show.html.twig`
- **Verification:**
  - `/tournaments` shows list.
  - `/tournaments?status=UPCOMING` filters list.
  - Clicking a tournament goes to detail page.
- **Est. Complexity:** M
- **Commit:** `Implement Tournament browse and details`

## 6. User Authentication & Permissions
- **Goal:** Allow users to log in (required for predictions).
- **Subtasks:**
  - [x] Generate Login form: `php bin/console make:auth`.
  - [x] Create Registration form: `php bin/console make:registration-form`.
  - [x] Verify `ROLE_USER` hierarchy in `security.yaml`.
- **Files to touch:** `src/Security/*`, `templates/security/*`, `src/Controller/RegistrationController.php`
- **Verification:**
  - Can register a new user.
  - Can log in.
- **Est. Complexity:** M
- **Commit:** `Setup Auth (Login/Register)`

## 7. User Feature: Predictions (Logic)
- [x] Create `Prediction` entity (if not exists).
- [x] Create `PredictionController` (`new`, `index`).
- [x] Create templates (`new.html.twig`, `index.html.twig`).
- **Files to touch:** `src/Controller/PredictionController.php`, `src/Form/PredictionType.php`, `templates/prediction/*`
- **Verification:**
  - Logged-in user: Can verify prediction on random tournament.
  - `/predictions` shows the record.
- **Est. Complexity:** L

## 8. Admin CRUD System
- **Goal:** Back-office for content management.
- **Subtasks:**
  - [ ] Create `AdminController` namespace/folder.
  - [ ] Generate CRUD for `Game`, `Tournament`, `Prediction`.
  - [ ] Secure routes: `/admin` => `ROLE_ADMIN`.
  - [ ] Customize Index views for tables (Bootstrapped or Tailwind admin layout).
- **Files to touch:** `src/Controller/Admin/*`, `templates/admin/*`, `config/packages/security.yaml`
- **Verification:**
  - `/admin/game` -> 403 for normal user.
  - Login as Admin -> Can create Game/Tournament.
- **Est. Complexity:** L
- **Commit:** `Implement Admin CRUD`

## 9. Final Steps & Polish
- **Goal:** Optimization and Translation keys.
- **Subtasks:**
  - [ ] Add `translator` configuration (fr/ar).
  - [ ] Check N+1 queries (Profiler) on list pages -> Use `join` in repositories.
  - [ ] Add validation (e.g. EndDate > StartDate).
- **Files to touch:** `src/Repository/*`, `config/packages/translation.yaml`
- **Verification:**
  - Profiler showing < 10 queries on list pages.
  - Forms show error on invalid dates.
- **Est. Complexity:** S
- **Commit:** `Final polish: N+1 fixes and validation`
