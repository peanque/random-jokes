# Random Jokes Viewer

## Features
API
- User Registration
- User Authentication
- Random Jokes Generator

WEB
- Login Page
- Registration Page
- Random Jokes Viewer Page

## Requirements
- PHP >= 8.2
- Composer
- Node.js >= 18.x and npm
- SQLite (default) or MySQL

## Technologies Used
- **Backend:** Laravel 12
- **Frontend:** Blade Templates, Tailwind CSS, Vite
- **Authentication:** Laravel Sanctum
- **Database:** SQLite (default)
- **Testing:** Pest PHP
- **API:** RESTful API with JSON responses

## External API

The application fetches jokes from the [Official Joke API](https://official-joke-api.appspot.com/jokes/programming/ten/). The service randomly selects 3 jokes from a pool of 10 programming jokes.

## Installation
### 1. Clone the repository

```bash
git clone <repository-url>
cd random-jokes
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Configure environment
Create a `.env` file from the example

```bash
cp .env.examp .env
```

```env
APP_NAME="Random Jokes"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SANCTUM_STATEFUL_DOMAINS=localhost:8000
SESSION_DOMAIN=localhost
```

### 4. Generate application key
```bash
php artisan key:generate
```

### 5. Create SQLite database file
```powershell
New-Item -Path database/database.sqlite -ItemType File
```

### 6. Run database migrations
```bash
php artisan migrate
```

### 7. Install Node.js dependencies
```bash
npm install
```

### 8. Build frontend assets
```bash
npm run dev
```

## Running the Application

### Development
**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Frontend Assets (if needed):**
```bash
npm run dev
```

The application will be available at `http://localhost:8000`

## Application Routes

### Web Routes
- `GET /` - Login page
- `GET /register` - Registration page
- `POST /login` - User login
- `POST /register` - User registration
- `GET /jokes` - Display random jokes (requires authentication)

### API Routes (v1)

- `POST /api/v1/register` - Register a new user
- `POST /api/v1/login` - Login and get authentication token
- `POST /api/v1/logout` - Logout (requires authentication)
- `GET /api/v1/random-jokes` - Get 3 random programming jokes (requires authentication)

### Run all tests
```bash
php artisan test
```