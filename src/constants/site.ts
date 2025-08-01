export const SITE_CONFIG = {
  name: "Sue&Mon",
  description: "Premium Herbal Tea Blends for Health, Wellness, and Relaxation",
  tagline: "Premium Herbal Blends",
  url: "https://suemon.ng",
  email: "hello@suemon.ng",
  phone: "+234 800 TEA SHOP",
  address: "Lagos, Nigeria",
  
  // Social media
  social: {
    facebook: "https://facebook.com/suemon",
    instagram: "https://instagram.com/suemon",
    twitter: "https://twitter.com/suemon",
    youtube: "https://youtube.com/suemon"
  },
  
  // Business hours
  businessHours: {
    phone: {
      weekdays: "Monday - Friday: 9:00 AM - 6:00 PM",
      saturday: "Saturday: 10:00 AM - 4:00 PM",
      sunday: "Sunday: Closed"
    },
    chat: {
      weekdays: "Monday - Saturday: 8:00 AM - 8:00 PM",
      sunday: "Sunday: 10:00 AM - 6:00 PM"
    },
    email: "24/7 - We respond within 24 hours"
  },
  
  // Support
  support: {
    whatsapp: "https://wa.me/2348000000000",
    phone: "+2348000000000",
    email: "hello@suemon.ng"
  }
} as const;

export const PRODUCT_CATEGORIES = [
  {
    id: "immunity",
    name: "Immunity Teas",
    description: "Boost your immune system with our natural herbal blends",
    href: "/category/immunity",
    image: "/assets/ginger-tea.jpg"
  },
  {
    id: "energy",
    name: "Energy Blends",
    description: "Natural energy boosters to keep you going throughout the day",
    href: "/category/energy",
    image: "/assets/turmeric-tea.jpg"
  },
  {
    id: "sleep",
    name: "Sleep Teas",
    description: "Relaxing blends to help you get a peaceful night's sleep",
    href: "/category/sleep",
    image: "/assets/hibiscus-tea.jpg"
  }
] as const;

export const FEATURED_PRODUCTS = [
  {
    id: "1",
    name: "Ginger Immunity Blend",
    description: "Powerful blend of ginger, turmeric, and honey for immune support",
    price: 2500,
    image: "/assets/ginger-tea.jpg",
    category: "immunity",
    featured: true
  },
  {
    id: "2",
    name: "Turmeric Energy Boost",
    description: "Energizing blend with turmeric, black pepper, and citrus",
    price: 2800,
    image: "/assets/turmeric-tea.jpg",
    category: "energy",
    featured: true
  },
  {
    id: "3",
    name: "Hibiscus Sleep Blend",
    description: "Calming blend with hibiscus, chamomile, and lavender",
    price: 2200,
    image: "/assets/hibiscus-tea.jpg",
    category: "sleep",
    featured: true
  }
] as const; 