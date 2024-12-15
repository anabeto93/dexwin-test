# Todo API

A modern, RESTful API for managing todos built with Laravel 11. Features include filtering, sorting, and comprehensive API documentation.

> [!NOTE]
> This API uses modern Laravel features and follows REST best practices. Full API documentation is available at the base route or `/api/documentation`.

## Quick Start

> [!IMPORTANT]
> Before starting, make sure you have PHP 8.2+ and Composer installed on your system.

1. Set up the database:
```bash
php artisan migrate:refresh --seed
```

2. Start the development server:
```bash
php artisan serve --port 2024
```

> [!TIP]
> The API documentation is automatically available at [http://localhost:2024/api/documentation](http://localhost:2024/api/documentation)

## Features

- Modern Laravel 11.x
- Interactive API Documentation (Redocly)
- Advanced filtering and sorting
- Comprehensive validation
- Clean Architecture with DTOs and Service Layer

> [!WARNING]
> This is a development server. For production, please ensure proper security measures are in place.
