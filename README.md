# System Override

System Override is a cyberpunk-themed game community website built with CodeIgniter 4. It provides public pages for game information, patch notes, screenshots, and player feedback, plus a session-protected dashboard for managing patches, gallery items, and feedback.

## What it is for

This project gives a game team one place to communicate with its community. Players can learn about the game, see released updates and screenshots, and submit suggestions or bug reports. Administrators can then review player feedback and publish or update the patch and gallery content without editing the site files directly.

## Features

- Public home, About, Learn, Patches, Gallery, and Feedback pages
- Patch-note listing with downloadable/uploaded patch assets
- Screenshot gallery
- Validated player feedback form for suggestions and bug reports
- Admin dashboard to manage patches and gallery entries, and review or delete feedback
- Responsive styling built with Tailwind CSS and project-specific CSS/JavaScript
- Background audio and interface animations

## Stack

- PHP 8.1+
- CodeIgniter 4
- MySQL/MariaDB via MySQLi
- Tailwind CSS 4
- PHPUnit 10

## Requirements

- PHP 8.1 or later with `intl`, `mbstring`, `json`, `mysqlnd`, and `curl` enabled
- Composer
- Node.js and npm (only needed when rebuilding CSS)
- MySQL or MariaDB
- A web server configured to serve the `public/` directory

## Getting started

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Install frontend dependencies:

   ```bash
   npm install
   ```

3. Create your local environment file from the example:

   ```bash
   copy env .env
   ```

   On macOS/Linux, use `cp env .env` instead.

4. Set `CI_ENVIRONMENT`, `app.baseURL`, and the `database.default.*` values in `.env`. For example:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost/system-override/public/'

   database.default.hostname = localhost
   database.default.database = system-override
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   ```

5. Create the database and its tables. This project currently has no application migrations, so create the schema with your database tool:

   ```sql
   CREATE DATABASE `system-override` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   USE `system-override`;

   CREATE TABLE `game_patches` (
     `patch_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `patch_path` VARCHAR(255) NOT NULL,
     `patch_title` VARCHAR(255) NOT NULL,
     `patch_description` TEXT NOT NULL,
     `patch_version` VARCHAR(100) NOT NULL,
     `patch_type` VARCHAR(100) NOT NULL,
     `patch_release` DATE NOT NULL,
     PRIMARY KEY (`patch_id`)
   );

   CREATE TABLE `gallery` (
     `gallery_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `image_path` VARCHAR(255) NOT NULL,
     `gallery_title` VARCHAR(255) NOT NULL,
     `gallery_description` TEXT NOT NULL,
     PRIMARY KEY (`gallery_id`)
   );

   CREATE TABLE `user_feedback` (
     `feedback_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
     `username` VARCHAR(50) NOT NULL,
     `feedback_type` ENUM('suggestion', 'bug_report') NOT NULL,
     `comment` TEXT NOT NULL,
     `email` VARCHAR(255) NOT NULL,
     `status` VARCHAR(50) NOT NULL DEFAULT 'unread',
     `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`feedback_id`)
   );
   ```

6. Make sure PHP can write to `writable/` and that the web server can write to `public/uploads/gallery/` and `public/uploads/patches/` when administrators upload content.

7. Run the local server:

   ```bash
   php spark serve
   ```

   Open the URL printed by CodeIgniter (normally `http://localhost:8080`). If using Apache/XAMPP, configure the document root to this repository's `public/` directory.

## Frontend development

Rebuild Tailwind CSS while editing view templates:

```bash
npm run dev
```

The command watches `public/input.css` and writes the generated stylesheet to `public/css/output.css`.

## Routes

| Path | Purpose |
| --- | --- |
| `/` | Home page and recent unread feedback |
| `/about` | Team/about page |
| `/learn` | Game learning page |
| `/patches` | Published patches |
| `/gallery` | Screenshot gallery |
| `/feedback` | Feedback form |
| `/admin-login` | Administrator sign-in |
| `/admin` | Dashboard for feedback, gallery, and patches |

## Tests

Run the PHPUnit suite with:

```bash
composer test
```

## Project layout

```text
app/                 Controllers, models, views, and CodeIgniter configuration
public/              Web root, compiled CSS, JavaScript, images, audio, and uploads
public/uploads/      Admin-managed gallery and patch assets
writable/            Logs, sessions, cache, and other runtime files
tests/               PHPUnit tests
```

## Security notes

- Keep `.env` private; it is intentionally ignored by Git.
- The current administrator authentication is implemented directly in `app/Controllers/Admin/Admin.php`. Before deploying, replace the hard-coded credentials with securely hashed, environment-based credentials or a proper user/authentication system.
- Use HTTPS and a production database account with only the permissions the application needs.

## License

This project is distributed under the [MIT License](LICENSE).
