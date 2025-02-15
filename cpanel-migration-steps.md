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

## 9. SSL and DNS Troubleshooting

### 9.1 Fix AutoSSL Errors
1. Clean up problematic domains:
   - Remove any incorrect domain entries (e.g., *.premiumresidential.org)
   - Keep only the domains you need: kessexpress.com, www.kessexpress.com, mail.kessexpress.com

2. Verify DNS Records in cPanel:
   ```bash
   # Check current DNS records
   dig kessexpress.com
   dig www.kessexpress.com
   ```
   The output should show your cPanel server's IP address.

3. Update DNS Zone in cPanel:
   - Go to "Zone Editor"
   - Add/Update A records:
     ```
     Type  Name                     Value
     A     kessexpress.com         [Your-Server-IP]
     A     www.kessexpress.com     [Your-Server-IP]
     A     mail.kessexpress.com    [Your-Server-IP]
     ```
   - Remove any conflicting records
   - Save changes

4. Clear DNS Cache:
   ```bash
   # Windows
   ipconfig /flushdns

   # Linux
   sudo systemctl restart systemd-resolved

   # MacOS
   sudo killall -HUP mDNSResponder
   ```

5. Verify Domain Resolution:
   ```bash
   # Test each domain
   curl -I https://kessexpress.com
   curl -I https://www.kessexpress.com
   curl -I https://mail.kessexpress.com
   ```

6. Run AutoSSL:
   - Wait 15-30 minutes after DNS changes
   - Go to cPanel > SSL/TLS Status
   - Click "Run AutoSSL"
   - Check the status for each domain

### 9.2 Troubleshooting
If AutoSSL still fails:
1. Verify domain ownership in cPanel
2. Check for existing SSL certificates
3. Clear SSL cache if necessary
4. Ensure proper file permissions
5. Check error logs in cPanel

### 9.3 Common Error Messages

#### DNS Resolution Errors
If you see errors like:
```
DNS DCv; no local authority; "domain.com" does not resolve to any IP addresses on the internet.
```
This means:
- The domain is not properly configured in DNS
- The A record is missing or incorrect
- DNS changes haven't propagated yet

Fix by:
1. Verifying A records in Zone Editor
2. Waiting for DNS propagation (15-30 minutes)
3. Testing with `dig` command

#### Certificate Generation Errors
If you see:
```
The system queried for a temporary file at [path] but the web server returned [error]
```
This indicates:
- Web server configuration issues
- File permission problems
- Virtual host misconfiguration

Fix by:
1. Checking file permissions
2. Verifying virtual host configuration
3. Ensuring .well-known directory is accessible

### 9.4 Resolving Premiumresidential.org Issues

If you see errors related to *.premiumresidential.org:
1. Remove unwanted domain entries:
   - In cPanel > Domains, find and remove any entries with premiumresidential.org
   - These are typically residual entries from previous configurations

2. Clean up SSL certificates:
   ```bash
   # Check existing certificates
   ls -la /etc/ssl/certs/