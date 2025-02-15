# Laravel Directory Structure Checklist

## Required Directories and Files
- [ ] /public_html/kessexpress/
  - [ ] .env file (644 permissions)
  - [ ] composer.json (644 permissions)
  - [ ] artisan (644 permissions)
  
- [ ] /public_html/kessexpress/public/
  - [ ] index.php (644 permissions)
  - [ ] .htaccess (644 permissions)
  
- [ ] /public_html/kessexpress/storage/
  - [ ] logs/ (755 permissions)
  - [ ] framework/ (755 permissions)
  - [ ] app/ (755 permissions)
  
- [ ] /public_html/kessexpress/bootstrap/
  - [ ] cache/ (755 permissions)

## Commands to Run
```bash
# Set directory permissions
chmod -R 755 /public_html/kessexpress/storage
chmod -R 755 /public_html/kessexpress/bootstrap/cache

# Set file permissions
chmod 644 /public_html/kessexpress/.env
chmod 644 /public_html/kessexpress/public/index.php
chmod 644 /public_html/kessexpress/public/.htaccess

# Set ownership (replace username with your cPanel username)
chown -R username:username /public_html/kessexpress
```

## Document Root Configuration
- Domain should point to: /public_html/kessexpress/public
