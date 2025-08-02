# 🔑 Supabase Keys Configuration Guide

## 📋 **Key Types Explained**

### **1. Publishable Key (Anon Key) - ✅ Use This for Most Operations**
- **Location:** Supabase Dashboard > Settings > API > anon public
- **What it does:** Read data, insert data (with RLS policies)
- **Security:** Safe to expose in frontend code
- **Your current config:** ✅ Already configured correctly

### **2. Service Role Key (Secret Key) - ⚠️ For Admin Operations**
- **Location:** Supabase Dashboard > Settings > API > service_role
- **What it does:** Bypass RLS, full database access
- **Security:** Never expose in frontend, only use server-side
- **Your current config:** ❌ Needs to be updated

## 🛠️ **How to Get Your Keys**

### **Step 1: Access Supabase Dashboard**
1. Go to [supabase.com](https://supabase.com)
2. Sign in to your account
3. Select your project: `truyxgamywbkuovyzlhe`

### **Step 2: Get the Service Role Key**
1. In your project dashboard, go to **Settings** (gear icon)
2. Click on **API** in the sidebar
3. Scroll down to **Project API keys**
4. Copy the **service_role** key (starts with `eyJ...`)

### **Step 3: Update Your Config**
Replace the placeholder in `config/config.php`:

```php
// Replace this line:
define('SUPABASE_SERVICE_ROLE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRydXl4Z2FteXdia3Vvdnl6bGhlIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1Mjg0NTAwOSwiZXhwIjoyMDY4NDIxMDA5fQ.YOUR_SERVICE_ROLE_KEY_HERE');

// With your actual service role key:
define('SUPABASE_SERVICE_ROLE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InRydXl4Z2FteXdia3Vvdnl6bGhlIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc1Mjg0NTAwOSwiZXhwIjoyMDY4NDIxMDA5fQ.ACTUAL_SERVICE_ROLE_KEY_HERE');
```

## 🔒 **Security Best Practices**

### **✅ Do This:**
- Use **anon key** for most operations (reading data, user registrations)
- Use **service role key** only for admin operations (bypassing RLS)
- Keep service role key secret and server-side only
- Use Row Level Security (RLS) policies in Supabase

### **❌ Don't Do This:**
- Never expose service role key in frontend code
- Don't commit real keys to public repositories
- Don't use service role key for regular user operations

## 🧪 **Test Your Configuration**

Run this test to verify your keys work:

```bash
# Visit this URL to test your Supabase connection
yourdomain.com/test_connection.php
```

## 📊 **Current Key Status**

| Key Type | Status | Location |
|----------|--------|----------|
| **Anon Key** | ✅ Configured | `config/config.php` line 9 |
| **Service Role Key** | ❌ Needs Update | `config/config.php` line 12 |

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