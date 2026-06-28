# Render + Supabase Production Setup

This app must not use `127.0.0.1` for PostgreSQL in production. On Render,
`127.0.0.1` points to the web container itself, not your Supabase database.

Set these environment variables on the Render Web Service:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://learcore.onrender.com
APP_KEY=base64:your-generated-key

DB_CONNECTION=pgsql
DATABASE_URL=postgres://postgres.PROJECT_REF:YOUR_DATABASE_PASSWORD@aws-REGION.pooler.supabase.com:5432/postgres
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
RUN_MIGRATIONS=true
```

Use the Supabase **Session pooler** connection string for `DATABASE_URL`:

1. Open Supabase Dashboard.
2. Open your project.
3. Click **Connect**.
4. Choose **Connection string**.
5. Choose **Session pooler**.
6. Copy the URI and replace `[YOUR-PASSWORD]` with your database password.

For Laravel on Render, prefer the Supabase Session pooler:

```env
DATABASE_URL=postgres://postgres.PROJECT_REF:YOUR_DATABASE_PASSWORD@aws-REGION.pooler.supabase.com:5432/postgres
DB_SSLMODE=require
```

Do not use this in production:

```env
DB_HOST=127.0.0.1
```

If you split the Supabase URL into separate variables, use values like this:

```env
DB_CONNECTION=pgsql
DB_HOST=aws-REGION.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.PROJECT_REF
DB_PASSWORD=YOUR_DATABASE_PASSWORD
DB_SSLMODE=require
```

Avoid the Supabase transaction pooler on port `6543` for this Laravel app unless
you also configure PDO prepared statement compatibility. The session pooler on
port `5432` is the safer default for a persistent Render web service.

After changing environment variables, redeploy the service. The container
entrypoint clears stale Laravel caches and rebuilds them from the current
runtime environment.
