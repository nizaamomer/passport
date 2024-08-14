# Nizam Passport API

**Nizam Passport API** is a Laravel package designed to streamline API authentication setup using Laravel Passport. Compatible with Laravel versions 8, 9, 10, and 11, this package simplifies Passport integration by automating the installation and configuration process, making it ideal for API-only projects.

## Features

-   **Automatic Laravel Passport Installation:** Ensures Passport is installed and configured.
-   **API Authentication Scaffolding:** Provides necessary controllers, requests, and routes.
-   **Configuration Updates:** Automatically updates `api.php`, `web.php`, and appends to `auth.php` to use Passport.
-   **User Model Update:** Adds the `HasApiTokens` trait to the User model.
-   **Environment Configuration:** Updates `.env` with default settings.
-   **Auth Configuration Update:** Adds the API guard to the `auth.php` configuration file with the Passport driver if it’s not already present. This ensures your application uses Passport's TokenGuard for authenticating incoming API requests.
-   **Cleanup:** Removes unnecessary files and directories for API-only applications.

## Requirements

-   **PHP:** ^7.3|^8.0
-   **Laravel:** ^8.0|^9.0|^10.0|^11.0
-   **Laravel Passport:** ^10.0|^11.0|^12.0

## Installation

1. **Install the Nizam Passport API package:**

    ```bash
    composer require nizam/passport-api
    ```

2. **Set up the Passport API:**

    ```bash
    php artisan nizam:install-passport-api
    ```

    This command will:

    - Check and install Laravel Passport if necessary
    - Set up required controllers, requests, and routes
    - Add the `HasApiTokens` trait to the User model
    - Update your `auth.php` configuration to use Passport as the API driver
    - Update your `web.php` and `api.php` configurations
    - Modify `.env` with default URL settings
    - Clean up unnecessary files and directories

## Usage

This package provides the following API routes:

-   **POST /api/auth/register:** Register a new user
-   **POST /api/auth/login:** Log in a user
-   **POST /api/auth/logout:** Log out a user (requires authentication)
-   **POST /api/auth/forgot-password:** Send a password reset link
-   **POST /api/auth/reset-password:** Reset the user's password
-   **GET /api/auth/verify-email/{id}/{hash}:** Verify email address (requires authentication)
-   **POST /api/auth/email/verification-notification:** Resend email verification notification (requires authentication)

-   **GET /api/auth/user:** Get authenticated user information (requires authentication)

## Configuration

After installation, ensure your application's `config/auth.php` configuration file includes an API authentication guard with the Passport driver. This configuration instructs your application to use Passport's TokenGuard for authenticating incoming API requests.

## Reporting Issues

If you encounter any issues or have suggestions for improvements, please follow these steps to report them:

1. **Check Existing Issues:** Before creating a new issue, check the [Issues](https://github.com/nizaamomer/passport-api/issues) tab to see if the issue has already been reported.
2. **Create a New Issue:** If the issue has not been reported, click on the "New Issue" button and provide a detailed description of the problem. Include:
    - A clear title
    - A detailed description of the issue
    - Steps to reproduce the issue
    - Any error messages or logs
    - The version of Laravel and Laravel Passport you are using
3. **Submit the Issue:** Once you have provided all the necessary information, submit the issue. The maintainers will review and address it as soon as possible.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Credits

-   **Nizam Omer** - Package author and maintainer

---

Thank you for using Nizam Passport API! Special thanks to everyone who has contributed, tested, and provided feedback. Your support is greatly appreciated. May this package help you in your API development journey. 🙏
