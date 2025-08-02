# Sue & Mon - PHP E-commerce Platform

A fully functional e-commerce website for premium herbal tea blends, built with modern PHP.

## 🚀 **Features**

- **Complete E-commerce Functionality**
  - Product catalog with search and filtering
  - Shopping cart with session management
  - Secure checkout process
  - Order management and tracking
  - Payment integration (Paystack ready)

- **User Management**
  - User registration and authentication
  - Admin dashboard and user roles
  - Profile management
  - Order history

- **Content Management**
  - Blog system with articles
  - Newsletter subscription
  - Product categories and tags
  - SEO optimized pages

- **Customer Support**
  - Contact forms
  - FAQ system
  - Returns and refunds
  - Shipping information

## 🛠 **Tech Stack**

- **Backend:** PHP 8.0+
- **Database:** Supabase (PostgreSQL)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Styling:** Tailwind CSS (via CDN)
- **Icons:** Font Awesome
- **Payment:** Paystack Integration
- **Email:** SMTP

## 📁 **Project Structure**

```
├── index.php                 # Main entry point and routing
├── config/                   # Configuration files
│   ├── config.php           # Site settings and constants
│   └── database.php         # Database connection
├── includes/                 # Core functionality
│   ├── auth.php             # Authentication system
│   ├── functions.php        # Utility functions
│   ├── layout.php           # Main layout template
│   ├── header.php           # Navigation header
│   ├── footer.php           # Site footer
│   ├── cart-sidebar.php     # Shopping cart sidebar
│   └── search-modal.php     # Search modal
├── pages/                   # Page templates
│   ├── home.php             # Homepage
│   ├── shop.php             # Product listing
│   ├── product.php          # Product details
│   ├── cart.php             # Shopping cart
│   ├── checkout.php         # Checkout process
│   ├── blog.php             # Blog posts
│   ├── auth/                # Authentication pages
│   │   ├── login.php
│   │   ├── register.php
│   │   └── logout.php
│   └── [other pages]        # About, Contact, FAQ, etc.
├── api/                     # API endpoints
│   ├── cart/                # Cart management
│   │   ├── add.php
│   │   ├── update.php
│   │   └── remove.php
│   └── search.php           # Product search
├── assets/                  # Static assets
│   ├── css/
│   │   └── style.css       # Custom styles
│   └── js/
│       └── app.js          # JavaScript functionality
├── database/                # Database files
│   └── schema.sql          # Complete database schema
├── public/                  # Public assets
│   └── images/              # Product images
├── deploy.sh               # Manual deployment script
├── auto_update.sh          # Automatic update script
└── setup_cron.sh           # Cron job setup script
```

## 🚀 **Quick Start**

### 1. **Supabase Setup**
1. Create a Supabase project at [supabase.com](https://supabase.com)
2. Get your API keys from Settings > API
3. Import the database schema from `database/schema.sql` into your Supabase project

### 2. **Configuration**
Edit `config/config.php` with your settings:
- Supabase API keys
- Site configuration
- Payment gateway settings

### 3. **Web Server Setup**
- Point your web server to the project root
- Ensure PHP 8.0+ is installed
- Configure your database connection

## 🔄 **Automatic Deployment**

The project includes automatic deployment scripts for continuous updates:

### Manual Deployment
```bash
./deploy.sh
```

### Automatic Updates (Every 30 minutes)
```bash
# Set up cron job (run as root)
sudo ./setup_cron.sh

# The script will automatically:
# - Check for GitHub updates every 30 minutes
# - Pull latest changes if available
# - Restart web server
# - Maintain backup of previous version
```

### Monitoring
- Logs are written to `/var/www/sue-mon/auto_update.log`
- Check cron job status: `crontab -u www-data -l`
- Remove cron job: `crontab -u www-data -r`

## 🛠 **Development**

### Local Development
1. Clone the repository
2. Set up your local database
3. Configure your local environment
4. Start your local web server

### Production Deployment
1. Upload files to your server
2. Set up database
3. Configure web server
4. Set up automatic updates

## 📝 **License**

This project is licensed under the MIT License.

## 🤝 **Support**

For support, please contact the development team or create an issue in the repository.
