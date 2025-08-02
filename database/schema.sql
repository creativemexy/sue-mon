-- Database Schema for Sue & Mon PHP Application

-- Create database
CREATE DATABASE IF NOT EXISTS sue_mon_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sue_mon_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    email_verified BOOLEAN DEFAULT FALSE,
    email_verification_token VARCHAR(255),
    reset_token VARCHAR(255),
    reset_token_expires DATETIME,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Password resets table
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    used BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price INT NOT NULL, -- Price in kobo (smallest currency unit)
    original_price INT,
    image VARCHAR(255) DEFAULT '/images/placeholder.jpg',
    rating DECIMAL(2,1) DEFAULT 0.0,
    reviews_count INT DEFAULT 0,
    benefits JSON, -- Store benefits as JSON array
    category VARCHAR(100) NOT NULL,
    in_stock BOOLEAN DEFAULT TRUE,
    is_new BOOLEAN DEFAULT FALSE,
    is_bestseller BOOLEAN DEFAULT FALSE,
    stock_quantity INT DEFAULT 0,
    sku VARCHAR(100) UNIQUE,
    weight DECIMAL(5,2), -- Weight in grams
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_in_stock (in_stock),
    INDEX idx_is_bestseller (is_bestseller),
    INDEX idx_is_new (is_new)
);

-- Product reviews table
CREATE TABLE product_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    subtotal INT NOT NULL,
    shipping_cost INT NOT NULL,
    total INT NOT NULL,
    shipping_address JSON NOT NULL,
    billing_address JSON,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    payment_reference VARCHAR(255),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_order_number (order_number)
);

-- Order items table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_price INT NOT NULL,
    quantity INT NOT NULL,
    total INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    featured_image VARCHAR(255),
    author_id INT NOT NULL,
    published BOOLEAN DEFAULT FALSE,
    published_at DATETIME,
    meta_title VARCHAR(255),
    meta_description TEXT,
    tags JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_published (published),
    INDEX idx_slug (slug)
);

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    parent_id INT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Newsletter subscribers table
CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Wishlist table
CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Coupons table
CREATE TABLE coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    type ENUM('percentage', 'fixed') NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    minimum_order INT,
    maximum_uses INT,
    used_count INT DEFAULT 0,
    starts_at DATETIME,
    expires_at DATETIME,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Coupon usage table
CREATE TABLE coupon_usage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    coupon_id INT NOT NULL,
    user_id INT NOT NULL,
    order_id INT NOT NULL,
    discount_amount INT NOT NULL,
    used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- Settings table
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, setting_type, description) VALUES
('site_name', 'Sue & Mon', 'string', 'Website name'),
('site_description', 'Premium Herbal Blends', 'string', 'Website description'),
('currency', 'NGN', 'string', 'Default currency'),
('currency_symbol', '₦', 'string', 'Currency symbol'),
('shipping_cost', '500', 'number', 'Default shipping cost in kobo'),
('free_shipping_threshold', '10000', 'number', 'Free shipping threshold in kobo'),
('contact_email', 'contact@sueandmon.com', 'string', 'Contact email'),
('contact_phone', '+234 123 456 7890', 'string', 'Contact phone'),
('social_facebook', '', 'string', 'Facebook URL'),
('social_twitter', '', 'string', 'Twitter URL'),
('social_instagram', '', 'string', 'Instagram URL'),
('social_youtube', '', 'string', 'YouTube URL');

