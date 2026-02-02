# Product Requirements Document (PRD)
## ArenaMind — Games & Tournaments Module

### 1. Introduction
ArenaMind is an esports platform designed to allow users to view games, participate in tournaments, and make predictions. This module focuses on the core functionality for managing games, tournaments, and user predictions.

### 2. Goals
- Provide a public-facing interface for browsing Games and Tournaments.
- Enable registered users to make predictions on tournament outcomes.
- Provide a robust Admin interface for managing content.
- Ensure localization support (French/Arabic) and correct currency (TND).

### 3. User Stories
- **Visitor:**
  - "I want to see a list of available games so I can find tournaments for my favorite game."
  - "I want to filter tournaments by status (upcoming, ongoing) to find active ones."
  - "I want to see details of a tournament (dates, max teams, etc.)."
- **User:**
  - "I want to predict the winner of a tournament."
  - "I want to see my past predictions and if I won."
- **Admin:**
  - "I want to add new Games and Tournaments to the platform."
  - "I want to manage user predictions."
  - "I want to mark a prediction as correct/incorrect."

### 4. Functional Requirements
- **Games:** List view, Admin CRUD.
- **Tournaments:** List view (filtered), Detail view, Admin CRUD.
- **Predictions:** Create prediction (User), List own predictions (User), Admin CRUD.

### 5. Non-Functional Requirements
- **Performance:** Pages should load quickly (N+1 query optimization).
- **Security:** Admin routes protected by `ROLE_ADMIN`. Prediction creation protected by `ROLE_USER`.
- **Localization:** UI supports French (primary) and Arabic.
- **Currency:** All monetary values in TND.
