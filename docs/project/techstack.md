# Technology Stack

## Backend

### Core Framework
| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | ^8.2 | Server-side scripting |
| **Laravel** | 12.x | Web application framework |

### Laravel Packages
| Package | Version | Purpose |
|---------|---------|---------|
| `laravel/framework` | ^12.0 | Core framework |
| `laravel/tinker` | ^2.10.1 | REPL for Laravel |
| `blade-ui-kit/blade-heroicons` | ^2.7 | Heroicons for Blade |
| `blade-ui-kit/blade-icons` | ^1.9 | Icon components for Blade |

### Development Dependencies
| Package | Version | Purpose |
|---------|---------|---------|
| `fakerphp/faker` | ^1.23 | Fake data generation |
| `laravel/pail` | ^1.2.2 | Log viewer |
| `laravel/pint` | ^1.24 | PHP code style fixer |
| `laravel/sail` | ^1.41 | Docker development environment |
| `mockery/mockery` | ^1.6 | Mocking framework |
| `nunomaduro/collision` | ^8.6 | Error reporting |
| `phpunit/phpunit` | ^11.5.3 | Testing framework |

---

## Frontend

### Build Tools
| Technology | Version | Purpose |
|------------|---------|---------|
| **Vite** | ^7.0.7 | Frontend build tool |
| **Laravel Vite Plugin** | ^2.0.0 | Vite integration for Laravel |

### CSS Framework
| Technology | Version | Purpose |
|------------|---------|---------|
| **Tailwind CSS** | ^4.0.0 | Utility-first CSS framework |
| `@tailwindcss/vite` | ^4.0.0 | Tailwind Vite plugin |

### JavaScript
| Package | Version | Purpose |
|---------|---------|---------|
| **axios** | ^1.11.0 | HTTP client |
| **concurrently** | ^9.0.1 | Run multiple commands |

---

## Database

| Database | Usage |
|----------|-------|
| **SQLite** | Default/Development |
| **MySQL/MariaDB** | Production (via DB_HOST config) |

### ORM
- **Eloquent ORM** - Laravel's built-in ORM for database operations

---

## Development Tools

| Tool | Purpose |
|------|---------|
| **Composer** | PHP dependency manager |
| **NPM** | Node.js package manager |
| **PHPUnit** | Unit and integration testing |
| **Laravel Pail** | Real-time log viewing |
| **Laravel Pint** | PHP code formatting |
| **Laravel Sail** | Docker-based local development |

---

## Server Requirements

| Requirement | Version |
|-------------|---------|
| PHP | >= 8.2 |
| Web Server | Apache/Nginx/PHP built-in |
| Database | SQLite/MySQL/PostgreSQL |
| Node.js | Latest LTS (for Vite) |
| Composer | Latest stable |
| NPM | Latest stable |

---

## Architecture Pattern

**MVC (Model-View-Controller)**
- **Models:** `app/Models/` - 14 Eloquent models
- **Views:** `resources/views/` - Blade templates
- **Controllers:** `app/Http/Controllers/` - Request handlers

---

## Key Laravel Features Used

| Feature | Configuration |
|---------|---------------|
| **Authentication** | Configured in `config/auth.php` |
| **Session** | Database-backed sessions |
| **Cache** | Database-backed cache |
| **Queue** | Database-backed queue system |
| **Logging** | Stack driver (single channel) |
| **Mail** | Log driver (development) |
| **File Storage** | Local disk |
| **Broadcasting** | Log driver |

---

## File Structure Conventions

- **PSR-4 Autoloading:** `App\` namespace mapped to `app/` directory
- **Factories:** `Database\Factories\` → `database/factories/`
- **Seeders:** `Database\Seeders\` → `database/seeders/`
- **Tests:** `Tests\` → `tests/`

---

## File Generated
**Date:** 2026-04-02  
**Analyzed By:** Qwen Code
