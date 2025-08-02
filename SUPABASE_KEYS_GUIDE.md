# 🔑 Supabase Keys Configuration Guide

## 📋 **Supabase Keys Explained**

### **1. Publishable Key - ✅ Use This for User Operations**
- **Location:** Supabase Dashboard > Settings > API > anon public
- **What it does:** Read data, insert data (with RLS policies), user authentication
- **Security:** Safe to expose in frontend code
- **Your current config:** ✅ Already configured correctly

### **2. Secret Key - ⚠️ For Admin Operations**
- **Location:** Supabase Dashboard > Settings > API > service_role
- **What it does:** Bypass RLS, full database access, admin operations
- **Security:** Never expose in frontend, only use server-side
- **Your current config:** ❌ Needs to be updated

## 🛠️ **How to Get Your Keys**

### **Step 1: Access Supabase Dashboard**
1. Go to [supabase.com](https://supabase.com)
2. Sign in to your account
3. Select your project: `truyxgamywbkuovyzlhe`

### **Step 2: Get the Secret Key**
1. In your project dashboard, go to **Settings** (gear icon)
2. Click on **API** in the sidebar
3. Scroll down to **Project API keys**
4. Copy the **service_role** key (starts with `eyJ...`)

### **Step 3: Update Your Config**
Replace the placeholder in `config/config.php`:

```php
// Replace this line:
define('SUPABASE_SECRET_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRydXl4Z2FteXdia3Vvdnl6bGhlIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1Mjg0NTAwOSwiZXhwIjoyMDY4NDIxMDA5fQ.YOUR_SECRET_KEY_HERE');

// With your actual secret key:
define('SUPABASE_SECRET_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRydXl4Z2FteXdia3Vvdnl6bGhlIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1Mjg0NTAwOSwiZXhwIjoyMDY4NDIxMDA5fQ.ACTUAL_SECRET_KEY_HERE');
```

## 🔒 **Modern API Security Best Practices**

### **✅ Do This:**
- Use **publishable key** for user operations (registration, login, reading data)
- Use **secret key** only for admin operations (bypassing RLS)
- Keep secret key secret and server-side only
- Use Row Level Security (RLS) policies in Supabase
- Use modern authentication methods (authSignUp, authSignIn)

### **❌ Don't Do This:**
- Never expose secret key in frontend code
- Don't commit real keys to public repositories
- Don't use secret key for regular user operations
- Don't use legacy authentication methods

## 🧪 **Test Your Configuration**

Run this test to verify your keys work:

```bash
# Visit this URL to test your Supabase connection
yourdomain.com/test_connection.php
```

## 📊 **Current Key Status**

| Key Type | Status | Location |
|----------|--------|----------|
| **Publishable Key** | ✅ Configured | `config/config.php` line 9 |
| **Secret Key** | ❌ Needs Update | `config/config.php` line 12 |

## 🔧 **Troubleshooting**

### **Error: "Invalid API key"**
- Check that you copied the entire key (starts and ends with `eyJ...`)
- Make sure there are no extra spaces or characters

### **Error: "Permission denied"**
- For user operations: Use anon key
- For admin operations: Use service role key
- Check your RLS policies in Supabase

### **Error: "Table doesn't exist"**
- Create the required tables in Supabase:
  - `users`
  - `products`
  - `orders`
  - `contact_messages`
  - `newsletter_subscribers`

## 📝 **Quick Setup Checklist**

- [ ] Get service role key from Supabase Dashboard
- [ ] Update `config/config.php` with real service role key
- [ ] Test connection with `test_connection.php`
- [ ] Create required database tables
- [ ] Set up RLS policies in Supabase

## 🆘 **Need Help?**

If you're still having issues:
1. Check the Supabase Dashboard for any error messages
2. Verify your project URL is correct
3. Make sure your database tables exist
4. Test with the provided test scripts

Your anon key is already working correctly! You just need to add the service role key for admin operations. 