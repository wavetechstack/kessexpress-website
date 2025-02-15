# Laravel Directory Setup for cPanel

## 1. Directory Structure
Your Laravel application should be structured as follows:
```
public_html/
└── kessexpress/
    ├── public/         # Document root (755)
    │   ├── index.php
    │   └── .htaccess
    ├── storage/        # Storage directory (755)
    └── bootstrap/      # Bootstrap directory
        └── cache/      # Cache directory (755)
```

## 2. Fix 403 Forbidden Error
1. Check Document Root in cPanel:
   - Go to "Domains" section
   - Set document root to: /public_html/kessexpress/public

2. Verify File Permissions:
   ```
   Directory Permissions:
   - public_html/kessexpress: 755
   - public_html/kessexpress/public: 755
   - public_html/kessexpress/storage: 755
   - public_html/kessexpress/bootstrap/cache: 755
   
   File Permissions:
   - .htaccess: 644
   - index.php: 644
   - All other PHP files: 644
   ```

3. Update .htaccess (if needed):
   - Ensure .htaccess exists in public directory
   - Check if mod_rewrite is enabled
   - Verify RewriteBase is set correctly

## 3. Common Solutions
If still getting 403 error:
1. Contact hosting provider to:
   - Enable mod_rewrite
   - Verify PHP version compatibility
   - Check server configuration
