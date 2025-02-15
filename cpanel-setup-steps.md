# Connect via SSH
cd public_html
composer create-project laravel/laravel kessexpress
cd kessexpress

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache

# Configure environment
cp .env.example .env
php artisan key:generate
```

## Method 2: Using File Manager
1. Download Laravel from https://github.com/laravel/laravel/archive/refs/heads/master.zip
2. Upload to cPanel:
   - Go to File Manager
   - Navigate to public_html
   - Create folder "kessexpress"
   - Upload and extract Laravel files
   - Set permissions:
     * All directories: 755
     * All files: 644
     * storage/ and bootstrap/cache: 775

## After Installation (Both Methods)
1. Configure .env file with database details:
```env
APP_NAME=KessExpress
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=[your_database_name]
DB_USERNAME=[your_database_user]
DB_PASSWORD=[your_database_password]
```

2. Point domain to Laravel public folder:
   - Go to "Domains" in cPanel
   - Set document root to: /public_html/kessexpress/public

## 8. Run Migrations
```bash
php artisan migrate