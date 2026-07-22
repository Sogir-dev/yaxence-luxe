# 🖤 YAXENCE LUXE

A full-stack luxury perfume e-commerce platform built with Laravel — real product catalog, shopping cart, checkout with Paystack payments, customer accounts (including Google login), and a complete admin dashboard for managing products and orders.

## ✨ Features

### Storefront
- **Product catalog** across Men's, Women's, and Unisex collections, with a dedicated shop/filter page
- **Rich product detail pages** — top/heart/base scent notes, pricing, stock levels
- **Elegant fallback bottle art** — products without an uploaded photo render a hand-crafted, category-colored SVG bottle illustration instead of a broken image
- **Shopping cart** — add, update quantity, remove
- **Checkout flow** with order summary, shipping details, and **Paystack** payment integration
- **Customer accounts** — register/login, **Google OAuth login**, password reset via OTP, and an order history page

### Admin
- Secure admin login (separate from customer auth)
- Product management (create/edit/list)
- Order management and tracking

## 🛠 Built With

- [Laravel](https://laravel.com/) (PHP)
- MySQL
- Tailwind CSS
- Paystack (payments)
- Laravel Socialite (Google OAuth)

## 🚀 Running Locally

```bash
git clone https://github.com/Sogir-dev/yaxence-luxe.git
cd yaxence-luxe
composer install
cp .env.example .env
php artisan key:generate
# configure your database in .env, then:
php artisan migrate --seed
php artisan serve
```

---

Built by [Sogir-Dev Technologies](https://github.com/Sogir-dev).
