# Vercel Deployment Guide for FindStay

## 🚀 Quick Setup with Vercel

### Step 1: Install Vercel CLI
```bash
npm install -g vercel
```

### Step 2: Login to Vercel
```bash
vercel login
```

### Step 3: Deploy Your Project
```bash
cd /workspaces/projet-de-synthese/hob
vercel
```

### Step 4: Configure Environment Variables
In Vercel dashboard, set these environment variables:
- `APP_ENV`: `production`
- `APP_DEBUG`: `false`
- `APP_KEY`: Your Laravel app key
- `DB_CONNECTION`: `sqlite`
- `CACHE_DRIVER`: `file`
- `SESSION_DRIVER`: `file`
- `FILESYSTEM_DISK`: `public`

### Step 5: Production Deployment
```bash
vercel --prod
```

## 🌐 Your App Will Be Available At:
https://your-app-name.vercel.app

## 🔄 Auto-Deploy on Git Push
Vercel automatically deploys when you push to GitHub!

## 📱 Mobile App Support
Vercel provides:
- ✅ HTTPS automatically
- ✅ Global CDN
- ✅ Custom domain support
- ✅ Analytics dashboard
