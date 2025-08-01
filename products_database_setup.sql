-- Products Database Setup
-- Run this in Supabase SQL Editor

-- Create products table
CREATE TABLE IF NOT EXISTS products (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  price INTEGER NOT NULL,
  original_price INTEGER,
  image TEXT DEFAULT '/placeholder.svg',
  rating DECIMAL(2,1) DEFAULT 0.0,
  reviews INTEGER DEFAULT 0,
  benefits TEXT[] DEFAULT '{}',
  category TEXT NOT NULL,
  in_stock BOOLEAN DEFAULT true,
  is_new BOOLEAN DEFAULT false,
  is_bestseller BOOLEAN DEFAULT false,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_products_category ON products(category);
CREATE INDEX IF NOT EXISTS idx_products_in_stock ON products(in_stock);
CREATE INDEX IF NOT EXISTS idx_products_rating ON products(rating);

-- Enable Row Level Security
ALTER TABLE products ENABLE ROW LEVEL SECURITY;

-- Drop existing policies if they exist
DROP POLICY IF EXISTS "Allow public to view products" ON products;
DROP POLICY IF EXISTS "Allow admins to manage products" ON products;

-- Create policies
-- Allow public to view products
CREATE POLICY "Allow public to view products" ON products
  FOR SELECT USING (true);

-- Allow admins to manage products
CREATE POLICY "Allow admins to manage products" ON products
  FOR ALL USING (
    EXISTS (
      SELECT 1 FROM user_roles 
      WHERE user_id = auth.uid() 
      AND role = 'admin'
    )
  );

-- Create function to update updated_at timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column() RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$$ language 'plpgsql';

-- Drop existing trigger if it exists
DROP TRIGGER IF EXISTS update_products_updated_at ON products;

-- Create trigger to automatically update updated_at
CREATE TRIGGER update_products_updated_at
  BEFORE UPDATE ON products
  FOR EACH ROW
  EXECUTE FUNCTION update_updated_at_column();

-- Insert Immunity Products
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Turmeric Ginger Immunity Blend', 'Powerful anti-inflammatory blend to boost your immune system naturally', 3500, 4000, 4.8, 127, ARRAY['Immunity', 'Anti-inflammatory', 'Antioxidant'], 'immunity', true, false),
('Moringa Immune Support Tea', 'Nutrient-rich moringa leaves packed with vitamins and antioxidants', 2800, NULL, 4.6, 89, ARRAY['Immunity', 'Vitamin C', 'Energy'], 'immunity', false, true),
('Echinacea Defense Blend', 'Traditional immune-boosting herbs for year-round wellness', 3200, NULL, 4.5, 64, ARRAY['Immunity', 'Traditional', 'Wellness'], 'immunity', false, false),
('Vitamin C Citrus Spice Tea', 'Citrus-infused herbal blend rich in natural vitamin C', 2900, NULL, 4.7, 103, ARRAY['Vitamin C', 'Immunity', 'Citrus'], 'immunity', false, false);

-- Insert Energy Products
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Moringa Energy Boost', 'Natural energy boost with nutrient-dense moringa leaves', 3200, NULL, 4.7, 156, ARRAY['Energy', 'Moringa', 'Natural'], 'energy', false, false),
('Ginger Vitality Blend', 'Invigorating ginger blend for sustained energy throughout the day', 2800, NULL, 4.5, 98, ARRAY['Energy', 'Ginger', 'Vitality'], 'energy', false, false),
('Green Tea Energy Mix', 'Premium green tea with natural caffeine for clean energy', 3500, NULL, 4.6, 134, ARRAY['Energy', 'Green Tea', 'Caffeine'], 'energy', false, false),
('Spiced Energy Chai', 'Traditional spice blend to energize and warm your body', 3000, NULL, 4.4, 87, ARRAY['Energy', 'Spices', 'Traditional'], 'energy', false, false);

-- Insert Heart Health Products
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Hibiscus Heart Health', 'Traditional hibiscus blend for cardiovascular support', 2800, NULL, 4.8, 203, ARRAY['Heart Health', 'Hibiscus', 'Cardiovascular'], 'heart', false, false),
('Garlic & Ginger Blend', 'Powerful combination for heart wellness and circulation', 3200, NULL, 4.6, 167, ARRAY['Heart Health', 'Garlic', 'Ginger'], 'heart', false, false),
('Cinnamon Heart Tea', 'Warming cinnamon blend for cardiovascular health', 2500, NULL, 4.5, 145, ARRAY['Heart Health', 'Cinnamon', 'Warming'], 'heart', false, false),
('Green Tea Heart Blend', 'Antioxidant-rich green tea for heart protection', 3000, NULL, 4.7, 189, ARRAY['Heart Health', 'Green Tea', 'Antioxidant'], 'heart', false, false);

-- Insert Culinary Products
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Premium Nigerian Pepper', 'Authentic Nigerian pepper blend for authentic flavor', 1800, NULL, 4.9, 203, ARRAY['Culinary', 'Authentic', 'Spicy'], 'culinary', true, false),
('Traditional Curry Mix', 'Handcrafted curry blend with traditional spices', 2200, NULL, 4.7, 156, ARRAY['Culinary', 'Traditional', 'Curry'], 'culinary', false, false),
('Garlic & Onion Powder', 'Pure garlic and onion powder for cooking excellence', 1500, NULL, 4.6, 98, ARRAY['Culinary', 'Garlic', 'Onion'], 'culinary', false, false),
('Nigerian Spice Blend', 'Complete Nigerian spice collection for authentic dishes', 2800, NULL, 4.8, 167, ARRAY['Culinary', 'Nigerian', 'Complete'], 'culinary', false, true),
('Organic Cinnamon Powder', 'Pure organic cinnamon for baking and cooking', 1200, NULL, 4.5, 89, ARRAY['Culinary', 'Organic', 'Cinnamon'], 'culinary', false, false),
('Ginger Powder Premium', 'Premium ginger powder for culinary and wellness use', 1600, NULL, 4.7, 134, ARRAY['Culinary', 'Ginger', 'Premium'], 'culinary', false, false);

-- Insert Sleep Products
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Chamomile Dream Tea', 'Gentle chamomile blend for peaceful, restful sleep', 2500, NULL, 4.8, 178, ARRAY['Sleep', 'Chamomile', 'Gentle'], 'sleep', false, false),
('Lavender Night Blend', 'Calming lavender tea to ease you into deep sleep', 2800, NULL, 4.7, 156, ARRAY['Sleep', 'Lavender', 'Calming'], 'sleep', false, false),
('Valerian Root Sleep Aid', 'Traditional sleep remedy with natural valerian root', 3200, NULL, 4.5, 98, ARRAY['Sleep', 'Valerian', 'Traditional'], 'sleep', false, false),
('Bedtime Herbal Blend', 'Soothing herbal mix designed for optimal sleep preparation', 2900, NULL, 4.6, 134, ARRAY['Sleep', 'Herbal', 'Soothing'], 'sleep', false, false);

-- Insert Traditional Products
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Ancient Nigerian Tea Blend', 'Traditional Nigerian tea recipe passed down through generations', 3500, NULL, 4.9, 234, ARRAY['Traditional', 'Nigerian', 'Heritage'], 'traditional', true, false),
('Hibiscus & Ginger Traditional', 'Classic combination of hibiscus and ginger for wellness', 2800, NULL, 4.7, 167, ARRAY['Traditional', 'Hibiscus', 'Ginger'], 'traditional', false, false),
('Moringa Traditional Blend', 'Traditional moringa preparation for health and vitality', 3200, NULL, 4.8, 189, ARRAY['Traditional', 'Moringa', 'Vitality'], 'traditional', false, false),
('Turmeric Golden Milk', 'Traditional golden milk recipe with premium turmeric', 3000, NULL, 4.6, 145, ARRAY['Traditional', 'Turmeric', 'Golden Milk'], 'traditional', false, true),
('Nigerian Spice Tea', 'Authentic Nigerian spice tea blend for daily wellness', 2500, NULL, 4.5, 98, ARRAY['Traditional', 'Spices', 'Wellness'], 'traditional', false, false),
('Traditional Herbal Mix', 'Complete traditional herbal blend for comprehensive health support', 3800, NULL, 4.8, 201, ARRAY['Traditional', 'Herbal', 'Complete'], 'traditional', false, false);

-- Success message
SELECT 'Products database setup completed successfully! Total products inserted: ' || COUNT(*) as message FROM products; 