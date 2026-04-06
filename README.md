# ☕ Brewlang Coffee Management System

Welcome to the **Brewlang Coffee Management System**, a complete, robust, and beautifully designed full-stack web application built to streamline operations for modern coffee shops. This system integrates public ordering, staff queue management, and high-level owner financial tracking into a single unified platform.

---

## 🌟 Key Features

### 🛒 Public Storefront
- **Beautiful UI:** Premium, elegant, and responsive storefront using Flowbite and Tailwind CSS v4.
- **Dynamic Menu:** Browse products across multiple interactive categories.
- **Shopping Cart:** Add, remove, and manage quantities of items effortlessly.
- **Transactional Checkout:** Secure database transactions to guarantee order integrity, generating automated confirmation emails via Mailpit.

### 👨‍🍳 Staff Operations Portal
- **Order Queue Management:** Real-time dashboards to manage tickets through strict workflows (`Unpaid` ➔ `Paid` ➔ `In Progress` ➔ `Done`).
- **Menu Management (CRUD):** Efficiently upload product images, create categories, and publish new pastries or coffee blends.

### 📈 Owner / Admin Dashboard
- **Financial Analytics:** Gain actionable insights into Gross Income, Net Profit, and overall overhead.
- **Expense Tracking:** Dedicated modules for logging operational expenses.
- **Account Management:** Instantly onboard new staff or disable inactive accounts.
- **Exportable Reports:** Execute timeframe-specific financial filtering intended for accounting exports.

---

## 🛠 Tech Stack

- **Backend:** Laravel 13 (PHP)
- **Frontend / Styling:** Tailwind CSS v4, Flowbite, Blade Templates, Vite
- **Database:** MySQL
- **Email Testing:** Mailpit (configured for strict transactional emails)
- **Testing Engine:** PHPUnit (Factories + Feature testing suite via specific testing databases)

---

## 💻 Running the Project Locally (Docker Setup)

This project has been heavily optimized for containerized development to eliminate environment setup overhead. A fully automated **Docker** environment is included out of the box.

### Prerequisites
Make sure you have the following installed:
- [Docker](https://docs.docker.com/get-docker/) & Docker Compose

### Installation Guide

**1. Clone the Repository:**
```bash
git clone [<repository-url>](https://github.com/HIUNCY/brewlang-coffee)
cd brewlang
```

**2. Spin Up the Containers:**
Run the following command at the root of the project to build and start the ecosystem in the background:
```bash
docker compose up -d --build
```

**That's it! Everything else is automated.** 
Behind the scenes, the `entrypoint.sh` inside the container will automatically:
- Install PHP Dependencies (`composer install`)
- Configure environmental variables.
- Generate application keys.
- Run database migrations and seed the standard test accounts.
- Create storage links.
- Run `npm run dev` to serve Vite assets dynamically.
- Start the Laravel `artisan serve` application server.

*(Note: The initial setup may take 2-5 minutes as the Docker image downloads dependencies).*

### Accessing the System
Once the containers are successfully running, the applications are immediately accessible via:

- **Web Application:** [http://localhost:8000](http://localhost:8000)
- **Vite Hot-Reload Server:** `http://localhost:5173`
- **Mailpit (Email Interception UI):** `http://localhost:8025`

To safely stop the environment later, run:
```bash
docker compose down
```

---

## 🔐 Default Credentials

To explore the backend operations, use the seeded test accounts:

**Owner Access (Full analytics and staff management):**
- **Email:** `owner@brewlang.test`
- **Password:** `password`

**Staff Access (Order queues and menu catalog):**
- **Email:** `staff1@brewlang.test`
- **Password:** `password`
- **Email:** `staff2@brewlang.test`
- **Password:** `password`

---

## 🧪 Running Tests
This project includes a robust PHPUnit testing environment to ensure feature stability. To run the automated feature and unit tests:
```bash
php artisan test
```
*(Ensure `phpunit.xml` points to an isolated testing database if modifying testing variables).* 

---

Made with ❤️ for Brewlang.
