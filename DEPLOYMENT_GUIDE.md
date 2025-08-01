# 🚀 Complete Deployment Guide for Sue & Mon Website

## 📋 Prerequisites

### Local Machine (Your Development Environment)
- Git installed
- GitHub account
- Node.js 18+

### OCI Server Requirements
- Ubuntu 20.04+ or CentOS 8+
- Root/sudo access
- Domain name (optional but recommended)
- Port 80 and 443 open

## 🔧 Step-by-Step Setup

### 1. Push to GitHub

#### Create GitHub Repository
1. Go to [GitHub.com](https://github.com)
2. Click "New repository"
3. Name it: `sue-mon`
4. Make it **Public** (for easier setup)
5. Don't initialize with README (we already have one)

#### Push Your Code
```bash
# In your local project directory
git remote add origin https://github.com/YOUR_USERNAME/sue-mon.git
git push -u origin main
```

### 2. OCI Server Setup

#### Connect to Your OCI Server
```bash
ssh ubuntu@your-server-ip
```

#### Update System
```bash
sudo apt update && sudo apt upgrade -y
```

#### Install Node.js 18
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
node --version  # Should show v18.x.x
```

#### Install Git
```bash
sudo apt install git -y
```

#### Install PM2 (Process Manager)
```bash
sudo npm install -g pm2
```

#### Install Caddy (Web Server)
```bash
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update
sudo apt install caddy
```

### 3. Clone and Setup Project

#### Clone Repository
```bash
cd /opt
sudo git clone https://github.com/YOUR_USERNAME/sue-mon.git
sudo chown -R $USER:$USER /opt/sue-mon
cd sue-mon
```

#### Install Dependencies
```bash
npm install
```

#### Environment Setup
```bash
cp .env.example .env.local
nano .env.local
```

Add your environment variables:
```env
NEXT_PUBLIC_SUPABASE_URL=your_supabase_url
NEXT_PUBLIC_SUPABASE_ANON_KEY=your_supabase_anon_key
NEXT_PUBLIC_PAYSTACK_PUBLIC_KEY=your_paystack_public_key
```

#### Build Application
```bash
npm run build
```

### 4. Configure Caddy

#### Create Caddyfile
```bash
sudo nano /etc/caddy/Caddyfile
```

Add this content:
```caddy
yourdomain.com {
    reverse_proxy localhost:3000
}

# If no domain, use IP address
your-server-ip {
    reverse_proxy localhost:3000
}
```

#### Start Caddy
```bash
sudo systemctl enable caddy
sudo systemctl start caddy
sudo systemctl status caddy
```

### 5. Setup PM2 Process Manager

#### Start Application
```bash
cd /opt/sue-mon
pm2 start npm --name "sue-mon" -- start
pm2 save
pm2 startup
```

#### Verify PM2 Setup
```bash
pm2 status
pm2 logs sue-mon
```

### 6. Setup Auto-Deployment

#### Copy Deployment Script
```bash
sudo cp /opt/sue-mon/deploy.sh /opt/sue-mon/
sudo chmod +x /opt/sue-mon/deploy.sh
```

#### Update Script with Your Repository
```bash
sudo nano /opt/sue-mon/deploy.sh
```

Change this line:
```bash
REPO_URL="https://github.com/YOUR_USERNAME/sue-mon.git"
```

#### Setup Cron Job
```bash
crontab -e
```

Add this line:
```bash
*/30 * * * * /opt/sue-mon/deploy.sh >> /opt/sue-mon/deploy.log 2>&1
```

#### Test Deployment Script
```bash
/opt/sue-mon/deploy.sh
```

### 7. Database Setup

#### Run SQL Scripts in Supabase
1. Go to your Supabase dashboard
2. Navigate to SQL Editor
3. Run these scripts:
   - `products_db_fixed.sql`
   - `subscription_payment_setup.sql`

### 8. Final Configuration

#### Add Your Logo
```bash
# Upload your logo to the server
scp logo.png ubuntu@your-server-ip:/opt/sue-mon/public/images/logo.png
```

#### Test the Website
1. Visit `http://your-server-ip` or `https://yourdomain.com`
2. Check admin dashboard at `/admin`
3. Test product management

## 🔄 How Auto-Deployment Works

### Cron Job
- Runs every 30 minutes
- Checks GitHub for updates
- Automatically pulls and deploys changes
- Logs all activities to `/opt/sue-mon/deploy.log`

### Manual Deployment
```bash
# Force deployment
/opt/sue-mon/deploy.sh

# Check logs
tail -f /opt/sue-mon/deploy.log

# Restart application
pm2 restart sue-mon
```

## 🛠️ Troubleshooting

### Common Issues

#### 1. Port 3000 Not Accessible
```bash
# Check if app is running
pm2 status
pm2 logs sue-mon

# Check firewall
sudo ufw status
sudo ufw allow 3000
```

#### 2. Caddy Not Working
```bash
# Check Caddy status
sudo systemctl status caddy

# Check Caddy logs
sudo journalctl -u caddy -f

# Test Caddy config
sudo caddy validate --config /etc/caddy/Caddyfile
```

#### 3. Build Errors
```bash
# Check Node.js version
node --version

# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

#### 4. Environment Variables
```bash
# Check if .env.local exists
ls -la /opt/sue-mon/.env.local

# Verify environment variables
cat /opt/sue-mon/.env.local
```

### Useful Commands

#### Check Application Status
```bash
pm2 status
pm2 logs sue-mon --lines 50
```

#### Check Deployment Logs
```bash
tail -f /opt/sue-mon/deploy.log
```

#### Restart Everything
```bash
pm2 restart all
sudo systemctl restart caddy
```

#### Update Manually
```bash
cd /opt/sue-mon
git pull origin main
npm install
npm run build
pm2 restart sue-mon
```

## 📊 Monitoring

### Log Files
- Application logs: `pm2 logs sue-mon`
- Deployment logs: `/opt/sue-mon/deploy.log`
- Caddy logs: `sudo journalctl -u caddy`

### Health Check
```bash
# Check if website is responding
curl -I http://localhost:3000

# Check if Caddy is working
curl -I http://yourdomain.com
```

## 🔐 Security Notes

1. **Environment Variables**: Never commit `.env.local` to Git
2. **Firewall**: Configure UFW to only allow necessary ports
3. **Updates**: Keep system and Node.js updated
4. **Backups**: The deployment script creates automatic backups

## 📞 Support

If you encounter issues:
1. Check the logs: `tail -f /opt/sue-mon/deploy.log`
2. Check PM2 status: `pm2 status`
3. Check Caddy status: `sudo systemctl status caddy`
4. Check application logs: `pm2 logs sue-mon`

## 🎉 Success!

Once everything is set up:
- Your website will be live at your domain or IP
- Changes pushed to GitHub will auto-deploy every 30 minutes
- Admin dashboard available at `/admin`
- All products managed through database
- Payment integration ready for Paystack

Your Sue & Mon website is now fully automated! 🚀
