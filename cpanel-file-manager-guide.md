storage/
├── framework/
│   ├── sessions/
│   ├── views/
│   └── cache/
└── logs/

bootstrap/
└── cache/
```

## 2. Set File Permissions
1. For storage directory:
   - Right-click on 'storage' folder
   - Select "Change Permissions"
   - Check boxes for:
     * Owner: Read, Write, Execute (7)
     * Group: Read, Write, Execute (7)
     * World: Read, Execute (5)
   - Check "Recurse into subdirectories"
   - Click "Change Permissions"

2. For bootstrap/cache:
   - Right-click on 'bootstrap/cache' folder
   - Repeat the same permission settings as above

3. For .env file:
   - Right-click on .env file
   - Select "Change Permissions"
   - Set to 644 (Owner: rw, Group: r, World: r)

## 3. Configure .env File
1. Right-click on .env file → Edit
2. Update these settings:
```env
APP_NAME=KessExpress
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password