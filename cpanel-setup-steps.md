# In cPanel Terminal or SSH:
cd public_html
composer create-project laravel/laravel kessexpress
cd kessexpress
```

## 4. Configure Environment
1. Create/edit `.env` file:
```env
APP_NAME=KessExpress
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=kessexpress_db
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## 5. Set Permissions
```bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Set storage and bootstrap/cache permissions
chmod -R 775 storage bootstrap/cache
```

## 6. Generate Application Key
```bash
php artisan key:generate
```

## 7. Configure Domain
1. In cPanel:
   - Go to Domains
   - Point your domain to: public_html/kessexpress/public
   - Enable SSL if available

## 8. Run Migrations
```bash
php artisan migrate