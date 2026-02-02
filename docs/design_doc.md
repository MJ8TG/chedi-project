# Design Document
## ArenaMind — Games & Tournaments Module

### 1. Architecture
- **Backend:** Symfony 6.4 (MVC Pattern).
- **Database:** MySQL 8+.
- **Frontend:** Twig Templates + Tailwind CSS (via AssetMapper or Webpack).
- **ORM:** Doctrine.

### 2. Database Schema
#### Game
- `id`: INT (Auto Increment)
- `name`: VARCHAR(255) (Unique)
- `description`: TEXT
- `genre`: VARCHAR(255)
- `image`: VARCHAR(255)
- `created_at`: DATETIME_IMMUTABLE

#### Tournament
- `id`: INT (Auto Increment)
- `game_id`: INT (Foreign Key -> Game)
- `title`: VARCHAR(255)
- `description`: TEXT
- `start_date`: DATETIME
- `end_date`: DATETIME
- `max_teams`: INT
- `status`: VARCHAR(20) (Enum: UPCOMING, ONGOING, FINISHED)
- `created_at`: DATETIME_IMMUTABLE

#### Prediction
- `id`: INT
- `tournament_id`: INT (FK -> Tournament)
- `user_id`: INT (FK -> User) [Assuming User exists]
- `predicted_winner`: VARCHAR(255) (Or Team ID)
- `created_at`: DATETIME_IMMUTABLE

### 3. API / Routes
- Public: `/`, `/games`, `/tournaments`, `/tournaments/{id}`
- User: `/predictions`, `/predictions/new/{id}`
- Admin: `/admin/games`, `/admin/tournaments`, `/admin/predictions`

### 4. UI/UX
- **Theme:** Dark mode esports aesthetic.
- **Components:** Game Cards, Tournament List with Filters, Prediction Form.
