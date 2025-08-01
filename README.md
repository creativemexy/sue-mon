# Sue & Mon - Premium Herbal Blends

A modern e-commerce website for premium herbal tea blends and spices, built with Next.js, TypeScript, and Supabase.

## 🚀 Features

- **Dynamic Product Management**: Admin dashboard for managing products, blog posts, and content
- **Database-Driven**: All content stored in Supabase PostgreSQL database
- **Payment Integration**: Paystack payment gateway for subscriptions
- **Responsive Design**: Modern UI with Tailwind CSS and Shadcn UI components
- **SEO Optimized**: Next.js App Router with proper metadata
- **Authentication**: User roles and admin access control

## 🛠️ Tech Stack

- **Frontend**: Next.js 14, TypeScript, Tailwind CSS
- **UI Components**: Shadcn UI, Lucide React Icons
- **Database**: Supabase (PostgreSQL)
- **Authentication**: Supabase Auth
- **Payments**: Paystack Integration
- **Deployment**: OCI with Caddy

## 📁 Project Structure

```
src/
├── app/                    # Next.js App Router
├── components/             # React components
│   ├── admin/             # Admin dashboard components
│   ├── ui/                # Shadcn UI components
│   └── ...
├── contexts/              # React contexts (Auth, Cart, Search)
├── hooks/                 # Custom React hooks
├── integrations/          # External service integrations
├── pages/                 # Page components
└── types/                 # TypeScript type definitions
```

## 🚀 Getting Started

### Prerequisites

- Node.js 18+ 
- npm or yarn
- Supabase account
- Paystack account (for payments)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/sue-mon.git
   cd sue-mon
   ```

2. **Install dependencies**
   ```bash
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env.local
   ```
   
   Update `.env.local` with your credentials:
   ```env
   NEXT_PUBLIC_SUPABASE_URL=your_supabase_url
   NEXT_PUBLIC_SUPABASE_ANON_KEY=your_supabase_anon_key
   NEXT_PUBLIC_PAYSTACK_PUBLIC_KEY=your_paystack_public_key
   ```

4. **Database Setup**
   - Run the SQL scripts in Supabase SQL Editor:
     - `products_db_fixed.sql`
     - `subscription_payment_setup.sql`

5. **Development Server**
   ```bash
   npm run dev
   ```

## 🗄️ Database Schema

### Products Table
```sql
CREATE TABLE products (
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
```

## 🔧 Deployment

### OCI with Caddy Setup

1. **Server Requirements**
   - Ubuntu 20.04+
   - Node.js 18+
   - Caddy web server
   - Git

2. **Initial Setup**
   ```bash
   # Install Node.js
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt-get install -y nodejs

   # Install Caddy
   sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https
   curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
   curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
   sudo apt update
   sudo apt install caddy
   ```

3. **Clone and Setup**
   ```bash
   git clone https://github.com/yourusername/sue-mon.git
   cd sue-mon
   npm install
   npm run build
   ```

4. **Caddy Configuration**
   ```caddy
   # /etc/caddy/Caddyfile
   yourdomain.com {
       reverse_proxy localhost:3000
   }
   ```

5. **PM2 Process Manager**
   ```bash
   npm install -g pm2
   pm2 start npm --name "sue-mon" -- start
   pm2 startup
   pm2 save
   ```

## 🔄 Auto-Deployment Script

The project includes an auto-deployment script that checks for GitHub updates every 30 minutes:

```bash
#!/bin/bash
# /opt/sue-mon/deploy.sh

cd /opt/sue-mon
git fetch origin
if [ "$(git rev-parse HEAD)" != "$(git rev-parse origin/main)" ]; then
    echo "Updates found, deploying..."
    git pull origin main
    npm install
    npm run build
    pm2 restart sue-mon
    echo "Deployment completed at $(date)"
else
    echo "No updates found at $(date)"
fi
```

### Cron Job Setup
```bash
# Add to crontab (crontab -e)
*/30 * * * * /opt/sue-mon/deploy.sh >> /opt/sue-mon/deploy.log 2>&1
```

## 📝 Admin Dashboard

Access the admin dashboard at `/admin` with admin credentials:

- **Product Management**: Add, edit, delete products
- **Blog Management**: Create and manage blog posts
- **Content Management**: Edit page content dynamically
- **Order Management**: View and manage orders
- **System Settings**: Configure site settings

## 🔐 Environment Variables

| Variable | Description | Required |
|----------|-------------|----------|
| `NEXT_PUBLIC_SUPABASE_URL` | Supabase project URL | Yes |
| `NEXT_PUBLIC_SUPABASE_ANON_KEY` | Supabase anonymous key | Yes |
| `NEXT_PUBLIC_PAYSTACK_PUBLIC_KEY` | Paystack public key | Yes |

## 📞 Support

For support, email support@sueandmon.com or create an issue on GitHub.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
