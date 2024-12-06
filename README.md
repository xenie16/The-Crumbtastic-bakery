# Crumbtastic Bakery E-commerce System

An e-commerce system for a bakery, built with PHP following the MVC architecture pattern. The system allows customers to browse products, manage their shopping cart, and place orders for pickup, while providing administrative features for order and customer management.

## Prerequisites

```bash
composer require phpmailer/phpmailer
composer require league/oauth2-google
```

Copy `emailConfig.example.php` to `emailConfig.php` and configure your email settings.

## Features

**Customers:**

- Product browsing and cart management
- User accounts with order history
- Order placement with pickup scheduling
- Order cancellation (except same-day)

**Admin:**

- Customer and order management
- Product catalog control
- User status management

## Requirements

- PHP 8.0+
- MySQL 5.7+
- Configured email service (SMTP/OAuth2)

## Installation

1. Set up PHP environment
2. Clone repository
3. Create MySQL database
4. Configure database credentials

## Security

- Password hashing
- Session management
- SQL injection prevention
- Role-based access
- Input validation
