# Brewlang Coffee Ordering & Management System

Brewlang is a Laravel-based coffee shop ordering and operations platform. It combines a public ordering experience with internal staff and owner tools for order handling, menu management, expense tracking, reporting, and staff account administration.

The application is designed to run primarily through Docker Compose and uses Mailpit for local email inspection.

## Overview

The system is split into three operational areas:

- Public storefront for browsing the menu, managing a session-based cart, and placing orders
- Staff portal for monitoring the order queue, progressing order status, and managing menu items
- Owner portal for dashboards, read-only order oversight, expenses, reports, and staff account management

## Core Features

### Public Ordering

- Browse active menu items by category
- Add items to cart with quantity and per-item notes
- Checkout with customer details and automatic order code generation
- Order confirmation email delivery via Mailpit in development
- Checkout success page driven by session state

### Staff Operations

- Staff dashboard with queue-oriented metrics
- Order queue listing and detail view
- Valid forward-only status transitions:
  `unpaid -> paid -> in_progress -> all_done`
- Menu management for creating, editing, and activating/deactivating items

### Owner Operations

- Owner dashboard for business overview
- Read-only order listing and detail pages
- Expense recording
- Staff account creation and activation toggling
- Date-filtered financial reporting

## Tech Stack

- Backend: Laravel 13, PHP 8.4
- Frontend: Blade, Tailwind CSS v4, Flowbite, Vite
- Database: MySQL 8.0
- Mail: Mailpit
- Testing: PHPUnit with SQLite test database
- Runtime: Docker Compose

## Architecture Notes

- Authentication uses Laravel session auth with a manually implemented login flow
- Cart data is stored in session under the `cart` key
- Checkout logic is centralized in `CheckoutService`
- Order status transition rules are centralized in `OrderStatusService`
- Public menu recommendations and cart behavior are handled through dedicated services

## Default URLs

After the stack is running, the main endpoints are:

- App: `http://localhost:8000`
- Mailpit UI: `http://localhost:8025`
- Vite dev server: `http://localhost:5173` if you explicitly run Vite

## Default Accounts

Seeded credentials:

| Role | Email | Password |
|---|---|---|
| Owner | `owner@brewlang.test` | `password` |
| Staff | `staff1@brewlang.test` | `password` |
| Staff | `staff2@brewlang.test` | `password` |

## Local Development

### Prerequisites

- Docker
- Docker Compose

### Start the Application

Build and start the containers:

```bash
docker compose up -d --build
```

The `app` container entrypoint will:

- install Composer dependencies
- copy `.env.docker` into `.env` if needed
- generate `APP_KEY` when missing
- run migrations
- seed the database
- create the storage symlink
- clear cached config, routes, and views
- start Laravel on port `8000`

### Stop the Application

```bash
docker compose down
```

### Useful Docker Commands

Open a shell inside the app container:

```bash
docker compose exec app sh
```

Re-run migrations and seeders:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Inspect queued mail in Mailpit:

```text
http://localhost:8025
```

## Frontend Assets

The application uses Vite for asset bundling.

For active frontend development, run Vite explicitly:

```bash
docker compose exec app npm install
docker compose exec app npm run dev -- --host 0.0.0.0 --port 5173
```

For a production-style local build:

```bash
docker compose exec app npm install
docker compose exec app npm run build
```

## Testing

Run the automated suite from the app container:

```bash
docker compose exec app php artisan test
```

Current test coverage includes:

- authentication and role access
- cart JSON endpoints
- checkout flow
- owner expense management
- owner staff account management
- public menu browsing
- report filtering
- staff menu management
- staff order status transitions

The test harness is configured to use SQLite so the suite is isolated from the development MySQL database.

## Project Structure

Key directories:

```text
app/
  Http/Controllers/
  Http/Requests/
  Mail/
  Models/
  Services/
database/
  factories/
  migrations/
  seeders/
resources/views/
  auth/
  components/
  emails/
  layouts/
  owner/
  public/
  staff/
routes/
  web.php
docker/
  php/
```

## Important Business Rules

- Only active menu items are shown publicly
- Cart is session-based and does not require authentication
- Order codes use the format `BRW-XXXXXX`
- Order status can only move forward according to the defined flow
- Owner accounts cannot be deactivated
- Checkout success page depends on `session('order_code')`

## Email Behavior

Development email is routed to Mailpit.

Two mail flows are implemented:

- order confirmation after checkout
- order status update notification after valid status transition

Mail sending failures are logged so the order lifecycle is not blocked by SMTP issues.

## Deployment Notes

Before production deployment, review at least the following:

- replace development mail settings
- set a production `APP_KEY`
- set production database credentials
- build frontend assets with `npm run build`
- ensure `public/storage` is linked
- disable debug mode
- configure proper web server and process supervision instead of `php artisan serve`

This repository is currently optimized first for local containerized development and functional verification.

## Quality Status

At the time of this update:

- primary public, staff, and owner flows are implemented
- feature and unit test suite passes
- Blade component structure has been aligned with the project TDD

## License

This project inherits the Laravel application license context unless your organization defines a separate internal license or usage policy.
