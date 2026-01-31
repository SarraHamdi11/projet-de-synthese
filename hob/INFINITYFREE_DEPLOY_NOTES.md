# InfinityFree Deployment Notes

## What was configured for you
- ✅ Root `.htaccess` redirects all traffic to `/public`
- ✅ GitHub Actions workflow (`.github/workflows/deploy.yml`) for FTP deployment
- ✅ Composer `post-install-cmd` runs production optimizations
- ✅ PHP version set to `^8.2` (compatible with shared hosting)

## Manual steps you must do (once)

### 1) Add FTP secrets to GitHub
In your GitHub repo:
- Go to `Settings > Secrets and variables > Actions`
- Add these repository secrets:
  - `FTP_SERVER`: your InfinityFree FTP hostname
  - `FTP_USERNAME`: your FTP username
  - `FTP_PASSWORD`: your FTP password

### 2) Create the database on InfinityFree
- In InfinityFree Control Panel, create a MySQL database (e.g., `laravel_db`)
- Import your local database via phpMyAdmin if you have a `.sql` file
- Update your `.env` on the server (or via FTP upload) with the remote DB credentials:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=your-infinityfree-db-host
  DB_PORT=3306
  DB_DATABASE=laravel_db
  DB_USERNAME=your_db_user
  DB_PASSWORD=your_db_password
  ```

### 3) Deploy
- Push your code to the `main` branch
- GitHub Actions will automatically FTP-upload to InfinityFree
- Visit your InfinityFree URL to verify

## Shared‑hosting gotchas & workarounds

### ❌ You cannot run `php artisan migrate` on the server
- Export your local database and import it via phpMyAdmin
- Or manually create needed tables in phpMyAdmin

### ❌ `php artisan storage:link` often fails
- If images/uploads don’t show, configure Laravel to use `public` disk directly:
  ```env
  FILESYSTEM_DISK=public
  ```
- Upload files directly to `public/storage` via FTP instead of `storage/app/public`

### ✅ Production optimizations are automatic
- Composer `post-install-cmd` runs:
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`
  - `php artisan optimize`

### ✅ Node assets are built in CI
- The GitHub Action runs `npm ci && npm run build` before upload

## Optional: Force HTTPS (recommended)
Add to `public/.htaccess` after deployment:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## Need help?
- If images don’t load, ask me to “fix filesystem config for shared hosting”
- If you see 500 errors, check the `storage/logs/laravel.log` file via FTP
- For database issues, verify DB credentials in `.env` on the server
