#!/bin/sh
cd /app
cp -n .env.example .env
touch /tmp/database.sqlite
PORT="${PORT:-7860}"
export APP_URL="${RENDER_EXTERNAL_URL:-http://localhost:$PORT}"
export FRONTEND_URL="$APP_URL"
php artisan key:generate --force
php artisan migrate:fresh --seed --force
if [ -n "$ADMIN_PASSWORD" ]; then
  php artisan tinker --execute='$u=App\Models\User::where("email","admin@example.com")->first(); $u->password=getenv("ADMIN_PASSWORD"); $u->save();'
fi
php artisan storage:link 2>/dev/null
exec php -S 0.0.0.0:$PORT -t public router.php
