# 1. Connect to your server (replace with your details)
ssh your-cpanel-username@your-domain

# 2. Navigate to public_html
cd ~/public_html

# 3. Create new Laravel project
composer create-project laravel/laravel kessexpress

# 4. Change to project directory
cd kessexpress

# 5. Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R $(whoami):$(whoami) storage bootstrap/cache

# 6. Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# 7. Update database credentials in .env file
# Use the nano editor:
nano .env
```

When editing .env, update these lines with your database details:
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password