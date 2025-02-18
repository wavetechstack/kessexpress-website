# Laravel cPanel Update Checklist

## 1. Prepare Updated Files
- [ ] Download current Laravel project from Replit as ZIP
- [ ] Ensure `.env.example` has correct MySQL settings
- [ ] Include all test files (test-db.php, basic-test.php)

## 2. Backup Current Installation
- [ ] In cPanel File Manager, rename existing laravel-master to laravel-master-backup
- [ ] Download a copy of your current .env file for reference

## 3. Upload New Files
- [ ] Upload the new ZIP file to public_html/kessexpress
- [ ] Extract the ZIP file
- [ ] Rename extracted folder to laravel-master if needed

## 4. Configuration
- [ ] Copy your existing .env file to the new installation
- [ ] Update database credentials if needed:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=localhost
  DB_PORT=3306
  DB_DATABASE=your_cpanel_database
  DB_USERNAME=your_cpanel_username
  DB_PASSWORD=your_database_password
  ```

## 5. Set Permissions
- [ ] Set directory permissions to 755:
  ```bash
  find . -type d -exec chmod 755 {} \;
  ```
- [ ] Set file permissions to 644:
  ```bash
  find . -type f -exec chmod 644 {} \;
  ```
- [ ] Make storage and cache writable:
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

## 6. Verify Installation
- [ ] Access test-db.php to verify database connection
- [ ] Check basic-test.php for PHP functionality
- [ ] Verify Laravel routes are working

## 7. Cleanup
- [ ] Once everything is working, remove the backup folder
- [ ] Clear Laravel cache if needed:
  ```php
  php artisan cache:clear
  php artisan config:clear
  ```
