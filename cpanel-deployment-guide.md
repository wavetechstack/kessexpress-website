# Laravel cPanel Deployment Guide

## 1. Prepare Deployment Package
- [ ] Download current Laravel project from Replit as ZIP
- [ ] Verify all test files are included:
  - check-environment.php
  - test-db.php
  - basic-test.php

## 2. Backup Current Installation
- [ ] In cPanel File Manager:
  - Navigate to public_html/kessexpress
  - Rename existing laravel-master to laravel-master-backup-YYYYMMDD
  - Download .env file for backup

## 3. Upload New Files
- [ ] Upload new ZIP file to public_html/kessexpress
- [ ] Extract ZIP contents
- [ ] Rename extracted folder to laravel-master

## 4. Configure Environment
- [ ] Copy backup .env file to new installation
- [ ] Update database credentials if needed:
```env
APP_NAME=KessExpress
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## 5. Set File Permissions
```bash
# Set base permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Set storage and cache permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 6. Verify Installation
1. Run Diagnostics:
   - Access basic-test.php to verify PHP setup
   - Run check-environment.php for full system check
   - Test database with test-db.php

2. Check Critical Components:
   - Storage directory permissions
   - Database connectivity
   - Laravel route functionality
   - File upload capability

## 7. Post-Deployment Tasks
1. Clear Laravel Cache:
```php
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

2. Verify Routes:
   - Test main application routes
   - Check API endpoints if applicable
   - Verify asset serving

## 8. Troubleshooting
1. File Permissions:
   - Check storage/logs for write access
   - Verify bootstrap/cache permissions
   - Ensure proper ownership of files

2. Database Issues:
   - Verify credentials in .env
   - Check MySQL user privileges
   - Test connection with test-db.php

3. Common Fixes:
   - Clear browser cache
   - Restart PHP-FPM if needed
   - Check error logs in storage/logs

## 9. Security Checklist
- [ ] Ensure APP_DEBUG is set to false
- [ ] Verify storage directory is not publicly accessible
- [ ] Check file permissions are correct
- [ ] Remove any test files after verification
- [ ] Secure .env file access
