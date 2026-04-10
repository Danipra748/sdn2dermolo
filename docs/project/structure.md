# Project Structure Analysis

## Overview
**Project Name:** SD Negeri 2 Dermolo  
**Framework:** Laravel 12  
**PHP Version:** ^8.2  
**Project Type:** School Management System / Educational Website

---

## Directory Structure

```
sdnegeri2dermolo/
├── app/                          # Application core
│   ├── Http/
│   │   └── Controllers/          # Request handlers
│   ├── Models/                   # Eloquent models (14 models)
│   ├── Providers/                # Service providers
│   └── Support/                  # Support classes
├── bootstrap/                    # Framework bootstrap files
├── config/                       # Configuration files
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database schema definitions
│   └── seeders/                  # Database seeders
├── docs/
│   └── project/                  # Project documentation
├── public/                       # Web root
│   ├── index.php                 # Entry point
│   ├── .htaccess
│   ├── favicon.ico
│   └── robots.txt
├── resources/
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript files
│   └── views/                    # Blade templates
├── routes/
│   ├── web.php                   # Web routes
│   ├── console.php               # Console routes
│   └── migration.php             # Migration routes
├── tests/
│   ├── Feature/                  # Feature tests
│   ├── Unit/                     # Unit tests
│   └── TestCase.php
├── storage/                      # Logs, cache, uploads
├── vendor/                       # Composer dependencies
└── node_modules/                 # NPM dependencies
```

---

## Application Models

The project has **14 Eloquent models** indicating a school management system:

| Model | Purpose |
|-------|---------|
| `Admin` | Administrator users |
| `User` | General users |
| `SchoolProfile` | School profile information |
| `Guru` | Teacher data |
| `Fasilitas` | School facilities |
| `Program` | School programs |
| `ProgramPhoto` | Program photos/gallery |
| `Category` | Content categories |
| `Article` | Articles/news |
| `ArticleView` | Article view tracking |
| `Prestasi` | Achievements/accomplishments |
| `ContactMessage` | Contact form messages |
| `HomepageSection` | Homepage content sections |
| `SiteSetting` | Site configuration settings |

---

## Key Features (Inferred from Models)

1. **User Management** - Admin and User roles
2. **School Profile** - School information management
3. **Teacher Management** - Guru (teacher) data
4. **Content Management** - Articles, categories
5. **Program Management** - School programs with photo gallery
6. **Facility Management** - School facilities
7. **Achievement Tracking** - Prestasi (achievements)
8. **Contact System** - Contact messages
9. **Homepage Customization** - Dynamic homepage sections
10. **Site Configuration** - Centralized settings
11. **Analytics** - Article view tracking

---

## Configuration Files

| File | Purpose |
|------|---------|
| `app.php` | Application settings, name, locale, timezone |
| `auth.php` | Authentication, guards, passwords |
| `database.php` | Database connections, migrations |
| `cache.php` | Cache drivers and stores |
| `session.php` | Session configuration |
| `queue.php` | Queue job processing |
| `mail.php` | Email/mail configuration |
| `logging.php` | Log channels and levels |
| `filesystems.php` | File storage disks |
| `services.php` | Third-party API services |

---

## Custom Scripts (composer.json)

| Script | Command |
|--------|---------|
| `composer setup` | Full setup (install, env, migrate, build) |
| `composer dev` | Development mode with hot reload |
| `composer test` | Run PHPUnit tests |

---

## Database Configuration

- **Default:** SQLite (development)
- **Session Driver:** database
- **Cache Driver:** database
- **Queue Driver:** database

---

## File Generated
**Date:** 2026-04-02  
**Analyzed By:** Qwen Code
