# Admin Dashboard Access Guide

## 🔐 **How to Access Admin Dashboard**

### Step 1: Create Admin User
1. **Upload `create_admin.php`** to your server
2. **Visit:** `yourdomain.com/create_admin.php`
3. **This will create an admin user with:**
   - Email: `admin@sueandmon.com`
   - Password: `admin123`

### Step 2: Login as Admin
1. **Go to login page:** `yourdomain.com/index.php?page=auth/login`
2. **Enter credentials:**
   - Email: `admin@sueandmon.com`
   - Password: `admin123`
3. **Click Login**

### Step 3: Access Admin Dashboard
After logging in, you can access the admin dashboard at:
- **Main URL:** `yourdomain.com/index.php?page=admin`
- **Direct URL:** `yourdomain.com/pages/admin/dashboard.php`

## 🛠️ **Admin Features Available**

### Dashboard Overview
- **Product Count** - Total number of products
- **User Count** - Total registered users
- **Order Count** - Total orders placed
- **Blog Post Count** - Total blog posts

### Quick Actions
- **Add Product** - Create new products
- **View Orders** - Manage customer orders
- **Manage Blog** - Create/edit blog posts
- **View Site** - See the public website

### Admin Pages
- **Dashboard:** `index.php?page=admin`
- **Products:** `index.php?page=admin/products`
- **Orders:** `index.php?page=admin/orders`
- **Blog:** `index.php?page=admin/blog`

## 🔒 **Security Notes**

### Change Default Password
After first login, change the admin password:
1. Go to your profile page
2. Update the password
3. Use a strong password

### Admin Requirements
- User must be logged in
- User must have `role = 'admin'` in database
- Only admin users can access admin pages

## 🚨 **Troubleshooting**

### "Access Denied" Error
- Make sure you're logged in
- Check that your user has `role = 'admin'`
- Try logging out and back in

### "Page Not Found" Error
- Use the URL parameters approach: `index.php?page=admin`
- Or access directly: `pages/admin/dashboard.php`

### Can't Create Admin User
- Check your Supabase credentials in `config/config.php`
- Make sure the `users` table exists in your database
- Check server error logs

## 📋 **Quick Reference**

### Admin URLs (URL Parameters Method)
- **Login:** `index.php?page=auth/login`
- **Dashboard:** `index.php?page=admin`
- **Products:** `index.php?page=admin/products`
- **Orders:** `index.php?page=admin/orders`
- **Blog:** `index.php?page=admin/blog`

### Admin URLs (Direct Access)
- **Login:** `pages/auth/login.php`
- **Dashboard:** `pages/admin/dashboard.php`
- **Products:** `pages/admin/products.php`
- **Orders:** `pages/admin/orders.php`
- **Blog:** `pages/admin/blog.php`

### Default Admin Credentials
- **Email:** `admin@sueandmon.com`
- **Password:** `admin123`

## ✅ **Success Checklist**

- [ ] Created admin user with `create_admin.php`
- [ ] Successfully logged in as admin
- [ ] Can access admin dashboard
- [ ] Can see statistics (products, users, orders)
- [ ] Can navigate to other admin pages
- [ ] Changed default password (recommended)

Your admin dashboard is now ready to use! 