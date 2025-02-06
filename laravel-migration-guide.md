# Migration Guide: React to Laravel for KessExpress

## 1. Project Setup
1. Create a new Laravel project on your local development environment:
```bash
composer create-project laravel/laravel kessexpress
cd kessexpress
```

2. Required Laravel Packages:
```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
```

## 2. Directory Structure Conversion

### Current React Structure to Laravel Mapping:
```
React                          Laravel
--------------------------------------------
/client/src/pages/            /resources/views/
/client/src/components/       /resources/views/components/
/server/routes.ts            /routes/web.php & /routes/api.php
/db/schema.ts               /database/migrations/
```

## 3. Component Migration

### Convert React Components to Blade Components:

#### Headers & Navigation
```php
<!-- resources/views/components/layout/navbar.blade.php -->
<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Convert current Navbar.tsx content -->
        <x-navigation-menu />
    </div>
</nav>
```

#### Pages
Convert each React page in `/client/src/pages/` to a Blade view:
- Home.tsx → resources/views/home.blade.php
- About.tsx → resources/views/about.blade.php
- Services.tsx → resources/views/services.blade.php
- Contact.tsx → resources/views/contact.blade.php
- Consultation.tsx → resources/views/consultation.blade.php

## 4. Database Migration

### Create Migrations
```bash
php artisan make:migration create_users_table
php artisan make:migration create_services_table
php artisan make:migration create_consultations_table
```

### Models Setup
Create corresponding Laravel models:
```bash
php artisan make:model Service
php artisan make:model Consultation
```

## 5. Asset Migration

1. Move all static assets:
- From: /client/src/assets/
- To: /public/assets/

2. Update asset references in Blade templates:
```php
<!-- Example image reference -->
<img src="{{ asset('assets/logo.png') }}" alt="KessExpress Logo">
```

## 6. Styling Migration

1. Install Tailwind CSS in Laravel:
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

2. Configure Tailwind CSS:
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

## 7. GoDaddy Hosting Deployment

1. Domain and Hosting Setup:
- Log into GoDaddy hosting control panel
- Set up a new hosting account if not already done
- Point domain to GoDaddy nameservers

2. Database Setup:
- Create new MySQL database through GoDaddy hosting panel
- Update `.env` file with GoDaddy database credentials

3. Application Deployment:
- Upload Laravel application files via FTP
- Set document root to `/public` directory
- Configure `.htaccess` for Laravel routing:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

4. Environment Setup:
- Copy `.env.example` to `.env`
- Update environment variables:
```env
APP_URL=https://yourdomain.com
DB_HOST=your_godaddy_db_host
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

5. Final Steps:
- Run migrations on GoDaddy server
- Cache configuration and routes:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 8. Post-Deployment Checklist

- [ ] Verify all routes are working
- [ ] Test contact forms and consultations
- [ ] Confirm email configurations
- [ ] Test database connections
- [ ] Verify SSL certificate installation
- [ ] Check mobile responsiveness
- [ ] Test loading speed and optimization

## 9. Maintenance Considerations

1. Regular Updates:
- Keep Laravel framework updated
- Monitor security patches
- Update dependencies regularly

2. Backup Strategy:
- Configure regular database backups
- Set up file system backups
- Document recovery procedures

3. Monitoring:
- Set up error logging
- Configure performance monitoring
- Implement uptime monitoring

## Support and Resources

- Laravel Documentation: https://laravel.com/docs
- GoDaddy Hosting Support: https://www.godaddy.com/help
- Laravel Community: https://laracasts.com/discuss
