cd public_html/kessexpress
php artisan key:generate
```

## 2. Run Migrations
```bash
php artisan migrate
```

## 3. Configure Domain
1. In cPanel:
   - Go to "Domains"
   - Find your domain
   - Set document root to: public_html/kessexpress/public
   - Save changes

## 4. Verify Installation
1. Visit your domain in a browser
2. You should see the Laravel welcome page
3. If you see any errors:
   - Check storage directory permissions (755)
   - Verify .env file permissions (644)
   - Ensure document root is correctly set

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