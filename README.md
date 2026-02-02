# Softlinks RBAC Package

A robust, flexible, and easy-to-install Role-Based Access Control (RBAC) package for Laravel applications. This package scaffolds a complete admin panel, authentication guard, and route-based permission system.

## 🚀 Key Features

- **Automated Installation**: Scaffolds all necessary models, controllers, and views with a single command.
- **Dynamic Guard Registration**: Automatically registers the `admin` guard at runtime—no more manual config tweaks.
- **Route-Based Permissions**: Powerful permission checks based on URI slugs.
- **Admin Panel UI**: Includes a premium login page and dashboard layout stubs.
- **Safe Uninstallation**: Clean cleanup of all generated files.

## 📥 Installation

**For Production Use (Global):**
Once published, you can install the package via Composer:
```bash
composer require softlinks/rbac
```

**For Development Use (Local):**
1. Add the following to your root `composer.json` under `autoload.psr-4`:
   ```json
   "Softlinks\\Rbac\\": "packages/Softlinks/Rbac/src/"
   ```
2. Run `composer dump-autoload`.

## 🚀 Getting Started

After installing, run the interactive setup:
```bash
php artisan softlinks:install-rbac
```

## 🌍 Making it Public (GitHub & Packagist)

To make this package work for others globally via `composer require`:

1.  **Host on GitHub**: Create a repository named `softlinks-rbac` and push this package folder.
2.  **Submit to Packagist**: Go to [Packagist.org](https://packagist.org/), log in, and submit your GitHub URL.
3.  **Automatic Autoload**: Once published, Composer will automatically handle the `Softlinks\Rbac` namespace—no manual `composer.json` edits required!

## 🗑️ Clean Uninstallation

The delete command is now "smart"—it will automatically remove all files, revert config changes, and even clean up its own namespace from your `composer.json` if it was added manually.

```bash
php artisan softlinks:delete-rbac
```

---
Developed by **Softlinks**.
