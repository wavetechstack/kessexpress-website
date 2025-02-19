# Laravel Deployment Package Checklist

## 1. Database Test Files
- [ ] public/test-db.php (General database test)
- [ ] public/cpanel-db-test.php (cPanel MySQL specific test)
- [ ] public/check-environment.php (Environment verification)
- [ ] public/basic-test.php (Basic Laravel setup test)

## 2. Environment Configuration
- [ ] .env (Current Replit PostgreSQL configuration)
- [ ] .env.cpanel (cPanel MySQL template)
- [ ] .env.example (Example configuration template)

## 3. Core Configuration Files
- [ ] config/database.php (Verify both PostgreSQL and MySQL configurations)
- [ ] public/.htaccess (Apache configuration for Laravel)
- [ ] storage/ directory permissions (775)
- [ ] bootstrap/cache/ directory permissions (775)

## 4. Documentation
- [ ] cpanel-deployment-guide.md (Complete deployment instructions)
- [ ] cpanel-laravel-update.md (Database migration steps)
- [ ] cpanel-setup-steps.md (Environment setup guide)

## 5. Required Files for ZIP Package
```bash
# Core Application Files
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess
│   ├── index.php
│   └── test files...
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env.example
├── .env.cpanel
├── artisan
├── composer.json
└── composer.lock

# Documentation
├── cpanel-deployment-guide.md
├── cpanel-laravel-update.md
└── cpanel-setup-steps.md
```

## 6. Pre-ZIP Verification Steps
1. Verify all test files are working:
   ```bash
   php public/basic-test.php
   php public/check-environment.php
   php public/test-db.php
   php public/cpanel-db-test.php
   ```

2. Check environment files:
   - Ensure no sensitive credentials in .env.example
   - Verify .env.cpanel has correct MySQL template
   - Remove any development-specific settings

3. Verify directory permissions:
   ```bash
   find . -type d -exec chmod 755 {} \;
   find . -type f -exec chmod 644 {} \;
   chmod -R 775 storage bootstrap/cache
   ```

4. Clear Laravel cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

## 7. Creating the ZIP Package
```bash
# Exclude development files
zip -r laravel-master.zip . -x "node_modules/*" ".git/*" ".env"
```

## 8. Post-ZIP Verification
- [ ] Download and extract ZIP
- [ ] Verify all required files are present
- [ ] Test environment setup process
- [ ] Verify database configuration works
- [ ] Check documentation readability
