#!/bin/bash

# Create deployment package script
echo "Creating Laravel Deployment Package..."

# Create a temporary directory for the package
TEMP_DIR="deployment-package"
mkdir -p $TEMP_DIR

# Copy core Laravel files and directories
cp -r app bootstrap config database public resources routes storage vendor composer.json composer.lock artisan $TEMP_DIR/

# Copy environment files
cp .env.example $TEMP_DIR/
cp .env.cpanel $TEMP_DIR/

# Copy test files
cp public/test-db.php $TEMP_DIR/public/
cp public/check-environment.php $TEMP_DIR/public/
cp public/basic-test.php $TEMP_DIR/public/
cp public/cpanel-db-test.php $TEMP_DIR/public/

# Copy documentation
cp ../../../cpanel-deployment-guide.md $TEMP_DIR/
cp ../../../cpanel-laravel-update.md $TEMP_DIR/
cp ../../../laravel-deployment-checklist.md $TEMP_DIR/

# Set correct permissions
find $TEMP_DIR -type d -exec chmod 755 {} \;
find $TEMP_DIR -type f -exec chmod 644 {} \;
chmod -R 775 $TEMP_DIR/storage $TEMP_DIR/bootstrap/cache

# Create the ZIP file
zip -r laravel-deployment-package.zip $TEMP_DIR/* \
    -x "*/node_modules/*" \
    -x "*/vendor/*/test/*" \
    -x "*/vendor/*/tests/*" \
    -x "*/.git/*" \
    -x "*.env" \
    -x "*.log" \
    -x "*/storage/logs/*" \
    -x "*/storage/framework/cache/*" \
    -x "*/storage/framework/sessions/*" \
    -x "*/storage/framework/views/*"

# Cleanup
rm -rf $TEMP_DIR

echo "Deployment package created: laravel-deployment-package.zip"
