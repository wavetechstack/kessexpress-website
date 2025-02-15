### 1.2 Build Application
```bash
# Build frontend for production
npm run build
```

### 1.3 Download Application Files
1. In Replit:
   - Click the three dots (⋮) menu
   - Select "Download as zip"
   - Save the zip file locally

### 1.4 Save Environment Variables
1. In Replit:
   - Go to "Secrets"
   - Copy all environment variables
   - Create a new `.env` file with:
   ```env
   NODE_ENV=production
   PORT=3000
   DATABASE_URL=postgres://username:password@localhost:5432/kessexpress
   # Add other necessary variables
   ```

## 2. cPanel Setup

### 2.1 Database Setup
1. In cPanel:
   - Go to "PostgreSQL Databases"
   - Create new database named "kessexpress"
   - Create database user
   - Grant user permissions
   - Note down the credentials

### 2.2 Node.js Setup
1. In cPanel:
   - Go to "Setup Node.js App"
   - Click "Create Application"
   - Set Node.js version to 18.x
   - Application path: /home/username/kessexpress
   - Application URL: yourdomain.com
   - Startup file: server/index.ts
   - Application mode: Production

### 2.3 Upload Files
1. Using File Manager in cPanel:
   - Navigate to your home directory
   - Create "kessexpress" folder
   - Upload the zip file
   - Extract contents
   - Set permissions:
     * Directories: 755
     * Files: 644

### 2.4 Configure Application
1. Create `.env` file:
   - Open File Manager
   - Navigate to application folder
   - Create new file named `.env`
   - Add environment variables using cPanel credentials

2. Install Dependencies:
```bash
cd ~/kessexpress
npm install
```

### 2.5 Import Database
1. In cPanel:
   - Go to "PostgreSQL Databases"
   - Use phpPgAdmin or command line:
   ```bash
   psql -U your_db_user -d kessexpress < kessexpress_backup.sql
   ```

# Troubleshooting 403 Forbidden Error

### 1. Check File Permissions
```bash
# Set correct permissions for directories
find /home/username/kessexpress -type d -exec chmod 755 {} \;

# Set correct permissions for files
find /home/username/kessexpress -type f -exec chmod 644 {} \;
```

### 2. Verify Node.js Configuration
1. In cPanel:
   - Go to "Setup Node.js App"
   - Verify application settings:
     * Application Path: /home/username/kessexpress
     * Application URL: yourdomain.com
     * Application Root: public_html/kessexpress
     * Application Mode: Production
     * Node.js Version: 18.x

### 3. Check Domain Configuration
1. In cPanel:
   - Go to "Domains"
   - Ensure domain points to: /home/username/kessexpress
   - Document Root should be: public_html/kessexpress

### 4. Verify .htaccess
Create or update .htaccess file in your application root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ http://localhost:3000/$1 [P,L]
</IfModule>

# Allow access to Node.js application
<Files *>
    Order Allow,Deny
    Allow from all
</Files>
```

### 5. Restart Application
1. In cPanel:
   - Go to "Setup Node.js App"
   - Find your application
   - Click "Restart"
   - Check logs for any errors

### 6. Test Access
```bash
# Test domain resolution
curl -I yourdomain.com

# Check application logs
tail -f /home/username/kessexpress/logs/error.log