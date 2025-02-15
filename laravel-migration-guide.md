# Install PHP and Composer if not already installed
composer create-project laravel/laravel kessexpress
cd kessexpress
```

## 2. Convert React Components to Laravel

### 2.1 Component Migration Map
```
React Component         → Laravel Blade Component
------------------------------------------
/src/pages/            → /resources/views/pages/
/src/components/       → /resources/views/components/
Hero.tsx              → components/sections/hero.blade.php
About.tsx             → pages/about.blade.php
```

### 2.2 Static Assets
1. Move all static assets:
   - From: /client/src/assets/
   - To: /public/assets/

### 2.3 Styling
1. Keep existing Tailwind CSS:
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init
```

## 3. Database Migration

### 3.1 Create Migration Files
```bash
php artisan make:migration create_users_table
php artisan make:migration create_services_table
```

## 4. cPanel Deployment

### 4.1 Prepare Application
1. Build assets:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4.2 Upload to cPanel
1. Using File Manager:
   - Create directory: public_html/kessexpress
   - Upload all files
   - Set permissions:
     * Directories: 755
     * Files: 644

### 4.3 Database Setup
1. In cPanel:
   - Create MySQL database
   - Create database user
   - Import database schema
   - Update .env with credentials

### 4.4 Configure Domain
1. In cPanel:
   - Point domain to: public_html/kessexpress/public
   - Set up SSL if needed

## 5. Post-Deployment
1. Test all routes
2. Verify forms and database connections
3. Check email functionality
4. Monitor error logs


## 6. Asset Migration (From Original Guide)
1. Move all static assets:
- From: /client/src/assets/
- To: /public/assets/

2. Update asset references in Blade templates:
```php
<!-- Example image reference -->
<img src="{{ asset('assets/logo.png') }}" alt="KessExpress Logo">
```

## 7. Styling Migration (Partially from Original Guide)
1. Install Tailwind CSS in Laravel (if not already done as per section 2.3):
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

2. Configure Tailwind CSS (as per original guide section 6.2):
```js
// tailwind.config.js
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      // Copy current theme configuration
    },
  },
  plugins: [],
}
```


## 8.  Component Migration (Partially from Original Guide)
### Convert React Components to Blade Components:

#### Headers & Navigation (From Original Guide)
```php
<!-- resources/views/components/layout/navbar.blade.php -->
<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Convert current Navbar.tsx content -->
        <x-navigation-menu />
    </div>
</nav>
```

#### Pages (From Original Guide)
Convert each React page in `/client/src/pages/` to a Blade view:
- Home.tsx → resources/views/pages/home.blade.php
- About.tsx → resources/views/pages/about.blade.php
- Services.tsx → resources/views/pages/services.blade.php
- Contact.tsx → resources/views/pages/contact.blade.php
- Consultation.tsx → resources/views/pages/consultation.blade.php


## 9. Database Migration (Partially from Original Guide)

### Create Migrations (From Original Guide)
```bash
php artisan make:migration create_users_table
php artisan make:migration create_services_table
php artisan make:migration create_consultations_table
```

### Models Setup (From Original Guide)
Create corresponding Laravel models:
```bash
php artisan make:model Service
php artisan make:model Consultation