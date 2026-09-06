# 🛒 Grocery Delivery Mobile App - Backend API

A comprehensive Laravel-based RESTful API backend for a modern grocery and meal delivery mobile application. Built with a robust **Domain-Driven Design (DDD)** architecture, this API provides complete e-commerce functionality including user authentication, product management, shopping cart, favorites, AI-powered chatbot, payment processing, and delivery address management.

## ✨ Features & Architecture

### 🏗️ Domain-Driven Design (DDD)
The project is organized into modular domains, ensuring high maintainability and scalability:
- **User Domain**: Profile, Addresses, Favorites.
- **Auth Domain**: Registration, Login, OTP, Password Management.
- **Catalog Domain**: Categories, Subcategories, Meals, Daily Deals.
- **Cart Domain**: Cart management and validation.
- **Order Domain**: Checkout, History, Tracking.
- **Support Domain**: Chatbot, FAQs, Contact.
- **System Domain**: Settings, Static Pages, Notifications.

### 🔐 Authentication & Authorization
- **Laravel Sanctum** - Secure API token-based authentication.
- **Spatie Laravel Permission** - Advanced Role-Based Access Control (RBAC) and Policies.
- **OTP Verification** - Secure password reset via email or phone.

### 📖 API Documentation (Scramble)
- Automated, always up-to-date API documentation powered by **Scramble**.
- Interactive UI to test requests and view responses without needing Postman.
- Accessible at `/docs/api`.

### 🍽️ Product Management & Discovery
- **Categories & Subcategories** - Hierarchical catalog system.
- **Meals/Products** - Comprehensive catalog with pricing, stock, images, and reviews.
- **Advanced Search & Filters** - Full-text search and filtering.

### 🛒 Shopping Cart & Orders
- **Cart Management** - Add, update, remove items, with automatic calculations.
- **Validation** - Stock and expiry checking before checkout.
- **Stripe Integration** - Secure payment processing and card management.

### 🤖 AI Chatbot
- **Google Gemini Integration** - AI-powered customer support and contextual meal recommendations.

## 🛠️ Technology Stack

- **PHP 8.2+**
- **Laravel 10/11**
- **MySQL**
- **Spatie Laravel Permission** (Authorization)
- **Scramble** (API Documentation)
- **Laravel Sanctum** (Authentication)
- **Google Gemini AI** (Chatbot)
- **Stripe** (Payments)

## 🚀 Installation & Setup

1. Clone the repository:
```bash
git clone <repository-url>
cd grocery
```

2. Install dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your `.env` variables (Database, SMTP, Gemini API Key, Stripe Keys).

5. Run migrations and seeders:
```bash
php artisan migrate --seed
```

6. Start the server:
```bash
php artisan serve
```

## 📚 API Documentation
You can explore the interactive API documentation and test endpoints directly via **Scramble**:
```text
http://localhost:8000/docs/api
```
*(No need to maintain separate Markdown or Postman files!)*

## 🧪 Testing
The project includes a comprehensive feature testing suite covering all API endpoints and domains (Auth, Catalog, Cart, User, Address, Order).
Run tests with:
```bash
php artisan test
```
*Currently, all API endpoints are fully covered with 100% passing tests.*

## License

This project is proprietary software for HumaVolve grocery delivery application.
