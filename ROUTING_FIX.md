# Routing Fix Guide - Page Not Found Issues

## 🔍 **Diagnosis Steps**

### Step 1: Check Your Server Type
First, determine what type of server you're using:

1. **Check if .htaccess works:**
   - Create a test file: `test_htaccess.php`
   - Add this content:
   ```php
   <?php
   echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
   echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
   echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
   echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
   ?>
   ```

2. **Check if mod_rewrite is enabled:**
   - Create: `check_rewrite.php`
   ```php
   <?php
   if (function_exists('apache_get_modules')) {
       $modules = apache_get_modules();
       if (in_array('mod_rewrite', $modules)) {
           echo "✅ mod_rewrite is enabled";
       } else {
           echo "❌ mod_rewrite is NOT enabled";
       }
   } else {
       echo "⚠️ Cannot check mod_rewrite status";
   }
   ?>
   ```

## 🛠️ **Solutions by Server Type**

### **Apache Server (Most Common)**

#### Option 1: Enable mod_rewrite
```bash
# On your server, run:
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Option 2: Alternative .htaccess
If mod_rewrite doesn't work, try this simpler version:
```apache
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
```

### **Nginx Server**

Add this to your nginx configuration:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### **Caddy Server**

Your Caddyfile should include:
```
your-domain.com {
    root * /var/www/sue-mon
    php_fastcgi unix//run/php/php8.1-fpm.sock
    file_server
    try_files {path} {path}/ /index.php?{query}
}
```

### **Shared Hosting**

If you're on shared hosting, try this `.htaccess`:
```apache
Options +FollowSymLinks
RewriteEngine On
RewriteBase /

# Handle requests for existing files
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

# Handle all other requests
RewriteRule ^(.*)$ index.php [QSA,L]
```

## 🔧 **Alternative Solutions**

### **Solution 1: Direct File Access**
If routing doesn't work, you can access pages directly:
- Login: `yourdomain.com/pages/auth/login.php`
- Register: `yourdomain.com/pages/auth/register.php`

### **Solution 2: Simple Router**
Create a new `router.php` file:
```php
<?php
// Simple router for servers without mod_rewrite
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');

if (empty($path)) {
    include 'pages/home.php';
} elseif ($path === 'auth/login') {
    include 'pages/auth/login.php';
} elseif ($path === 'auth/register') {
    include 'pages/auth/register.php';
} elseif ($path === 'shop') {
    include 'pages/shop.php';
} else {
    include 'pages/404.php';
}
?>
```

Then update your `index.php` to use this router.

### **Solution 3: URL Parameters**
Modify your links to use parameters:
- Login: `yourdomain.com/index.php?page=auth/login`
- Register: `yourdomain.com/index.php?page=auth/register`

Update `index.php`:
```php
<?php
session_start();
require_once 'config/config.php';
require_once 'config/supabase_client.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

$auth = new Auth();

// Get page from URL parameter
$page = $_GET['page'] ?? 'home';

// Route definitions
$routes = [
    'home' => 'pages/home.php',
    'auth/login' => 'pages/auth/login.php',
    'auth/register' => 'pages/auth/register.php',
    'shop' => 'pages/shop.php',
    // ... other routes
];

if (isset($routes[$page]) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    include 'pages/404.php';
}
?>
```

## 📋 **Testing Steps**

1. **Upload the test files:**
   - `test_htaccess.php`
   - `check_rewrite.php`
   - `test_routing.php`

2. **Visit these URLs:**
   - `yourdomain.com/test_htaccess.php`
   - `yourdomain.com/check_rewrite.php`
   - `yourdomain.com/test_routing.php`

3. **Check the results** and follow the appropriate solution

## 🚨 **Common Issues**

### **Issue 1: "mod_rewrite not enabled"**
**Solution:** Contact your hosting provider to enable mod_rewrite

### **Issue 2: ".htaccess not allowed"**
**Solution:** Use the URL parameters approach (Solution 3)

### **Issue 3: "Server not Apache"**
**Solution:** Use the appropriate server configuration above

### **Issue 4: "Still getting 404"**
**Solution:** Try the direct file access approach (Solution 1)

## 📞 **Next Steps**

1. **Run the test files** to diagnose your server
2. **Choose the appropriate solution** based on your server type
3. **Implement the fix** for your specific setup
4. **Test the auth pages** again

Let me know what the test files show, and I'll provide the exact solution for your server! 