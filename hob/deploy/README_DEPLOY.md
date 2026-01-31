# Deploy to InfinityFree

## Quick steps
1) Add FTP secrets to GitHub repo (Settings > Secrets and variables > Actions):
   - FTP_SERVER
   - FTP_USERNAME
   - FTP_PASSWORD

2) Create database on InfinityFree and import your `.sql` file via phpMyAdmin

3) Upload `.env` to server with your database credentials (copy `.env.example` to `.env` and fill in)

4) Push to `main` branch → GitHub Action will deploy automatically

## If images don’t load
Set in your `.env` on the server:
```
FILESYSTEM_DISK=public
```
And upload files to `public/storage` instead of `storage/app/public`.

## If you see 500 errors
Check `storage/logs/laravel.log` via FTP and verify `.env` DB credentials.
