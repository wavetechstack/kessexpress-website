# Laravel Installation via SSH

Run these commands in order:

```bash
# 1. Navigate to public_html
cd ~/public_html

# 2. Create new Laravel project
composer create-project laravel/laravel kessexpress

# 3. Change to project directory
cd kessexpress

# 4. Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R $(whoami):$(whoami) storage bootstrap/cache

# 5. Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# 6. Update database credentials in .env file
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
```

Save the file in nano:
1. Press CTRL + X
2. Press Y to confirm
3. Press ENTER to save
