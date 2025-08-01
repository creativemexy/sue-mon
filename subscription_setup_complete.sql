-- Complete Subscription Setup Script
-- Run this in Supabase SQL Editor

-- 1. Create subscriptions table (if it doesn't exist)
CREATE TABLE IF NOT EXISTS subscriptions (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  email TEXT NOT NULL,
  name TEXT NOT NULL,
  phone TEXT NOT NULL,
  address TEXT,
  plan_name TEXT NOT NULL,
  plan_price INTEGER NOT NULL,
  status TEXT DEFAULT 'active',
  start_date TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
  next_delivery_date TIMESTAMP WITH TIME ZONE DEFAULT (NOW() + INTERVAL '1 month'),
  payment_reference TEXT,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- 2. Create indexes for better performance (if they don't exist)
CREATE INDEX IF NOT EXISTS idx_subscriptions_email ON subscriptions(email);
CREATE INDEX IF NOT EXISTS idx_subscriptions_status ON subscriptions(status);
CREATE INDEX IF NOT EXISTS idx_subscriptions_created_at ON subscriptions(created_at);

-- 3. Enable Row Level Security
ALTER TABLE subscriptions ENABLE ROW LEVEL SECURITY;

-- 4. Drop existing policies if they exist (to avoid conflicts)
DROP POLICY IF EXISTS "Allow public to create subscriptions" ON subscriptions;
DROP POLICY IF EXISTS "Allow authenticated users to view their own subscriptions" ON subscriptions;
DROP POLICY IF EXISTS "Allow admins to manage all subscriptions" ON subscriptions;

-- 5. Create policies
-- Allow public to create subscriptions
CREATE POLICY "Allow public to create subscriptions" ON subscriptions
  FOR INSERT WITH CHECK (true);

-- Allow authenticated users to view their own subscriptions
CREATE POLICY "Allow authenticated users to view their own subscriptions" ON subscriptions
  FOR SELECT USING (auth.uid()::text = email);

-- Allow admins to manage all subscriptions
CREATE POLICY "Allow admins to manage all subscriptions" ON subscriptions
  FOR ALL USING (
    EXISTS (
      SELECT 1 FROM user_roles 
      WHERE user_id = auth.uid() 
      AND role = 'admin'
    )
  );

-- 6. Create function to update updated_at timestamp (if it doesn't exist)
CREATE OR REPLACE FUNCTION update_updated_at_column() RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$$ language 'plpgsql';

-- 7. Drop existing trigger if it exists
DROP TRIGGER IF EXISTS update_subscriptions_updated_at ON subscriptions;

-- 8. Create trigger to automatically update updated_at
CREATE TRIGGER update_subscriptions_updated_at
  BEFORE UPDATE ON subscriptions
  FOR EACH ROW
  EXECUTE FUNCTION update_updated_at_column();

-- 9. Insert subscription page content
INSERT INTO page_content (page_slug, title, content, published) VALUES (
  'subscription',
  'Tea Subscription Plans',
  '{
    "html": "<div class=\"py-8\"><div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\"><div class=\"text-center mb-12\"><h1 class=\"text-3xl font-bold text-foreground mb-4\">Tea Subscription</h1><p class=\"text-muted-foreground max-w-2xl mx-auto\">Get premium herbal tea blends delivered monthly. Discover new flavors and enjoy the convenience of automatic delivery.</p></div><div class=\"grid grid-cols-1 md:grid-cols-3 gap-8\"><div class=\"relative border rounded-lg p-6\"><div class=\"text-xl font-semibold mb-2\">Starter Plan</div><div class=\"text-muted-foreground mb-4\">Perfect for tea beginners</div><div class=\"pt-4\"><span class=\"text-3xl font-bold text-foreground\">₦8,500</span><span class=\"text-muted-foreground ml-2\">per month</span></div><ul class=\"space-y-3 mb-6 mt-6\"><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">3 different tea blends (50g each)</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Monthly wellness guide</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Free shipping</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Cancel anytime</span></li></ul><button class=\"w-full border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors\">Subscribe Now</button></div><div class=\"relative border-primary shadow-elegant rounded-lg p-6\"><div class=\"absolute -top-2 left-1/2 transform -translate-x-1/2 bg-secondary text-secondary-foreground px-2 py-1 rounded text-xs font-medium\">Most Popular</div><div class=\"text-xl font-semibold mb-2\">Explorer Plan</div><div class=\"text-muted-foreground mb-4\">For the curious tea enthusiast</div><div class=\"pt-4\"><span class=\"text-3xl font-bold text-foreground\">₦14,000</span><span class=\"text-muted-foreground ml-2\">per month</span></div><ul class=\"space-y-3 mb-6 mt-6\"><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">5 different tea blends (50g each)</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Exclusive seasonal blends</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Monthly wellness guide</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Tea brewing accessories</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Free shipping</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Cancel anytime</span></li></ul><button class=\"w-full bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors\">Subscribe Now</button></div><div class=\"relative border rounded-lg p-6\"><div class=\"text-xl font-semibold mb-2\">Connoisseur Plan</div><div class=\"text-muted-foreground mb-4\">For the ultimate tea lover</div><div class=\"pt-4\"><span class=\"text-3xl font-bold text-foreground\">₦22,000</span><span class=\"text-muted-foreground ml-2\">per month</span></div><ul class=\"space-y-3 mb-6 mt-6\"><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">8 different tea blends (50g each)</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Premium exclusive blends</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Monthly wellness guide</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Premium brewing accessories</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Personal tea consultation</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Free shipping</span></li><li class=\"flex items-center space-x-3\"><svg class=\"h-4 w-4 text-primary\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"></path></svg><span class=\"text-muted-foreground\">Cancel anytime</span></li></ul><button class=\"w-full border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors\">Subscribe Now</button></div></div></div></div>"
  }',
  true
) ON CONFLICT (page_slug) DO UPDATE SET
  title = EXCLUDED.title,
  content = EXCLUDED.content,
  published = EXCLUDED.published,
  updated_at = NOW();

-- 10. Success message
SELECT 'Subscription setup completed successfully!' as message; 