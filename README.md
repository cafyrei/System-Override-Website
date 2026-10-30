# System Override

System Override is a cyberpunk-themed game community website built with CodeIgniter 4. Public pages cover the game, patch notes, screenshots and player feedback; a login-protected dashboard lets administrators publish patches and gallery items and review player feedback without touching files.

## Features

- Public pages: Home, About, Learn, Patches, Gallery, Feedback
- Validated feedback form (suggestion / bug report) with on-page success and error messages
- Timed multiple-choice quiz (4 choices, 10 questions by default) with a fastest-time leaderboard
- Admin dashboard: manage patches and gallery entries, mark feedback reviewed, delete feedback
- Tailwind CSS 4 styling, background audio and interface animations

## Stack

PHP 8.1+ · CodeIgniter 4 · MySQL/MariaDB (MySQLi) · Tailwind CSS 4 · PHPUnit 10

## Setup

Requirements: PHP 8.1+ with `intl`, `mbstring`, `json`, `mysqlnd`, `curl`; Composer; MySQL or MariaDB; Node.js + npm (only to rebuild CSS). Point your web server's document root at `public/`.

```bash
composer install
cp env .env            # Windows: copy env .env
```

Edit `.env`:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = system-override
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

Create the empty database, then let migrations build the tables:

```sql
CREATE DATABASE `system-override` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

```bash
php spark migrate
```

(The migrations use `IF NOT EXISTS`, so a database created from the old README SQL is fine.)

Load the sample quiz questions (generic gaming/tech trivia; replace them with your own):

```bash
php spark db:seed QuizSeeder
```

### Admin login

There are no default credentials. Login stays disabled until you set them:

```bash
php spark admin:hash        # prompts for a password (12+ characters), prints a hash
```

Paste the printed line into `.env` next to a username:

```ini
admin.username = 'your-username'
admin.passwordHash = '$2y$12$...'
```

Keep the single quotes; the hash contains `$`. Never commit `.env`.

### Run it

```bash
php spark serve         # http://localhost:8080
```

`writable/` must be writable by PHP. `public/uploads/gallery/` and `public/uploads/patches/` must be writable by the web server.

## Routes

| Method | Path | Purpose |
| --- | --- | --- |
| GET | `/`, `/about`, `/learn`, `/patches`, `/gallery`, `/feedback` | Public pages |
| POST | `/feedback` | Submit feedback |
| GET | `/quiz`, `/quiz/leaderboard` | Quiz page; leaderboard as JSON |
| POST | `/quiz/start`, `/quiz/next`, `/quiz/answer` | Quiz round API (used by `public/js/main/quiz.js`) |
| GET | `/admin-login` | Login form |
| POST | `/admin/login`, `/admin/logout` | Sign in / out (login is rate-limited per IP) |
| GET | `/admin` | Dashboard |
| POST | `/admin/gallery`, `/admin/gallery/{id}/delete` | Create or update / delete a gallery item |
| POST | `/admin/patches`, `/admin/patches/{id}/delete` | Create or update / delete a patch |
| POST | `/admin/feedback/{id}/reviewed`, `/admin/feedback/{id}/delete` | Review / delete feedback |

Everything under `/admin` except login/logout sits in one route group guarded by the `adminAuth` filter (`app/Filters/AdminAuth.php`). A new admin route added to that group is protected by default. All mutations are POST and CSRF-checked.

## Security model

- **One gate.** Authentication lives in a single filter on the admin route group, not in individual controllers.
- **Credentials** come from `.env` and are stored as a bcrypt hash. Unconfigured means login is refused.
- **CSRF** protection is on globally. Forms render `csrf_field()`; the dashboard's `fetch()` calls send the token from a `<meta>` tag (`public/js/admin/http.js`).
- **Uploads** accept only JPEG/PNG/WebP/GIF, verified by detected MIME type and extension, max 10 MB, stored under random names. `public/uploads/.htaccess` additionally blocks script execution (Apache). On nginx, add an equivalent rule to deny `.php` under `/uploads/`.
- **Output** from user-submitted feedback is escaped in every view.
- Still your job in production: serve over HTTPS and set `forceGlobalSecureRequests = true`, use a least-privilege database account, and note that the admin page loads Tailwind's Play CDN script (`cdn.tailwindcss.com`) in addition to the compiled CSS, which Tailwind advises against for production.

## Quiz

Players enter a callsign, answer 10 four-choice questions against a per-question timer, and are ranked by **highest score, then fastest total time**.

Settings live in `app/Config/Quiz.php` and can be overridden in `.env` (e.g. `quiz.questionsPerRound = 15`, `quiz.secondsPerQuestion = 20`). The round length is capped by the number of active questions in `quiz_questions`. If you change `questionsPerRound` on a live site, clear `quiz_attempts` so old and new scores aren't mixed.

Questions are rows in `quiz_questions` (`question`, `choice_1`..`choice_4`, `correct_choice` = 1-4, `is_active`). There is no admin screen for them yet: edit `app/Database/Seeds/QuizSeeder.php` or insert rows directly.

How it stays fair (`app/Controllers/Pages/Quiz.php`):

- The correct answer is never sent with a question; it is revealed only after that question is answered.
- The server owns the clock. The on-page timer is cosmetic, and answers faster than `minAnswerMs` are recorded as that value.
- A wrong or late answer is charged the full time limit, so fast guessing can't beat knowing the answer.
- Each question can be answered once (atomic update), rounds start rate-limited per IP, and callsigns are validated and escaped.

Limits to know about: nothing can stop a player from looking answers up or memorising them across replays, and abandoned unfinished rounds stay in `quiz_attempts` (they never appear on the board; prune old rows if the table grows).

## Frontend

```bash
npm install
npm run dev      # watches public/input.css, writes public/css/output.css
npm run build    # one-off minified build
```

## Tests

```bash
composer test
```

Tests run against in-memory SQLite and cover: guests being locked out of every admin route, login (wrong, right, unconfigured), the old hardcoded credentials no longer working, admin actions, public feedback validation, upload rules and path-traversal protection, that every public page renders, and the quiz (grading, timing and penalties, one answer per question, configurable length, leaderboard order).

## Layout

```text
app/Controllers/Pages/    Public page controllers (incl. Quiz)
app/Controllers/Admin/    Auth, Dashboard, Feedback, Gallery, Patches
app/Filters/AdminAuth.php The one admin gate
app/Libraries/            UploadStorage: the only code that writes/deletes uploads
app/Config/Admin.php      Admin credentials (read from .env)
app/Database/Migrations/  Schema
app/Commands/             php spark admin:hash
app/Views/                Page, admin and partial templates
public/                   Web root: CSS, JS, images, audio, uploads
tests/                    PHPUnit (unit + feature)
```

## License

MIT. See [LICENSE](LICENSE).
