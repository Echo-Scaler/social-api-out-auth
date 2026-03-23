# 🚀 Echo-Scaler Social Dashboard

A premium, enterprise-grade social media analytics and management platform built with **Laravel 11**, **Tailwind CSS**, and **Alpine.js**. This project demonstrates advanced architectural patterns, real-time API integrations, and a sophisticated user interface.

## 🛠️ Key Features

- **Social Intelligence Center**: Real-time monitoring of engagement metrics across multiple subreddits.
- **Social Hub (Grid View)**: A modern, card-based interface for managing and visualizing social content.
- **API Hub**: An interactive, no-reload management panel powered by a custom RESTful API (V1).
- **Post Detail Engine**: High-impact visualization of individual post metadata and engagement trends.
- **Advanced Architecture**: Implements Service-Repository patterns, API versioning, and background synchronization commands.

---

## 🏗️ Technical Architecture

This project is built for scalability and maintainability:

- **Service Layer**: Business logic is abstracted into dedicated Services (e.g., `RedditApiService`, `SocialPostService`).
- **Repository Pattern**: Data access is decoupled from models using `SocialPostRepository`.
- **API Versioning**: All endpoints follow the `/api/v1/` standard.
- **Background Processing**: Heavy data synchronization is handled via Artisan commands.

---

## 🚀 Step-by-Step Installation

Follow these steps to get your professional environment up and running:

### 1. Prerequisites
Ensure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite or MySQL

### 2. Clone and Install
```bash
git clone https://github.com/Echo-Scaler/social-api-out-auth.git
cd social-dashboard
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
*Make sure to configure your database settings in `.env`.*

### 4. Database Setup
```bash
php artisan migrate --seed
```

### 5. Compile Assets
```bash
npm run build
# OR for development
npm run dev
```

### 6. Start the Application
```bash
php artisan serve
```
Visit `http://localhost:8000` to begin.

---

## 🛰️ Using the System

### Background Data Sync
To fetch the latest posts from Reddit without affecting the UI performance, use the professional sync command:
```bash
php artisan social:sync {subreddit} --limit=50
```
*Example: `php artisan social:sync webdev --limit=20`*

### API Endpoints (V1)
Access the structured data via:
- `GET /api/v1/social-posts`
- `GET /api/v1/categories`

### API Hub
Navigate to the **API Hub** in the sidebar to manage Categories using the real-time interactive dashboard.

---

## ⚖️ License
The Echo-Scaler Social Dashboard is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
