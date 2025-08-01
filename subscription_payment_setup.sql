-- Subscription Payment Setup
-- Run this in Supabase SQL Editor

-- Create subscriptions table
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
  payment_reference TEXT,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Enable RLS
ALTER TABLE subscriptions ENABLE ROW LEVEL SECURITY;

-- Create policies
DROP POLICY IF EXISTS "Allow public to create subscriptions" ON subscriptions;
CREATE POLICY "Allow public to create subscriptions" ON subscriptions FOR INSERT WITH CHECK (true);

-- Insert subscription page content
INSERT INTO page_content (page_slug, title, content, published) VALUES (
  'subscription',
  'Tea Subscription Plans',
  '{"html": "<div class=\"py-8\"><div class=\"max-w-7xl mx-auto px-4 sm:px-6 lg:px-8\"><div class=\"text-center mb-12\"><h1 class=\"text-3xl font-bold text-foreground mb-4\">Tea Subscription</h1><p class=\"text-muted-foreground max-w-2xl mx-auto\">Get premium herbal tea blends delivered monthly.</p></div><div class=\"grid grid-cols-1 md:grid-cols-3 gap-8\"><div class=\"relative border rounded-lg p-6\"><div class=\"text-xl font-semibold mb-2\">Starter Plan</div><div class=\"text-muted-foreground mb-4\">Perfect for tea beginners</div><div class=\"pt-4\"><span class=\"text-3xl font-bold text-foreground\">₦8,500</span><span class=\"text-muted-foreground ml-2\">per month</span></div><button class=\"w-full border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors\">Subscribe Now</button></div><div class=\"relative border-primary shadow-elegant rounded-lg p-6\"><div class=\"absolute -top-2 left-1/2 transform -translate-x-1/2 bg-secondary text-secondary-foreground px-2 py-1 rounded text-xs font-medium\">Most Popular</div><div class=\"text-xl font-semibold mb-2\">Explorer Plan</div><div class=\"text-muted-foreground mb-4\">For the curious tea enthusiast</div><div class=\"pt-4\"><span class=\"text-3xl font-bold text-foreground\">₦14,000</span><span class=\"text-muted-foreground ml-2\">per month</span></div><button class=\"w-full bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors\">Subscribe Now</button></div><div class=\"relative border rounded-lg p-6\"><div class=\"text-xl font-semibold mb-2\">Connoisseur Plan</div><div class=\"text-muted-foreground mb-4\">For the ultimate tea lover</div><div class=\"pt-4\"><span class=\"text-3xl font-bold text-foreground\">₦22,000</span><span class=\"text-muted-foreground ml-2\">per month</span></div><button class=\"w-full border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm font-medium transition-colors\">Subscribe Now</button></div></div></div></div>"}',
  true
) ON CONFLICT (page_slug) DO UPDATE SET
  title = EXCLUDED.title,
  content = EXCLUDED.content,
  published = EXCLUDED.published,
  updated_at = NOW(); 