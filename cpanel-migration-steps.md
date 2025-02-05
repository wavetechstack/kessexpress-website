# Detailed cPanel Migration Steps

## 1. Export Data from Replit

### 1.1 Database Export
```bash
# In Replit's shell:
pg_dump $DATABASE_URL > kessexpress_backup.sql
```

### 1.2 Download Application Code
1. In Replit:
   - Click the three dots (⋮) menu in top-right
   - Select "Export"
   - Click "Download as zip"

### 1.3 Save Environment Variables
1. In Replit:
   - Go to "Tools" -> "Secrets"
   - Copy all environment variables
   - Save them in a secure text file

## 2. cPanel Setup Steps

### 2.1 Set Up Database
1. In cPanel:
   - Click "MySQL® Databases" or "PostgreSQL Databases"
   - Create a new database named "kessexpress"
   - Create a database user
   - Add user to database with all privileges
   - Save the database credentials

### 2.2 Set Up Node.js
1. In cPanel:
   - Go to "Setup Node.js App"
   - Click "Create Application"
   - Choose Node.js version 18.x
   - Set application path: /home/username/public_html/kessexpress
   - Set application URL: kessexpress.com
   - Set application startup file: server/index.ts
   - Set application mode: Production

### 2.3 Upload Application Files
1. In cPanel File Manager:
   - Navigate to public_html
   - Create folder "kessexpress"
   - Upload your Replit zip file
   - Extract the contents
   - Delete the zip file

### 2.4 Configure Application
1. Create/edit `.env` file:
```env
NODE_ENV=production
PORT=3000
DATABASE_URL=postgres://username:password@localhost:5432/kessexpress
```

2. Update package.json scripts:
```json
{
  "scripts": {
    "start": "tsx server/index.ts",
    "build": "vite build"
  }
}
```

### 2.5 Install Dependencies and Build
In cPanel Terminal:
```bash
cd ~/public_html/kessexpress
npm install
npm run build
```

### 2.6 Import Database
In cPanel Terminal:
```bash
psql -U your_db_user -d kessexpress < kessexpress_backup.sql
```

### 2.7 Configure Domain
1. In cPanel:
   - Go to "Domains"
   - Point kessexpress.com to /home/username/public_html/kessexpress
   - Set up SSL if needed via "SSL/TLS Status"

### 2.8 Start Application
1. In cPanel:
   - Go to "Setup Node.js App"
   - Select your application
   - Click "Start Application"
   - Check logs for any errors

## 3. Verification Steps

### 3.1 Check Application
1. Visit kessexpress.com
2. Verify all pages load
3. Test all features
4. Check mobile responsiveness

### 3.2 Check Database
1. In cPanel:
   - Go to phpPgAdmin or similar
   - Verify all tables are present
   - Check sample data

### 3.3 Monitor Logs
1. In cPanel:
   - Go to "Errors" or "Logs"
   - Check for any errors
   - Monitor application logs

## 4. Troubleshooting Common Issues

### 4.1 Database Connection
If database connection fails:
1. Verify DATABASE_URL in .env
2. Check database user permissions
3. Verify database host (usually localhost)

### 4.2 Application Errors
If application doesn't start:
1. Check Node.js logs
2. Verify all dependencies are installed
3. Check file permissions (should be 644 for files, 755 for directories)

### 4.3 Domain Issues
If domain doesn't work:
1. Check DNS propagation
2. Verify domain configuration in cPanel
3. Check SSL certificate status
