# Nizam Passport API

A Laravel package that streamlines the setup of Laravel Passport for API authentication.

## Features

-   Automatic installation of Laravel Passport
-   Scaffolding for API authentication controllers and routes
-   Configuration updates for Passport integration
-   User model updates for API token support
-   Cleaning up unnecessary files for API-only projects

## Installation

You can install the package via composer:

```bash
composer require nizam/passport-api
```

This command will:

Check for Laravel Passport installation and install it if not present
Install Passport API scaffolding
Add authentication controllers and requests
Update auth configuration
Append authentication routes
Add HasApiTokens trait to User model
Update API routes
Remove unnecessary scaffolding for API-only projects

What This Package Does

Passport Installation Check: Verifies if Laravel Passport is installed and offers to install it if not.
Scaffolding Installation: Adds necessary controllers, requests, and routes for API authentication.
Auth Configuration Update: Modifies the auth.php config file to include Passport driver for API authentication.
Route Updates: Appends new authentication routes and updates API routes.
User Model Update: Adds the HasApiTokens trait to the User model for API token support.
Environment Configuration: Updates the .env file with default URL configurations.
Cleanup: Removes unnecessary files and directories typically used in web applications but not needed for API-only projects.

Contributing
Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.
How to Contribute

Fork the repository
Create your feature branch (git checkout -b feature/AmazingFeature)
Commit your changes (git commit -m 'Add some AmazingFeature')
Push to the branch (git push origin feature/AmazingFeature)
Open a Pull Request

Usage
After installation, run the following command:
php artisan nizam:install-passport-api

# Nizam Passport API

Laravel Passport API authentication package similar to Laravel Breeze API.

## Installation

You can install the package via composer:

```bash
composer require nizam/passport-api
```

Usage
After installing the package, run the following command to set up the Passport API:

```bash
php artisan nizam:install-passport-api
```

This command will:

Install Laravel Passport if not already installed
Set up the necessary controllers and routes
Update your auth configuration

Requirements

PHP ^7.3|^8.0
Laravel ^9.0|^10.0|^11.0
Laravel Passport ^10.0|^11.0|^12.0

Credits

Nizam Omer

License
The MIT License (MIT). Please see License File for more information.

# Nizam Passport API

This package provides a simple API authentication setup using Laravel Passport for Laravel 11 applications.

## Features

    // "laravel/framework": "^8.0|^9.0|^10.0|^11.0"

-   Easy installation with a custom Artisan command
-   API routes for authentication (login, register, logout)
-   Password reset functionality
-   Configurable route prefix
-   Form request validation

## Requirements

-   PHP 8.2+
-   Laravel 11+
-   Laravel Passport 12+

## Installation

1. Install Laravel Passport and set up the initial configuration:

php artisan install:api --passport

This command will:

-   Install Laravel Passport
-   Update your User model to use the `HasApiTokens` trait
-   Configure your `auth.php` to use Passport as the API driver

2. Install the package:
   composer require nizam/passport-api

3. Publish the package configuration:
   php artisan vendor:publish --provider="Nizam\PassportApi\Providers\NizamPassportApiServiceProvider"

## Configuration

After publishing the configuration, you can modify the route prefix in the `config/nizam-passport-api.php` file:

```php
return [
 'route_prefix' => 'api/auth',
];


Usage
This package provides the following API routes:

POST /api/auth/register: Register a new user
POST /api/auth/login: Log in a user
POST /api/auth/logout: Log out a user (requires authentication)
POST /api/auth/forgot-password: Send a password reset link
POST /api/auth/reset-password: Reset the user's password



# passport-api
# passport
```
