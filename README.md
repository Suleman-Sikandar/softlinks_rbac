# Softlinks RBAC Package

A robust, flexible, and easy-to-install Role-Based Access Control (RBAC) package for Laravel applications. This package scaffolds a complete admin panel, authentication guard, and route-based permission system.

## 🚀 Key Features

- **Automated Installation**: Scaffolds all necessary models, controllers, and views with a single command.
- **Dynamic Guard Registration**: Automatically registers the `admin` guard at runtime—no more manual config tweaks.
- **Route-Based Permissions**: Powerful permission checks based on URI slugs.
- **Admin Panel UI**: Includes a premium login page and dashboard layout stubs.
- **Safe Uninstallation**: Clean cleanup of all generated files.

## 📥 Installation

1. **Register the Package**:
   Add the following to your root `composer.json` under `autoload.psr-4`:
   ```json
   "Softlinks\\Rbac\\": "packages/Softlinks/Rbac/src/"
   ```

2. **Dump Autoload**:
   ```bash
   composer dump-autoload
   ```

3. **Install RBAC**:
   Run the interactive installation command:
   ```bash
   php artisan softlinks:install-rbac
   ```
   *   Answer **Yes** to run migrations.
   *   Answer **Yes** to run the seeder (creates default admin user).

## 🔑 Default Credentials

Once seeded, you can log in at `/login` with:

- **Username**: `admin`
- **Password**: `password`

## 🛠️ Commands

| Command | Description |
| :--- | :--- |
| `php artisan softlinks:install-rbac` | Installs all stubs, updates config, and runs migrations/seeds. |
| `php artisan softlinks:delete-rbac` | Removes all RBAC-related files and reverts configuration changes. |

## 📐 Architecture

- **Guard**: `admin` (Session-based)
- **Provider**: `tbl_admin` (Eloquent)
- **Primary Tables**: `tbl_admin`, `tbl_roles`, `tbl_modules`, `tbl_role_privileges`
- **Permission Check**: Uses `validatePermissions($slug)` helper via `AuthMiddleware`.

## 🗑️ Uninstallation

To completely remove the package files and revert configuration:
```bash
php artisan softlinks:delete-rbac
```

---
Developed by **Softlinks**.
