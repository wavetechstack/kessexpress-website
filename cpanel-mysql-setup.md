# cPanel MySQL Setup Guide for Laravel

## 1. Create MySQL Database in cPanel
1. Login to cPanel
2. Go to "MySQL Databases"
3. Create a new database
   - Note down the full database name (usually prefixed with your cPanel username)
4. Create a new database user
   - Note down the username and password
5. Add the user to the database with 'ALL PRIVILEGES'

## 2. Configure Laravel for MySQL
1. Create or edit `.env` file in your Laravel project root with these settings:
```env
APP_NAME=KessExpress
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_cpanel_username_database_name
DB_USERNAME=your_cpanel_username_db_user
DB_PASSWORD=your_database_password
```

## 3. Upload Project Files
1. Download your Laravel project as a ZIP file
2. In cPanel File Manager:
   - Navigate to public_html/kessexpress
   - Remove existing laravel-master folder
   - Upload and extract the new ZIP file
   - Rename extracted folder to laravel-master if needed

## 4. Set File Permissions
```bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make storage and bootstrap/cache writable
chmod -R 775 storage bootstrap/cache
```

## 5. Test Database Connection
1. Access test-db.php through your browser:
   https://your-domain.com/test-db.php

## Troubleshooting
If you encounter issues:
1. Check error logs in cPanel (Error Log)
2. Verify database credentials in .env file
3. Ensure proper file permissions
4. Check PHP version compatibility (PHP 8.1+ recommended)
