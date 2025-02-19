DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## 2. Environment Variables
- [ ] Copy .env.cpanel to .env in cPanel
- [ ] Generate new APP_KEY if needed:
```bash
php artisan key:generate
```

## 3. Database Migration
- [ ] Back up current PostgreSQL data
- [ ] Run migrations for MySQL:
```bash
php artisan migrate:fresh
```

## 4. File Structure
- [ ] Verify correct Laravel directory structure
- [ ] Ensure proper file permissions
- [ ] Check storage directory accessibility

## 5. Set File Permissions
- [ ] Set directory permissions:
```bash
find . -type d -exec chmod 755 {} \;
```
- [ ] Set file permissions:
```bash
find . -type f -exec chmod 644 {} \;
```
- [ ] Set special directory permissions:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 6. Verification Steps
- [ ] Run diagnostics:
  - Access basic-test.php to verify PHP setup
  - Run check-environment.php for full system status
  - Test database connection with test-db.php
- [ ] Verify Laravel functionality:
  - Check routes are working
  - Confirm database connections
  - Test file uploads to storage

## 7. Post-Update Tasks
- [ ] Clear Laravel caches:
```php
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear