# OCI Deployment Guide for Sue & Mon PHP Website

This guide will help you deploy the Sue & Mon PHP website on Oracle Cloud Infrastructure (OCI) with Caddy web server and automatic updates.

## 🚀 **Prerequisites**

- OCI instance running Ubuntu 20.04 or later
- Root access to the server
- Domain name pointing to your OCI instance
- GitHub repository access

## 📋 **Step 1: Server Setup**

### 1.1 Update System
```bash
sudo apt update && sudo apt upgrade -y
```

### 1.2 Install Required Software
```bash
# Install PHP and extensions
sudo apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-curl php8.1-gd php8.1-mbstring php8.1-xml php8.1-zip

# Install MySQL
sudo apt install -y mysql-server

# Install Caddy
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update
sudo apt install caddy

# Install Git
sudo apt install -y git
```

## 🗄️ **Step 2: Database Setup**

### 2.1 Secure MySQL
```bash
sudo mysql_secure_installation
```

### 2.2 Create Database
```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE sue_mon_db;
CREATE USER 'sue_mon_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON sue_mon_db.* TO 'sue_mon_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2.3 Import Database Schema
```bash
cd /var/www
git clone https://github.com/yourusername/sue-mon.git
cd sue-mon
mysql -u root -p sue_mon_db < database/schema.sql
```

## 🌐 **Step 3: Caddy Configuration**

### 3.1 Create Caddyfile
```bash
sudo nano /etc/caddy/Caddyfile
```

Add the following configuration:
```
your-domain.com {
    root * /var/www/sue-mon
    php_fastcgi unix//run/php/php8.1-fpm.sock
    file_server
    encode gzip
    
    # Security headers
    header {
        X-Content-Type-Options nosniff
        X-Frame-Options DENY
        X-XSS-Protection "1; mode=block"
        Referrer-Policy "strict-origin-when-cross-origin"
    }
    
    # Handle PHP files
    @phpFiles {
        path *.php
    }
    handle @phpFiles {
        php_fastcgi unix//run/php/php8.1-fpm.sock
    }
    
    # Handle static files
    @staticFiles {
        path *.css *.js *.png *.jpg *.jpeg *.gif *.ico *.svg *.woff *.woff2 *.ttf *.eot
    }
    handle @staticFiles {
        file_server
    }
    
    # Handle all other requests
    handle {
        try_files {path} {path}/ /index.php?{query}
    }
}
```

### 3.2 Test and Reload Caddy
```bash
sudo caddy validate --config /etc/caddy/Caddyfile
sudo systemctl reload caddy
```

## ⚙️ **Step 4: Application Configuration**

### 4.1 Set File Permissions
```bash
sudo chown -R www-data:www-data /var/www/sue-mon
sudo chmod -R 755 /var/www/sue-mon
sudo find /var/www/sue-mon -type f -name "*.php" -exec chmod 644 {} \;
```

### 4.2 Configure PHP Application
```bash
cd /var/www/sue-mon
cp config/config.example.php config/config.php
sudo nano config/config.php
```

Update the configuration with your database credentials:
```php
<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'sue_mon_db');
define('DB_USER', 'sue_mon_user');
define('DB_PASS', 'your_secure_password');

// Site Configuration
define('SITE_URL', 'https://your-domain.com');
define('SITE_NAME', 'Sue & Mon');

// Paystack Configuration (if using)
define('PAYSTACK_SECRET_KEY', 'your_secret_key');
define('PAYSTACK_PUBLIC_KEY', 'your_public_key');

// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your_email@gmail.com');
define('SMTP_PASS', 'your_app_password');
?>
```

## 🔄 **Step 5: Automatic Updates Setup**

### 5.1 Set Up Cron Job
```bash
cd /var/www/sue-mon
sudo chmod +x auto_update.sh setup_cron.sh
sudo ./setup_cron.sh
```

### 5.2 Verify Cron Job
```bash
sudo crontab -u www-data -l
```

You should see:
```
*/30 * * * * /var/www/sue-mon/auto_update.sh
```

### 5.3 Test Automatic Updates
```bash
# Check if the script works
sudo -u www-data /var/www/sue-mon/auto_update.sh

# Check logs
tail -f /var/www/sue-mon/auto_update.log
```

## 🔒 **Step 6: Security Hardening**

### 6.1 Configure Firewall
```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 6.2 Set Up SSL (Automatic with Caddy)
Caddy automatically handles SSL certificates. Just ensure your domain is properly configured.

### 6.3 PHP Security
```bash
sudo nano /etc/php/8.1/fpm/php.ini
```

Add/modify these settings:
```ini
expose_php = Off
max_execution_time = 30
memory_limit = 128M
upload_max_filesize = 10M
post_max_size = 10M
```

### 6.4 Restart Services
```bash
sudo systemctl restart php8.1-fpm
sudo systemctl restart caddy
```

## 📊 **Step 7: Monitoring and Maintenance**

### 7.1 Check Service Status
```bash
sudo systemctl status caddy
sudo systemctl status php8.1-fpm
sudo systemctl status mysql
```

### 7.2 Monitor Logs
```bash
# Caddy logs
sudo journalctl -u caddy -f

# PHP-FPM logs
sudo tail -f /var/log/php8.1-fpm.log

# Application logs
tail -f /var/www/sue-mon/auto_update.log
```

### 7.3 Backup Strategy
```bash
# Create backup script
sudo nano /usr/local/bin/backup-sue-mon.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/sue-mon"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u root -p sue_mon_db > $BACKUP_DIR/database_$DATE.sql

# Backup application files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/sue-mon

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

```bash
sudo chmod +x /usr/local/bin/backup-sue-mon.sh
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-sue-mon.sh
```

## 🚨 **Troubleshooting**

### Common Issues:

1. **Caddy won't start:**
   ```bash
   sudo caddy validate --config /etc/caddy/Caddyfile
   sudo journalctl -u caddy -n 50
   ```

2. **PHP errors:**
   ```bash
   sudo tail -f /var/log/php8.1-fpm.log
   sudo systemctl restart php8.1-fpm
   ```

3. **Database connection issues:**
   ```bash
   sudo mysql -u root -p
   SHOW GRANTS FOR 'sue_mon_user'@'localhost';
   ```

4. **Permission issues:**
   ```bash
   sudo chown -R www-data:www-data /var/www/sue-mon
   sudo chmod -R 755 /var/www/sue-mon
   ```

## 📞 **Support**

- **Application Logs:** `/var/www/sue-mon/auto_update.log`
- **Caddy Logs:** `sudo journalctl -u caddy`
- **PHP Logs:** `/var/log/php8.1-fpm.log`
- **MySQL Logs:** `/var/log/mysql/error.log`

## ✅ **Verification Checklist**

- [ ] Website loads at your domain
- [ ] Database connection works
- [ ] Admin panel accessible
- [ ] SSL certificate active
- [ ] Automatic updates working
- [ ] Backups configured
- [ ] Monitoring in place

Your Sue & Mon PHP website is now deployed on OCI with automatic updates every 30 minutes! 