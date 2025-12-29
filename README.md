# Laravel E-Commerce Project

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Filament-3.x-FBBF24?style=for-the-badge" alt="Filament">
  <img src="https://img.shields.io/badge/PostgreSQL-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Status-In%20Development-orange?style=for-the-badge" alt="Status">
</p>

> ⚠️ **This project is actively under development.** Features and documentation may change frequently.

## Overview

A modern, full-featured e-commerce platform built with Laravel. The application provides a seamless shopping experience for customers and a powerful admin panel for store management.

## Features

### Customer Features
- 🛒 **Shopping Cart** - Add products with variations, apply coupons
- ❤️ **Wishlist/Favorites** - Save products for later
- 🔍 **Product Filtering** - Filter by price, category, attributes
- 📱 **Responsive Design** - Optimized for all devices
- 💳 **Secure Payments** - Integrated with Iyzico payment gateway (3D Secure support)
- 📦 **Order Tracking** - View order history and status
- 👤 **User Accounts** - Profile management, address book, order history

### Product Features
- 📸 **Media Library** - Multiple product images with zoom functionality
- 🎨 **Product Variations** - Support for color, size, and custom attributes
- 🏷️ **Dynamic Pricing** - Discount prices, sale badges
- 📊 **Stock Management** - Per-variation inventory tracking
- ⭐ **Product Badges** - New, Best Seller, Featured labels

### Admin Panel (Filament)
- 📊 **Dashboard** - Sales analytics and insights
- 📦 **Product Management** - Simple and variable products
- 📁 **Category Management** - Hierarchical categories
- 🎫 **Coupon System** - Percentage and fixed discounts
- 📋 **Order Management** - Process and track orders
- 👥 **Customer Management** - User accounts and roles
- 🛡️ **Role-Based Access** - Powered by Filament Shield

## Tech Stack

### Backend
- **Framework:** Laravel 12.x
- **Admin Panel:** Filament 3.x
- **Database:** PostgreSQL
- **Cache & Queue:** Redis (via Predis)
- **Queue Monitoring:** Laravel Horizon

### Frontend
- **Template Engine:** Blade
- **CSS Framework:** Bootstrap 5
- **JavaScript:** jQuery, Axios
- **UI Components:** Swiper, PhotoSwipe

### Key Packages
- `spatie/laravel-media-library` - Media management
- `spatie/laravel-sluggable` - URL slug generation
- `iyzico/iyzipay-php` - Payment processing
- `multicaret/laravel-acquaintances` - Favorites/Wishlist
- `tucker-eric/eloquentfilter` - Advanced filtering
- `bezhansalleh/filament-shield` - Role management

## Requirements

- PHP 8.2 or higher
- PostgreSQL 14+
- Redis
- Node.js 18+ & npm
- Composer

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/schatsu/Laravel-Ecommerce-Project.git
   cd Laravel-Ecommerce-Project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   REDIS_HOST=127.0.0.1
   REDIS_PASSWORD=null
   REDIS_PORT=6379

   # Iyzico Payment
   IYZICO_API_KEY=your_api_key
   IYZICO_SECRET_KEY=your_secret_key
   IYZICO_BASE_URL=https://sandbox-api.iyzipay.com
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   composer dev
   ```
   This command starts the Laravel server, queue worker, log tail, and Vite dev server concurrently.

## Admin Access

After seeding, you can access the admin panel at `/admin` with:
- **Email:** admin@admin.com
- **Password:** password

## Project Structure

```
├── app/
│   ├── Filament/          # Admin panel resources
│   ├── Http/Controllers/
│   │   ├── Front/         # Customer-facing controllers
│   │   └── ...
│   ├── Models/            # Eloquent models
│   └── ...
├── resources/
│   └── views/
│       ├── app/           # Customer frontend views
│       └── filament/      # Admin panel customizations
├── public/
│   └── front/             # Frontend assets (CSS, JS, images)
└── ...
```

## Development

### Running Tests
```bash
composer test
```

### Code Formatting
```bash
./vendor/bin/pint
```

### Debugging
Laravel Telescope is available at `/telescope` in development.

## Roadmap

- [ ] Product reviews and ratings
- [ ] Email notifications
- [ ] Social login integration

## Contributing

This project is currently in active development. Contribution guidelines will be added once the project reaches a stable release.

## License

This project is proprietary software. All rights reserved.

---

<p align="center">
  <strong>Built with ❤️ using Laravel</strong>
</p>
