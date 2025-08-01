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

-- Create indexes
CREATE INDEX IF NOT EXISTS idx_products_category ON products(category);
CREATE INDEX IF NOT EXISTS idx_products_in_stock ON products(in_stock);

-- Enable RLS
ALTER TABLE products ENABLE ROW LEVEL SECURITY;

-- Create policies
DROP POLICY IF EXISTS "Allow public to view products" ON products;
DROP POLICY IF EXISTS "Allow admins to manage products" ON products;

CREATE POLICY "Allow public to view products" ON products FOR SELECT USING (true);
CREATE POLICY "Allow admins to manage products" ON products FOR ALL USING (
  EXISTS (SELECT 1 FROM user_roles WHERE user_id = auth.uid() AND role = 'admin')
);

-- Create trigger for updated_at
CREATE OR REPLACE FUNCTION update_updated_at_column() RETURNS TRIGGER AS $$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$$ language 'plpgsql';

DROP TRIGGER IF EXISTS update_products_updated_at ON products;
CREATE TRIGGER update_products_updated_at
  BEFORE UPDATE ON products
  FOR EACH ROW
  EXECUTE FUNCTION update_updated_at_column();

-- Insert sample products (immunity category)
INSERT INTO products (name, description, price, original_price, rating, reviews, benefits, category, is_bestseller, is_new) VALUES
('Turmeric Ginger Immunity Blend', 'Powerful anti-inflammatory blend to boost your immune system naturally', 3500, 4000, 4.8, 127, ARRAY['Immunity', 'Anti-inflammatory', 'Antioxidant'], 'immunity', true, false),
('Moringa Immune Support Tea', 'Nutrient-rich moringa leaves packed with vitamins and antioxidants', 2800, NULL, 4.6, 89, ARRAY['Immunity', 'Vitamin C', 'Energy'], 'immunity', false, true),
('Echinacea Defense Blend', 'Traditional immune-boosting herbs for year-round wellness', 3200, NULL, 4.5, 64, ARRAY['Immunity', 'Traditional', 'Wellness'], 'immunity', false, false),
('Vitamin C Citrus Spice Tea', 'Citrus-infused herbal blend rich in natural vitamin C', 2900, NULL, 4.7, 103, ARRAY['Vitamin C', 'Immunity', 'Citrus'], 'immunity', false, false); 