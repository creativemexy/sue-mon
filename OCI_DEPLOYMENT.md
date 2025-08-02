# OCI Deployment Guide for Sue & Mon PHP Website

This guide will help you deploy the Sue & Mon PHP website on Oracle Cloud Infrastructure (OCI) with Caddy web server and automatic updates, using Supabase as the database.

## 🚀 **Prerequisites**

- OCI instance running Ubuntu 20.04 or later
- Root access to the server
- Domain name pointing to your OCI instance
- GitHub repository access
- Supabase project with API keys

## 📋 **Step 1: Server Setup**

### 1.1 Update System
```bash
sudo apt update && sudo apt upgrade -y
```

### 1.2 Install Required Software
```bash
# Install PHP and extensions
sudo apt install -y php8.1 php8.1-fpm php8.1-curl php8.1-gd php8.1-mbstring php8.1-xml php8.1-zip php8.1-json

# Install Caddy
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update
sudo apt install caddy

# Install Git
sudo apt install -y git
```

## 🗄️ **Step 2: Supabase Setup**

### 2.1 Get Your Supabase Credentials
1. Go to your Supabase project dashboard
2. Navigate to Settings > API
3. Copy the following:
   - **Project URL** (e.g., `https://your-project.supabase.co`)
   - **Anon Key** (public key)
   - **Service Role Key** (secret key)

### 2.2 Verify Database Schema
Your Supabase database should have the following tables (from `database/schema.sql`):
- `users`
- `products`
- `categories`
- `orders`
- `order_items`
- `cart_items`
- `blog_posts`
- `contact_messages`

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

Update the configuration with your Supabase credentials:
```php
<?php
// Site Configuration
define('SITE_NAME', 'Sue & Mon');
define('SITE_DESCRIPTION', 'Premium Herbal Blends');
define('SITE_URL', 'https://your-domain.com'); // Change for production

// Supabase Configuration
define('SUPABASE_URL', 'https://your-project.supabase.co');
define('SUPABASE_ANON_KEY', 'your-supabase-anon-key');
define('SUPABASE_SERVICE_ROLE_KEY', 'your-supabase-service-role-key');

// Paystack Configuration (if using)
define('PAYSTACK_SECRET_KEY', 'your_secret_key');
define('PAYSTACK_PUBLIC_KEY', 'your_public_key');

// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your_email@gmail.com');
define('SMTP_PASS', 'your_app_password');

// Session Configuration
define('SESSION_LIFETIME', 3600); // 1 hour

// Currency
define('CURRENCY', 'NGN');
define('CURRENCY_SYMBOL', '₦');

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// Helper function for asset URLs
function asset($path) {
    return SITE_URL . '/public/' . ltrim($path, '/');
}

// Helper function for URLs
function url($path = '') {
    return SITE_URL . '/' . ltrim($path, '/');
}
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

# Backup application files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/sue-mon

# Note: Supabase backups are handled by Supabase
# You can export data via Supabase dashboard if needed

# Keep only last 7 days of backups
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

3. **Supabase connection issues:**
   - Verify your Supabase URL and keys
   - Check if your Supabase project is active
   - Ensure your IP is not blocked by Supabase

4. **Permission issues:**
   ```bash
   sudo chown -R www-data:www-data /var/www/sue-mon
   sudo chmod -R 755 /var/www/sue-mon
   ```

## 📞 **Support**

- **Application Logs:** `/var/www/sue-mon/auto_update.log`
- **Caddy Logs:** `sudo journalctl -u caddy`
- **PHP Logs:** `/var/log/php8.1-fpm.log`
- **Supabase Logs:** Check your Supabase dashboard

## ✅ **Verification Checklist**

- [ ] Website loads at your domain
- [ ] Supabase connection works
- [ ] Admin panel accessible
- [ ] SSL certificate active
- [ ] Automatic updates working
- [ ] Backups configured
- [ ] Monitoring in place

Your Sue & Mon PHP website is now deployed on OCI with Supabase database and automatic updates every 30 minutes! 