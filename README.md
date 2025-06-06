# Gondor Chic API

A Laravel-based API application for "Magic VenteStock" - the e-commerce platform for Minas Tirith's magical products. Features inventory management, order processing, and delivery tracking for fairy dust, mithril shirts, and other enchanted items sold through Gondor's retail network.

## 📋 Requirements

-   🐘 PHP 8.1 or higher
-   📦 Composer
-   ⚡ PM2 (for process management) and [swoole](https://openswoole.com/docs/get-started/installation) in production

---

## 💻 Development Guide

## 🛠️ Setup

1. **📥 Clone the repository**

    ```bash
    git clone <repository-url>
    cd Galanthir-api
    ```

2. **📦 Install dependencies**

    ```bash
    composer install
    ```

3. **📝 Environment configuration**

    ```bash
    cp .env.example .env
    # Edit .env file with your local database and other configurations
    ```

4. **🔑 Generate application key**

    ```bash
    php artisan key:generate
    ```

<!-- 5. **🗄️ Database setup**

    ```bash
    php artisan migrate
    ```

6. **🌱 Seed database (optional)**
    ```bash
    php artisan db:seed
    ``` -->

## 🚀 Running the Application

### Development Server

```bash
php artisan serve --port=8000
# or with Octane for better performance
php artisan octane:start
```

### 🧪 Testing

```bash
# Run all tests
php artisan test
```

---

## 🚀 Deployment Guide

1. **📝 Environment Setup**

    ```bash
    # Rename .env.prod.example to .env and fill in the required environment variables
    cp .env.prod.example .env
    ```

2. **📥 Install Dependencies**

    ```bash
    composer install --no-dev
    ```

3. **🔑 Generate Application Key**

    ```bash
    php artisan key:generate
    ```

4. **▶️ Start the Application**
    ```bash
    pm2 start "php artisan octane:start --port=8000" --name gondor-chic
    ```

---

## 🔧 Useful Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Generate IDE helper files
php artisan ide-helper:generate

# Check code style
./vendor/bin/pint

# Run static analysis
./vendor/bin/phpstan analyse

# Generate Swagger API documentation
php artisan l5-swagger:generate
```

---

## 📖 API Documentation

This project includes comprehensive API documentation using Swagger/OpenAPI 3.0.

### 🌐 Accessing the Documentation

Once the application is running, you can access the interactive API documentation at:

-   **Development:** `http://localhost:8000
-   **Production:** `http://gondor-chic.mendrika.dev

### 🔄 Regenerating Documentation

After making changes to API annotations, regenerate the documentation:

```bash
php artisan l5-swagger:generate
```

---

## 📁 Project Structure

```
├── app/                    # Application core files
│   ├── Http/Controllers/   # API controllers
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── database/              # Database migrations, factories, and seeders
├── routes/                # API and web routes
└── tests/                 # PHPUnit tests
```
