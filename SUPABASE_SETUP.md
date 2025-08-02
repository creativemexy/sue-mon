# Supabase Setup Guide for Sue & Mon

This guide will help you set up Supabase as the database for your Sue & Mon PHP website.

## 🚀 **Step 1: Create Supabase Project**

1. Go to [supabase.com](https://supabase.com)
2. Sign up or log in to your account
3. Click "New Project"
4. Choose your organization
5. Enter project details:
   - **Name:** `sue-mon-db`
   - **Database Password:** Choose a strong password
   - **Region:** Select closest to your users
6. Click "Create new project"

## 📊 **Step 2: Import Database Schema**

### 2.1 Access SQL Editor
1. In your Supabase dashboard, go to **SQL Editor**
2. Click **New Query**

### 2.2 Import Schema
Copy and paste the contents of `database/schema.sql` into the SQL editor and run it.

The schema includes these tables:
- `users` - User accounts and authentication
- `products` - Product catalog
- `categories` - Product categories
- `orders` - Customer orders
- `order_items` - Order line items
- `cart_items` - Shopping cart items
- `blog_posts` - Blog articles
- `contact_messages` - Contact form submissions

### 2.3 Verify Tables
Go to **Table Editor** to verify all tables were created successfully.

## 🔑 **Step 3: Get API Keys**

1. In your Supabase dashboard, go to **Settings** > **API**
2. Copy the following values:
   - **Project URL** (e.g., `https://your-project.supabase.co`)
   - **Anon Key** (public key)
   - **Service Role Key** (secret key)

## ⚙️ **Step 4: Configure Application**

### 4.1 Update Configuration File
Edit `config/config.php` with your Supabase credentials:

```php
<?php
// Site Configuration
define('SITE_NAME', 'Sue & Mon');
define('SITE_DESCRIPTION', 'Premium Herbal Blends');
define('SITE_URL', 'https://your-domain.com');

// Supabase Configuration
define('SUPABASE_URL', 'https://your-project.supabase.co');
define('SUPABASE_ANON_KEY', 'your-supabase-anon-key');
define('SUPABASE_SERVICE_ROLE_KEY', 'your-supabase-service-role-key');

// Other configurations...
?>
```

### 4.2 Test Connection
Create a test file to verify the connection:

```php
<?php
require_once 'config/config.php';
require_once 'config/supabase_client.php';

try {
    // Test connection by fetching a product
    $result = $supabase->select('products', '*', ['limit' => 1]);
    echo "✅ Supabase connection successful!";
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
```

## 🔒 **Step 5: Security Configuration**

### 5.1 Row Level Security (RLS)
Enable RLS on sensitive tables:

```sql
-- Enable RLS on users table
ALTER TABLE users ENABLE ROW LEVEL SECURITY;

-- Enable RLS on orders table
ALTER TABLE orders ENABLE ROW LEVEL SECURITY;

-- Enable RLS on cart_items table
ALTER TABLE cart_items ENABLE ROW LEVEL SECURITY;
```

### 5.2 Create Policies
Set up appropriate policies for your tables:

```sql
-- Users can only see their own data
CREATE POLICY "Users can view own data" ON users
    FOR SELECT USING (auth.uid() = id);

-- Users can only see their own orders
CREATE POLICY "Users can view own orders" ON orders
    FOR SELECT USING (auth.uid() = user_id);

-- Users can only see their own cart items
CREATE POLICY "Users can view own cart items" ON cart_items
    FOR ALL USING (auth.uid() = user_id);
```

## 📝 **Step 6: Add Sample Data**

### 6.1 Insert Categories
```sql
INSERT INTO categories (name, slug, description) VALUES
('Immunity', 'immunity', 'Boost your immune system'),
('Energy', 'energy', 'Natural energy boosters'),
('Sleep', 'sleep', 'Better sleep and relaxation'),
('Heart Health', 'heart-health', 'Cardiovascular support'),
('Traditional', 'traditional', 'Traditional herbal remedies'),
('Culinary', 'culinary', 'Cooking and seasoning');
```

### 6.2 Insert Sample Products
```sql
INSERT INTO products (name, slug, description, price, category_id, image_url, stock_quantity) VALUES
('Ginger Tea Blend', 'ginger-tea-blend', 'Premium ginger tea for immunity', 2500, 1, 'ginger-tea.jpg', 100),
('Hibiscus Energy Mix', 'hibiscus-energy-mix', 'Natural energy booster', 3000, 2, 'hibiscus-tea.jpg', 75),
('Moringa Sleep Aid', 'moringa-sleep-aid', 'Relaxing sleep blend', 2800, 3, 'moringa-tea.jpg', 50),
('Turmeric Heart Health', 'turmeric-heart-health', 'Cardiovascular support blend', 3200, 4, 'turmeric-tea.jpg', 80);
```

## 🔄 **Step 7: Real-time Features (Optional)**

### 7.1 Enable Real-time
In your Supabase dashboard:
1. Go to **Database** > **Replication**
2. Enable real-time for tables you want to sync:
   - `products`
   - `orders`
   - `cart_items`

### 7.2 Configure Webhooks
Set up webhooks for order notifications:
1. Go to **Settings** > **Webhooks**
2. Create webhook for order events
3. Configure your endpoint URL

## 📊 **Step 8: Monitoring and Analytics**

### 8.1 Database Monitoring
- Go to **Dashboard** > **Database** to monitor:
  - Query performance
  - Connection usage
  - Storage usage

### 8.2 Logs
- Check **Logs** section for:
  - API requests
  - Authentication events
  - Database queries

## 🚨 **Troubleshooting**

### Common Issues:

1. **Connection Failed:**
   - Verify your API keys are correct
   - Check if your project is active
   - Ensure your IP is not blocked

2. **RLS Policy Issues:**
   - Verify policies are correctly set
   - Check user authentication status
   - Review policy conditions

3. **Performance Issues:**
   - Monitor query performance
   - Check connection limits
   - Review indexing

## ✅ **Verification Checklist**

- [ ] Supabase project created
- [ ] Database schema imported
- [ ] API keys configured
- [ ] Connection test successful
- [ ] RLS policies configured
- [ ] Sample data added
- [ ] Real-time enabled (optional)
- [ ] Webhooks configured (optional)

Your Supabase database is now ready for the Sue & Mon PHP website! 