# HTTP 500 Error Troubleshooting Guide

## 🔍 **Common Causes of HTTP 500 Errors**

### 1. **Configuration Issues**

#### **SITE_URL Configuration**
The `config/config.php` file has `SITE_URL` set to `localhost:8000`. This needs to be updated for production:

```php
// Change this line in config/config.php
define('SITE_URL', 'https://your-domain.com'); // Update with your actual domain
```

#### **Supabase Credentials**
Make sure your Supabase credentials are properly configured:

```php
// In config/config.php
define('SUPABASE_URL', 'https://your-project.supabase.co');
define('SUPABASE_ANON_KEY', 'your-actual-anon-key');
define('SUPABASE_SERVICE_ROLE_KEY', 'your-actual-service-role-key');
```

### 2. **File Permissions**
Ensure proper file permissions on your server:

```bash
# Set proper permissions
chmod 644 *.php
chmod 755 */
chmod 644 config/*.php
chmod 644 includes/*.php
chmod 644 pages/*.php
```

### 3. **PHP Version Compatibility**
Your server needs PHP 8.0 or higher. Check with:

```php
<?php echo phpversion(); ?>
```

### 4. **Required Extensions**
Make sure these PHP extensions are installed:
- `curl`
- `json`
- `mbstring`
- `xml`

## 🛠️ **Debugging Steps**

### Step 1: Enable Error Display
Add this to the top of your `index.php`:

```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
?>
```

### Step 2: Check Server Error Logs
Look for error logs in:
- `/var/log/apache2/error.log` (Apache)
- `/var/log/nginx/error.log` (Nginx)
- Your hosting provider's error log

### Step 3: Test Individual Files
Create a simple test file to check each component:

```php
<?php
// test.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing configuration...\n";

try {
    require_once 'config/config.php';
    echo "✅ Config loaded\n";
} catch (Exception $e) {
    echo "❌ Config error: " . $e->getMessage() . "\n";
}

try {
    require_once 'config/supabase_client.php';
    echo "✅ Supabase client loaded\n";
} catch (Exception $e) {
    echo "❌ Supabase error: " . $e->getMessage() . "\n";
}

try {
    require_once 'includes/functions.php';
    echo "✅ Functions loaded\n";
} catch (Exception $e) {
    echo "❌ Functions error: " . $e->getMessage() . "\n";
}

try {
    require_once 'includes/auth.php';
    echo "✅ Auth loaded\n";
} catch (Exception $e) {
    echo "❌ Auth error: " . $e->getMessage() . "\n";
}
?>
```

### Step 4: Check File Structure
Ensure all required files are uploaded:

```
your-project/
├── index.php
├── config/
│   ├── config.php
│   └── supabase_client.php
├── includes/
│   ├── auth.php
│   ├── functions.php
│   ├── header.php
│   ├── footer.php
│   └── layout.php
├── pages/
│   ├── home.php
│   ├── 404.php
│   └── ... (other pages)
└── public/
    ├── css/
    ├── js/
    └── images/
```

## 🚨 **Common Issues & Solutions**

### Issue 1: "Headers already sent"
**Cause:** Whitespace or output before `session_start()`
**Solution:** Remove all whitespace before `<?php` tags

### Issue 2: "Class not found"
**Cause:** Missing file or incorrect include path
**Solution:** Check file paths and ensure all files are uploaded

### Issue 3: "Undefined constant"
**Cause:** Configuration constants not defined
**Solution:** Check `config/config.php` file

### Issue 4: "Curl error"
**Cause:** cURL extension not installed or network issues
**Solution:** Install cURL extension or check network connectivity

### Issue 5: "Database connection failed"
**Cause:** Supabase credentials incorrect or network issues
**Solution:** Verify Supabase credentials and check network

## 📋 **Quick Fix Checklist**

- [ ] Update `SITE_URL` in `config/config.php`
- [ ] Configure Supabase credentials
- [ ] Check file permissions (644 for files, 755 for directories)
- [ ] Verify PHP version (8.0+)
- [ ] Install required extensions (curl, json, mbstring, xml)
- [ ] Check server error logs
- [ ] Test with debug scripts
- [ ] Ensure all files are uploaded
- [ ] Remove any whitespace before `<?php` tags

## 🔧 **Debug Scripts**

Use the provided debug scripts:
1. `debug.php` - Comprehensive system check
2. `error_handler.php` - Detailed error reporting
3. `test_connection.php` - Connection testing

## 📞 **Getting Help**

If you're still getting HTTP 500 errors:

1. **Run the debug script:** `php debug.php`
2. **Check server logs** for specific error messages
3. **Test individual files** using the error handler
4. **Verify your hosting environment** meets requirements
5. **Contact your hosting provider** if server-side issues persist

## ✅ **Production Checklist**

Before going live:
- [ ] Update all URLs to production domain
- [ ] Configure Supabase credentials
- [ ] Set proper file permissions
- [ ] Test all functionality
- [ ] Enable error logging (disable display_errors in production)
- [ ] Set up SSL certificate
- [ ] Configure automatic updates 