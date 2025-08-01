export const ROUTES = {
  // Main pages
  HOME: '/',
  ABOUT: '/about',
  CONTACT: '/contact',
  STORY: '/story',
  SUPPORT: '/support',
  FAQ: '/faq',
  BLOG: '/blog',
  BENEFITS: '/benefits',
  SUBSCRIPTION: '/subscription',
  GIFTS: '/gifts',
  WHOLESALE: '/wholesale',
  
  // Shop pages
  SHOP: '/shop',
  CATEGORIES: '/categories',
  CATEGORY_IMMUNITY: '/category/immunity',
  CATEGORY_ENERGY: '/category/energy',
  CATEGORY_SLEEP: '/category/sleep',
  
  // Legal pages
  PRIVACY: '/privacy',
  TERMS: '/terms',
  RETURNS: '/returns',
  SHIPPING: '/shipping',
  TRACK: '/track',
  
  // Auth pages
  AUTH: '/auth',
  
  // Admin pages
  ADMIN: '/admin',
} as const;

export const NAVIGATION = [
  { name: "Shop", href: ROUTES.SHOP },
  { name: "Tea Types", href: ROUTES.CATEGORIES },
  { name: "Health Benefits", href: ROUTES.BENEFITS },
  { name: "Subscription", href: ROUTES.SUBSCRIPTION },
  { name: "Blog", href: ROUTES.BLOG },
  { name: "About", href: ROUTES.ABOUT }
] as const;

export const FOOTER_LINKS = {
  quickLinks: [
    { name: "About Us", href: ROUTES.ABOUT },
    { name: "Our Story", href: ROUTES.STORY },
    { name: "Tea Benefits", href: ROUTES.BENEFITS },
    { name: "Blog", href: ROUTES.BLOG },
    { name: "Contact", href: ROUTES.CONTACT },
    { name: "FAQ", href: ROUTES.FAQ }
  ],
  shopLinks: [
    { name: "All Products", href: ROUTES.SHOP },
    { name: "Immunity Teas", href: ROUTES.CATEGORY_IMMUNITY },
    { name: "Energy Blends", href: ROUTES.CATEGORY_ENERGY },
    { name: "Sleep Teas", href: ROUTES.CATEGORY_SLEEP },
    { name: "Gift Sets", href: ROUTES.GIFTS },
    { name: "Subscription", href: ROUTES.SUBSCRIPTION }
  ],
  supportLinks: [
    { name: "Shipping Info", href: ROUTES.SHIPPING },
    { name: "Returns", href: ROUTES.RETURNS },
    { name: "Size Guide", href: "/sizing" },
    { name: "Track Order", href: ROUTES.TRACK },
    { name: "Customer Care", href: ROUTES.SUPPORT },
    { name: "Wholesale", href: ROUTES.WHOLESALE }
  ]
} as const; 