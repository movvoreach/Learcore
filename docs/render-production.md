# Render Production Setup

This app must not use `127.0.0.1` for PostgreSQL in production. On Render,
`127.0.0.1` points to the web container itself, not the managed database.

Set these environment variables on the Render Web Service:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://learcore.onrender.com
APP_KEY=base64:your-generated-key

DB_CONNECTION=pgsql
DATABASE_URL=postgresql://USER:PASSWORD@HOST:PORT/DATABASE
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
RUN_MIGRATIONS=true
```

Use the managed PostgreSQL **Internal Database URL** from Render for
`DATABASE_URL` when the database is in the same Render account/region. If you
instead split the URL into separate variables, set `DB_HOST` to the Render
database host, not `127.0.0.1`.

After changing environment variables, redeploy the service. The container
entrypoint clears stale Laravel caches and rebuilds them from the current
runtime environment.
