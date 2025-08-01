// User types
export interface User {
  id: string;
  email: string;
  first_name?: string;
  last_name?: string;
  created_at: string;
  roles: string[];
}

// Product types
export interface Product {
  id: string;
  name: string;
  description: string;
  price: number;
  image_url?: string;
  category: string;
  stock_quantity: number;
  sku?: string;
  weight_grams?: number;
  is_active: boolean;
  featured: boolean;
  created_at: string;
  updated_at: string;
}

// Order types
export interface Order {
  id: string;
  user_id?: string;
  email: string;
  phone?: string;
  first_name: string;
  last_name: string;
  shipping_address: any;
  billing_address?: any;
  total_amount: number;
  status: string;
  payment_status: string;
  payment_reference?: string;
  tracking_number?: string;
  notes?: string;
  created_at: string;
  updated_at: string;
}

// Blog post types
export interface BlogPost {
  id: string;
  title: string;
  content: string;
  excerpt: string;
  author: string;
  category: string;
  image_url?: string;
  published: boolean;
  created_at: string;
  updated_at: string;
}

// Page content types
export interface PageContent {
  id: string;
  page_slug: string;
  title: string;
  content: any;
  published: boolean;
  created_at: string;
  updated_at: string;
}

// System setting types
export interface SystemSetting {
  id: string;
  key: string;
  value: any;
  description?: string;
  created_at: string;
  updated_at: string;
}

// Cart types
export interface CartItem {
  id: string;
  name: string;
  price: number;
  quantity: number;
  image_url?: string;
}

// Form types
export interface ContactForm {
  name: string;
  email: string;
  subject: string;
  message: string;
}

export interface NewsletterSubscription {
  email: string;
}

// API Response types
export interface ApiResponse<T> {
  data: T | null;
  error: string | null;
  success: boolean;
}

// Navigation types
export interface NavigationItem {
  name: string;
  href: string;
}

// Footer link types
export interface FooterLink {
  name: string;
  href: string;
}

export interface FooterLinks {
  quickLinks: FooterLink[];
  shopLinks: FooterLink[];
  supportLinks: FooterLink[];
} 