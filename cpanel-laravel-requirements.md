# Laravel Requirements for cPanel

## 1. PHP Requirements
- PHP Version: 8.1 or higher
- Required Extensions:
  * BCMath PHP Extension
  * Ctype PHP Extension
  * Fileinfo PHP Extension
  * JSON PHP Extension
  * Mbstring PHP Extension
  * OpenSSL PHP Extension
  * PDO PHP Extension
  * Tokenizer PHP Extension
  * XML PHP Extension

## 2. Database Requirements
- MySQL 5.7+ or MariaDB 10.3+
- Database name
- Database username
- Database password

## 3. Directory Structure
```
public_html/
└── kessexpress/
    ├── public/     # Document root (755)
    ├── storage/    # Storage directory (755)
    └── bootstrap/  # Bootstrap directory
        └── cache/  # Cache directory (755)
```

## 4. File Permissions
- Directories: 755
- Files: 644
- Storage and cache directories: 775
