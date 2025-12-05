<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PHP Tinder Backend API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        pre {
            background: #0f172a;
            color: #e5e7eb;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-size: 0.875rem;
        }

        code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Courier New", monospace;
        }

        a {
            color: #38bdf8;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="bg-slate-950 text-slate-100">

    <div class="min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4">

            {{-- LOGO LARAVEL --}}
            <div class="flex justify-center mb-8">
                <img src="https://raw.githubusercontent.com/laravel/art/master/laravel-logo.png" alt="Laravel Logo"
                    class="w-40 opacity-90 hover:opacity-100 transition duration-300">
            </div>

            {{-- PROJECT TITLE --}}
            <header class="text-center mb-10">
                <h1 class="text-4xl font-extrabold tracking-tight mb-4">
                    PHP Tinder Backend API (Laravel 12)
                </h1>
                <p class="text-slate-300 text-lg max-w-2xl mx-auto">
                    Technical assignment implementing Tinder-like backend features including recommendations,
                    like/dislike, cronjob email alerts, RDB schema, and Swagger API documentation.
                </p>
            </header>

            <div class="min-h-screen py-10">
                <div class="max-w-5xl mx-auto px-4">
                    <header class="mb-10">
                        <h1 class="text-3xl md:text-4xl font-bold mb-2">
                            PHP Tinder Backend API (Laravel 12)
                        </h1>
                        <p class="text-slate-300">
                            This project is a technical assignment implementing a Tinder-like backend using
                            <strong>Laravel
                                12</strong>, including:
                        </p>
                        <ul class="list-disc list-inside mt-3 space-y-1 text-slate-200">
                            <li>People recommendation API</li>
                            <li>Like / Dislike system</li>
                            <li>Liked people list</li>
                            <li>Cronjob (check if a person gets more than 50 likes → send email)</li>
                            <li>RDB schema</li>
                            <li>Swagger API documentation</li>
                        </ul>
                    </header>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">Requirements</h2>
                        <ul class="list-disc list-inside space-y-1 text-slate-200">
                            <li>PHP 8.2+</li>
                            <li>Composer</li>
                            <li>Laravel 12</li>
                            <li>MySQL / MariaDB</li>
                        </ul>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">Installation</h2>

                        <p class="font-semibold mt-4 mb-1">Clone repo:</p>
                        <pre><code>git clone &lt;your-repo-url&gt; cd your-project</code></pre>

                        <p class="font-semibold mt-4 mb-1">Install dependencies:</p>
                        <pre><code>composer install</code></pre>

                        <p class="font-semibold mt-4 mb-1">Copy environment file:</p>
                        <pre><code>cp .env.example .env</code></pre>

                        <p class="font-semibold mt-4 mb-1">Generate key:</p>
                        <pre><code>php artisan key:generate</code></pre>

                        <p class="font-semibold mt-4 mb-1">Setup database in <code>.env</code>:</p>
                        <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tinder_app
DB_USERNAME=root
DB_PASSWORD=</code></pre>

                        <p class="font-semibold mt-4 mb-1">Run migration &amp; seeder:</p>
                        <pre><code>php artisan migrate --seed</code></pre>

                        <p class="font-semibold mt-4 mb-1">Run development server:</p>
                        <pre><code>php artisan serve</code></pre>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">API Authentication</h2>
                        <p class="text-slate-200">
                            All API requests require <strong><code>X-User-Id</code> header</strong> to simulate
                            logged-in user.
                        </p>
                        <p class="font-semibold mt-3 mb-1">Example:</p>
                        <pre><code>X-User-Id: 1</code></pre>
                    </section>

                    <hr>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">API Documentation (Swagger)</h2>
                        <p class="text-slate-200 mb-2">Swagger UI available at:</p>
                        <pre><code>http://localhost:8000/api/documentation</code></pre>

                        <p class="text-slate-200 mt-4 mb-2">Regenerate documentation:</p>
                        <pre><code>php artisan l5-swagger:generate</code></pre>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">API Endpoints</h2>

                        <h3 class="text-xl font-semibold mt-3 mb-1">GET /api/people</h3>
                        <p class="text-slate-200">
                            List recommended people (pagination, excluding already liked/disliked).
                        </p>

                        <h3 class="text-xl font-semibold mt-4 mb-1">POST /api/people/{id}/like</h3>
                        <p class="text-slate-200">Like a person.</p>

                        <h3 class="text-xl font-semibold mt-4 mb-1">POST /api/people/{id}/dislike</h3>
                        <p class="text-slate-200">Dislike a person.</p>

                        <h3 class="text-xl font-semibold mt-4 mb-1">GET /api/people/liked</h3>
                        <p class="text-slate-200">List of people liked by the user.</p>

                        <p class="font-semibold mt-4 mb-1">Each request requires:</p>
                        <pre><code>X-User-Id: &lt;integer&gt;</code></pre>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">RDB Schema</h2>
                        <div class="bg-slate-900 border border-slate-800 rounded-xl p-4">
                            <img src="https://raw.githubusercontent.com/fathonaji/php-technical-test-tinder-backend/refs/heads/main/rdb_schema.png"
                                alt="RDB schema" class="rounded-lg w-full max-h-[480px] object-contain bg-slate-950">
                        </div>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">Cronjob (Like &gt; 50 → Send Email)</h2>

                        <p class="text-slate-200 mb-2">
                            A command checks whether a person has been liked by more than 50 unique users.
                        </p>

                        <p class="font-semibold mt-3 mb-1">Run manually:</p>
                        <pre><code>php artisan people:check-popular</code></pre>

                        <p class="font-semibold mt-4 mb-1">Cron scheduler is defined in:</p>
                        <pre><code>routes/console.php</code></pre>

                        <p class="font-semibold mt-4 mb-1">Runs every 10 minutes:</p>
                        <pre><code>Schedule::command('people:check-popular')-&gt;everyTenMinutes();</code></pre>

                        <p class="font-semibold mt-4 mb-1">Start scheduler worker:</p>
                        <pre><code>php artisan schedule:work</code></pre>

                        <p class="font-semibold mt-4 mb-1">Email Output</p>
                        <p class="text-slate-200">
                            Email is sent using Laravel Mail system.<br>
                            By default, mailer uses <strong>log</strong> mode:
                        </p>
                        <pre class="mt-2"><code>MAIL_MAILER=log</code></pre>

                        <p class="text-slate-200 mt-3">Email content appears in:</p>
                        <pre><code>storage/logs/laravel.log</code></pre>
                    </section>

                    <hr>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold mb-2">Tech Stack</h2>
                        <ul class="list-disc list-inside space-y-1 text-slate-200">
                            <li>Laravel 12</li>
                            <li>MySQL</li>
                            <li>L5 Swagger</li>
                            <li>Laravel Mail</li>
                            <li>Laravel Scheduler</li>
                            <li>REST API Architecture</li>
                        </ul>
                    </section>

                    <section class="mb-16">
                        <h2 class="text-2xl font-semibold mb-2">Development Notes</h2>
                        <ul class="list-disc list-inside space-y-2 text-slate-200">
                            <li>This project uses header-based simulation login (<code>X-User-Id</code>) for assignment
                                simplicity</li>
                            <li>Recommendation logic excludes already interacted people.</li>
                            <li>Email alert triggers only once per person (using <code>like_alert_sent_at</code>).</li>
                            <li>Location field currently stores plain text. For real-world implementation, it can be
                                improved by
                                storing <code>latitude</code> and <code>longitude</code> fields to enable geolocation
                                filtering
                                (distance-based recommendations).</li>
                            <li>In a real-world application, <strong>the <code>people</code> table would represent
                                    actual
                                    application users</strong>.</li>
                            <li>Future improvement: Add <strong>email</strong>, <strong>password</strong>, and
                                authentication
                                (Laravel Sanctum / JWT) so <code>people</code> can log in as real users.</li>
                        </ul>
                    </section>
                </div>
            </div>
</body>

</html>