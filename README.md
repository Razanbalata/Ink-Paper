# Ink & Paper

Ink & Paper is a social publishing platform built with Laravel. It gives writers a place to create, manage, and publish articles, while readers can discover content, follow authors, and engage with posts. An optional AI writing assistant helps authors refine and prepare their work.

This README provides an overview of the application, its features and architecture, and step-by-step instructions for local development, testing, and deployment.

## Contents

- [Project overview](#project-overview)
- [Features](#features)
- [How it works](#how-it-works)
- [Technology stack](#technology-stack)
- [Requirements](#requirements)
- [Getting started](#getting-started)
- [AI writing assistant](#ai-writing-assistant)
- [Demo data](#demo-data)
- [Testing](#testing)
- [Project structure](#project-structure)
- [Data model](#data-model)
- [Key routes](#key-routes)
- [Production notes](#production-notes)

## Project overview

Ink & Paper combines a public reading experience with an authenticated workspace for authors. Readers can browse and search articles, explore content by category or tag, and visit author profiles. Registered users can manage their own articles and take part in the community through comments, reactions, bookmarks, and follows.

The application uses Laravel routes and controllers to handle requests, Eloquent models to access data, and Blade templates to render pages. JavaScript enhances selected interactions, including the rich-text editor and JSON-based actions. The writing assistant calls the Groq API from the server; it is optional and is not required for the core publishing features.

## Features

### Article publishing

- Browse article listings and individual article pages.
- Create, edit, and delete articles while signed in.
- Save articles as drafts, publish them, or archive them.
- Add a title, content, excerpt, cover image, optional category, and tags.
- Generate a readable URL slug from the article title.
- Write and format content with the Tiptap rich-text editor.
- Estimate reading time from article content at approximately 200 words per minute.
- View dashboard statistics for published, draft, and archived articles, along with recent posts.

### Categories and tags

- Assign an optional category to an article.
- Associate multiple tags with an article.
- Manage categories and tags from the authenticated dashboard.
- Browse public category and tag pages.
- Use the AI assistant to suggest tags based on article content.

### Community and engagement

- Add comments, with editing and deletion governed by comment ownership and authorization policies.
- Add or remove a reaction to an article; each user can react once to a given post.
- Bookmark articles and view a personal saved-articles list.
- Follow and unfollow authors, and view follower and following lists.
- Receive notifications for comments, reactions, and follows; view notifications and mark them as read.
- Track article views for signed-in users and guest sessions. Repeated views from the same user or session are suppressed for 30 minutes.

### Accounts and discovery

- Register, sign in, and sign out.
- Verify email addresses and reset or update passwords.
- Edit profile information and manage the account.
- Search article titles, excerpts, and content.
- Browse author profiles, categories, and tags.
- Visit the About and Contact pages.

### AI writing assistant

When configured, the writing assistant can:

- Improve writing and expand draft content.
- Generate three title suggestions.
- Generate an article excerpt.
- Suggest three to five relevant tags.
- Produce an improved article draft with a title, excerpt, content, category, and tags.

AI output is returned as a suggestion for the author to review. It is not published automatically. The assistant requires a Groq API key; the rest of the application can be used without one.

## How it works

1. **Discover content:** Visitors browse the home page, article listings, categories, tags, and author profiles, or search for articles.
2. **Create an account:** Readers can register or sign in. Article management and community actions that require a user identity are protected by authentication.
3. **Prepare an article:** An author writes in the dashboard editor and can set the article status, category, tags, and cover image. The author may request AI suggestions and review them before saving.
4. **Save or publish:** Articles belong to their author and can be saved as drafts, published, or archived. The application records a publication timestamp when an article is published. The public article detail route only displays published articles with a publication timestamp.
5. **Engage with the community:** Signed-in users can comment, react, bookmark articles, and follow authors. Relevant activity generates notifications for the affected user.
6. **Record readership:** Opening a published article records a view against the signed-in user or the guest's session. Further views from that identity are not counted again during the 30-minute cooldown.

## Technology stack

| Area | Technology |
| --- | --- |
| Backend | PHP 8.3+ and Laravel 13 |
| Templates and styling | Blade and Tailwind CSS |
| Frontend behavior | JavaScript and Alpine.js |
| Rich-text editing | Tiptap |
| Asset bundling | Vite |
| Database | MySQL in `.env.example`; SQLite is also supported by the Laravel configuration |
| AI integration | Groq API using the OpenAI-compatible Chat Completions format |
| Testing | Pest and Laravel's test runner |

Laravel Reverb and Laravel Echo are included as dependencies. The application's current notification pages use Laravel's stored notifications and do not require a WebSocket server for the core experience.

## Requirements

- PHP **8.3** or later, with the PHP extensions required by Laravel.
- [Composer](https://getcomposer.org/).
- Node.js and npm compatible with Vite 8.
- MySQL, as configured in `.env.example`, or another database supported by the Laravel configuration, such as SQLite.
- A Groq API key only if you want to use the AI writing assistant.

## Getting started

The commands below use PowerShell and should be run from the repository root.

### 1. Install PHP dependencies

```powershell
composer install
```

### 2. Configure the environment

If you do not already have a local `.env` file, copy the example and generate the application key:

```powershell
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate
```

Review `.env` and configure the database, mail, and storage settings for your local environment. Never commit `.env` files, application keys, or service credentials.

### 3. Configure the database and run migrations

The supplied `.env.example` is configured for MySQL. Start MySQL, create the database named in `DB_DATABASE`, and set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`. Then apply migrations:

```powershell
php artisan migrate
```

To use SQLite instead, set the following values in `.env`:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Create the SQLite database file if it does not already exist:

```powershell
if (-not (Test-Path database\database.sqlite)) {
    New-Item -ItemType File -Path database\database.sqlite
}
```

### 4. Install frontend dependencies

```powershell
npm install
```

### 5. Link public storage

Article cover images are stored on Laravel's `public` disk. Create the public storage link:

```powershell
php artisan storage:link
```

### 6. Run the application

In one PowerShell window, start the Laravel development server:

```powershell
php artisan serve
```

In a second window, start Vite:

```powershell
npm run dev
```

Open the local URL printed by `php artisan serve`. To build frontend assets for deployment instead of using the Vite development server, run:

```powershell
npm run build
```

The repository also defines a Composer `setup` script. It installs PHP and frontend dependencies, creates `.env` if needed, generates the application key, runs migrations, and builds the frontend. Run the steps above individually when you want to control database setup or seed demo data separately.

## AI writing assistant

The writing assistant uses the Groq API. Add your API key and, optionally, the model name to your local `.env` file:

```dotenv
GROQ_API_KEY=your_groq_api_key
GROQ_MODEL=openai/gpt-oss-120b
```

The Groq API base URL is defined in the application's AI configuration. `openai/gpt-oss-120b` is the configured default model; you can override it with `GROQ_MODEL` using a model available to your Groq account that supports the request formats used by the application.

After changing environment configuration, clear Laravel's cached configuration if necessary:

```powershell
php artisan config:clear
```

Without a valid API key or a working connection to Groq, AI operations will fail, but the core publishing features remain available. Keep the API key on the server: do not place it in frontend JavaScript or expose it in browser responses.

## Demo data

To populate a local development database with sample categories, users, and articles, run:

```powershell
php artisan db:seed
```

The seeded accounts use the following credentials:

| Email | Password |
| --- | --- |
| `razan@example.com` | `password` |
| `ahmed@example.com` | `password` |
| `sara@example.com` | `password` |

These credentials are public and intentionally weak. Use them only for local development. Do not run the demo seeders against a production database.

## Testing

Run the test suite with:

```powershell
php artisan test
```

Or use the Composer script:

```powershell
composer test
```

The tests cover areas including authentication, profile management, follows, post view tracking, and the writing assistant. The test configuration uses an in-memory SQLite database and test-specific service settings, separate from the local development database.

## Project structure

```text
app/
├── AI/Prompts/              Prompts used by the writing assistant
├── Http/
│   ├── Controllers/         Web and AI request handlers
│   └── Requests/            Request validation
├── Models/                  Eloquent models and relationships
├── Notifications/           Comment, reaction, and follow notifications
├── Policies/                Authorization for posts and comments
├── Services/                Reusable application and AI services
└── View/Components/         Blade view components
bootstrap/                   Application and route bootstrapping
config/                      Framework and application configuration
database/
├── factories/               Model factories
├── migrations/              Database schema
└── seeders/                 Initial and demo data
resources/
├── css/ and js/             Frontend styles and JavaScript
└── views/                   Blade pages and components
routes/
├── web.php                  Application web routes
├── auth.php                 Authentication routes
└── ...
tests/
├── Feature/                 Feature and integration tests
└── Unit/                    Unit tests
```

### Request lifecycle

- `routes/web.php` defines application pages and actions; `routes/auth.php` defines registration, login, and password-related routes.
- Controllers receive requests and use form requests or inline validation to validate input.
- Eloquent models handle database access and define relationships. Reusable business logic is placed in `app/Services`.
- Database schema changes are maintained as migrations.
- Blade templates in `resources/views` render HTML; Vite builds the frontend assets.
- AI requests are sent to Groq from the server through `WritingAssistantService`. Individual prompt definitions are kept in `app/AI/Prompts`.

## Data model

The main database tables are:

| Table | Purpose |
| --- | --- |
| `users` | Author accounts and profile information |
| `posts` | Articles, content, status, and publication timestamp |
| `categories` | Article categories |
| `tags` | Article tags |
| `post_tag` | Many-to-many relationship between posts and tags |
| `comments` | User comments on posts |
| `reactions` | User reactions to posts |
| `bookmarks` | Posts saved by users |
| `user_follows` | Follower/following relationships |
| `post_views` | Views associated with a user or guest session |
| `notifications` | Laravel database notifications |

Foreign-key constraints cascade deletion for dependent post records and set a post's category to `NULL` if that category is deleted. Unique constraints prevent duplicate reactions, bookmarks, and follows for the same user and target.

## Key routes

| Route | Purpose |
| --- | --- |
| `/` | Home page |
| `/posts` | Article listing |
| `/posts/{slug}` | Published article detail |
| `/search?q=...` | Search articles |
| `/categories/{slug}` | Category page |
| `/tags/{slug}` | Tag page |
| `/authors/{user}` | Author profile |
| `/dashboard` | Authenticated user dashboard |
| `/dashboard/posts` | Manage the current user's articles |
| `/saved` | Saved articles (authentication required) |
| `/notifications` | Notifications |
| `/profile` | Profile settings |
| `/about` and `/contact` | Informational pages |
| `/register` and `/login` | Registration and sign-in |

## Production notes

- Set `APP_ENV=production` and `APP_DEBUG=false`, and configure `APP_URL`, database, mail, and storage for the deployment environment.
- Store the application key, Groq API key, and other credentials in your deployment platform's secret manager, not in the repository.
- Do not use demo seed data or the sample account passwords in production.
- Run production migrations as part of a controlled deployment, typically with `php artisan migrate --force`.
- Build frontend assets with `npm run build` and ensure the public storage link is available for uploaded images.
- Configure appropriate permissions for `storage` and `bootstrap/cache`.
- Reverb/Echo require additional configuration if you choose to enable WebSocket broadcasting; they are not required to run the core application.

## Documentation

- [Laravel documentation](https://laravel.com/docs)
- [Tiptap documentation](https://tiptap.dev/docs)
- [Groq API documentation](https://console.groq.com/docs)