-- Insert sample admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@sueandmon.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample products
INSERT INTO products (name, description, price, original_price, rating, reviews_count, benefits, category, is_bestseller, is_new, stock_quantity, sku) VALUES
('Turmeric Ginger Immunity Blend', 'Powerful anti-inflammatory blend to boost your immune system naturally. Made with premium turmeric and ginger root.', 3500, 4000, 4.8, 127, '["Immunity", "Anti-inflammatory", "Antioxidant"]', 'immunity', TRUE, FALSE, 50, 'TUR-GIN-001'),
('Moringa Immune Support Tea', 'Nutrient-rich moringa leaves packed with vitamins and antioxidants for natural immune support.', 2800, NULL, 4.6, 89, '["Immunity", "Vitamin C", "Energy"]', 'immunity', FALSE, TRUE, 75, 'MOR-001'),
('Echinacea Defense Blend', 'Traditional immune-boosting herbs for year-round wellness and natural defense support.', 3200, NULL, 4.5, 64, '["Immunity", "Traditional", "Wellness"]', 'immunity', FALSE, FALSE, 60, 'ECH-001'),
('Vitamin C Citrus Spice Tea', 'Citrus-infused herbal blend rich in natural vitamin C for daily immune support.', 2900, NULL, 4.7, 103, '["Vitamin C", "Immunity", "Citrus"]', 'immunity', FALSE, FALSE, 45, 'VIT-C-001'),
('Chamomile Lavender Relaxation', 'Calming blend of chamomile and lavender for stress relief and better sleep.', 2500, NULL, 4.9, 156, '["Relaxation", "Sleep", "Stress Relief"]', 'relaxation', TRUE, FALSE, 80, 'CHA-LAV-001'),
('Peppermint Digestive Aid', 'Soothing peppermint blend to support healthy digestion and relieve discomfort.', 2200, NULL, 4.4, 78, '["Digestion", "Soothing", "Fresh"]', 'digestion', FALSE, FALSE, 65, 'PEP-001'),
('Green Tea Antioxidant Boost', 'Premium green tea blend with natural antioxidants for overall wellness.', 3000, NULL, 4.6, 92, '["Antioxidant", "Energy", "Wellness"]', 'wellness', FALSE, TRUE, 55, 'GRN-001'),
('Rooibos Vanilla Comfort', 'Smooth rooibos with natural vanilla for a comforting and caffeine-free experience.', 2400, NULL, 4.3, 67, '["Comfort", "Caffeine-free", "Smooth"]', 'relaxation', FALSE, FALSE, 70, 'ROO-VAN-001');

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, author_id, published, published_at, meta_title, meta_description) VALUES
('The Health Benefits of Herbal Tea', 'health-benefits-herbal-tea', '<p>Herbal teas have been used for centuries for their medicinal properties...</p>', 'Discover the amazing health benefits of herbal teas and how they can improve your wellness.', 1, TRUE, NOW(), 'Health Benefits of Herbal Tea - Sue & Mon', 'Learn about the health benefits of herbal teas and how they can improve your wellness.'),
('How to Choose the Right Herbal Blend', 'choose-right-herbal-blend', '<p>With so many herbal tea options available, it can be overwhelming...</p>', 'A comprehensive guide to choosing the perfect herbal tea blend for your needs.', 1, TRUE, NOW(), 'How to Choose the Right Herbal Blend - Sue & Mon', 'Learn how to choose the perfect herbal tea blend for your specific health needs and preferences.'),
('The Science Behind Herbal Medicine', 'science-behind-herbal-medicine', '<p>Modern science is beginning to understand what traditional healers...</p>', 'Explore the scientific research behind herbal medicine and its effectiveness.', 1, TRUE, NOW(), 'The Science Behind Herbal Medicine - Sue & Mon', 'Discover the scientific research behind herbal medicine and its effectiveness in modern healthcare.');

-- Insert sample categories
INSERT INTO categories (name, slug, description, sort_order) VALUES
('Immunity', 'immunity', 'Boost your immune system with our specially formulated immunity blends.', 1),
('Relaxation', 'relaxation', 'Find peace and tranquility with our calming relaxation teas.', 2),
('Digestion', 'digestion', 'Support healthy digestion with our soothing digestive blends.', 3),
('Wellness', 'wellness', 'Overall wellness and health support with our premium herbal blends.', 4),
('Energy', 'energy', 'Natural energy boosters without the jitters of caffeine.', 5),
('Sleep', 'sleep', 'Promote better sleep with our gentle sleep-supporting blends.', 6); 