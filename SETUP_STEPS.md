# 🚀 Complete Setup Steps for Sue & Mon Website

## 📋 Prerequisites

### Local Machine Requirements
- Git installed
- GitHub account
- Node.js 18+
- Your project files ready

### OCI Server Requirements
- Ubuntu 20.04+ or CentOS 8+
- Root/sudo access
- Domain name (optional but recommended)
- Port 80 and 443 open

---

## 🔧 Step-by-Step Setup Instructions

### **STEP 1: Push to GitHub**

#### 1.1 Create GitHub Repository
1. Go to [GitHub.com](https://github.com)
2. Click "New repository"
3. Repository name: `sue-mon`
4. Make it **Public** (for easier setup)
5. **Don't** initialize with README (we already have one)
6. Click "Create repository"

#### 1.2 Push Your Code to GitHub
```bash
# In your local project directory (/home/mexy/Downloads/sue&mon)
git remote add origin https://github.com/YOUR_USERNAME/sue-mon.git
git push -u origin main
```

**Replace `YOUR_USERNAME` with your actual GitHub username**

---

### **STEP 2: OCI Server Initial Setup**

#### 2.1 Connect to Your OCI Server
```bash
ssh ubuntu@your-server-ip
```

#### 2.2 Update System
```bash
sudo apt update && sudo apt upgrade -y
```

#### 2.3 Install Node.js 18
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
node --version  # Should show v18.x.x
```

#### 2.4 Install Git
```bash
sudo apt install git -y
```

#### 2.5 Install PM2 (Process Manager)
```bash
sudo npm install -g pm2
```

#### 2.6 Install Caddy (Web Server)
```bash
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update
sudo apt install caddy
```

---

### **STEP 3: Clone and Setup Project**

#### 3.1 Clone Repository
```bash
cd /var/www
sudo git clone https://github.com/YOUR_USERNAME/sue-mon.git
sudo chown -R $USER:$USER /var/www/sue-mon
cd sue-mon
```

#### 3.2 Install Dependencies
```bash
npm install
```

#### 3.3 Environment Setup
```bash
cp .env.example .env.local
nano .env.local
```

**Add your environment variables:**
```env
NEXT_PUBLIC_SUPABASE_URL=your_supabase_url
NEXT_PUBLIC_SUPABASE_ANON_KEY=your_supabase_anon_key
NEXT_PUBLIC_PAYSTACK_PUBLIC_KEY=your_paystack_public_key
```

#### 3.4 Build Application
```bash
npm run build
```

---

### **STEP 4: Configure Caddy Web Server**

#### 4.1 Create Caddyfile
```bash
sudo nano /etc/caddy/Caddyfile
```

#### 4.2 Add Caddy Configuration
**If you have a domain:**
```caddy
yourdomain.com {
    reverse_proxy localhost:3000
}
```

**If you don't have a domain (use IP):**
```caddy
your-server-ip {
    reverse_proxy localhost:3000
}
```

#### 4.3 Start Caddy
```bash
sudo systemctl enable caddy
sudo systemctl start caddy
sudo systemctl status caddy
```

---

### **STEP 5: Setup PM2 Process Manager**

#### 5.1 Start Application
```bash
cd /opt/sue-mon
pm2 start npm --name "sue-mon" -- start
pm2 save
pm2 startup
```

#### 5.2 Verify PM2 Setup
```bash
pm2 status
pm2 logs sue-mon
```

---

### **STEP 6: Setup Auto-Deployment**

#### 6.1 Update Deployment Script
```bash
sudo nano /var/www/sue-mon/deploy.sh
```

**Change this line:**
```bash
REPO_URL="https://github.com/YOUR_USERNAME/sue-mon.git"
```

#### 6.2 Make Script Executable
```bash
sudo chmod +x /var/www/sue-mon/deploy.sh
```

#### 6.3 Setup Cron Job
```bash
crontab -e
```

**Add this line:**
```bash
*/30 * * * * /var/www/sue-mon/deploy.sh >> /var/www/sue-mon/deploy.log 2>&1
```

#### 6.4 Test Deployment Script
```bash
/var/www/sue-mon/deploy.sh
```

---

### **STEP 7: Database Setup**

#### 7.1 Run SQL Scripts in Supabase
1. Go to your Supabase dashboard
2. Navigate to SQL Editor
3. Run these scripts:
   - `products_db_fixed.sql`
   - `subscription_payment_setup.sql`

---

### **STEP 8: Final Configuration**

#### 8.1 Add Your Logo
```bash
# Upload your logo to the server
scp logo.png ubuntu@your-server-ip:/opt/sue-mon/public/images/logo.png
```

#### 8.2 Test the Website
1. Visit `http://your-server-ip` or `https://yourdomain.com`
2. Check admin dashboard at `/admin`
3. Test product management

---

## 🔄 How Auto-Deployment Works

### Cron Job Process
- **Frequency**: Runs every 30 minutes
- **Action**: Checks GitHub for updates
- **If Updates Found**: 
  - Pulls latest changes
  - Installs dependencies
  - Rebuilds application
  - Restarts application
  - Creates backup
- **Logging**: Records all activities to `/opt/sue-mon/deploy.log`

### Manual Deployment Commands
```bash
# Force deployment
/opt/sue-mon/deploy.sh

# Check logs
tail -f /opt/sue-mon/deploy.log

# Restart application
pm2 restart sue-mon
```

---

## 🛠️ Troubleshooting

### Common Issues & Solutions

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

#### 4. Environment Variables Issues
```bash
# Check if .env.local exists
ls -la /opt/sue-mon/.env.local

# Verify environment variables
cat /opt/sue-mon/.env.local
```

#### 5. Git Repository Issues
```bash
# Check git status
cd /opt/sue-mon
git status

# Re-clone if needed
cd /opt
rm -rf sue-mon
git clone https://github.com/YOUR_USERNAME/sue-mon.git
```

---

## 📊 Monitoring Commands

### Check Application Status
```bash
# PM2 status
pm2 status
pm2 logs sue-mon --lines 50

# Application health
curl -I http://localhost:3000
```

### Check Deployment Logs
```bash
# View deployment logs
tail -f /opt/sue-mon/deploy.log

# View recent deployments
tail -20 /opt/sue-mon/deploy.log
```

### Check Web Server
```bash
# Caddy status
sudo systemctl status caddy

# Caddy logs
sudo journalctl -u caddy -f
```

---

## 🔐 Security Configuration

### Firewall Setup
```bash
# Allow SSH
sudo ufw allow ssh

# Allow HTTP/HTTPS
sudo ufw allow 80
sudo ufw allow 443

# Allow application port
sudo ufw allow 3000

# Enable firewall
sudo ufw enable
```

### Environment Security
```bash
# Secure environment file
sudo chmod 600 /opt/sue-mon/.env.local

# Check file permissions
ls -la /opt/sue-mon/.env.local
```

---

## 📝 Important Notes

### Before Starting
1. **Replace `YOUR_USERNAME`** with your actual GitHub username
2. **Replace `your-server-ip`** with your actual server IP
3. **Replace `yourdomain.com`** with your actual domain (if you have one)
4. **Get your Supabase credentials** from your Supabase dashboard
5. **Get your Paystack credentials** from your Paystack dashboard

### After Setup
1. **Test the website** at your domain or IP
2. **Check admin dashboard** at `/admin`
3. **Add products** through the admin interface
4. **Test payment integration** with Paystack
5. **Monitor logs** for any issues

### Environment Variables Required
```env
NEXT_PUBLIC_SUPABASE_URL=your_supabase_project_url
NEXT_PUBLIC_SUPABASE_ANON_KEY=your_supabase_anon_key
NEXT_PUBLIC_PAYSTACK_PUBLIC_KEY=your_paystack_public_key
```

---

## 🎉 Success Checklist

Once you complete all steps, verify:

- ✅ Website accessible at your domain/IP
- ✅ Admin dashboard working at `/admin`
- ✅ Auto-deployment working (push to GitHub, check logs)
- ✅ Products loading from database
- ✅ Payment integration working
- ✅ Caddy serving the website
- ✅ PM2 managing the application
- ✅ Cron job running every 30 minutes

---

## 📞 Support Commands

If you need help:

```bash
# Check everything status
echo "=== PM2 Status ===" && pm2 status
echo "=== Caddy Status ===" && sudo systemctl status caddy
echo "=== Recent Deployments ===" && tail -10 /opt/sue-mon/deploy.log
echo "=== Application Logs ===" && pm2 logs sue-mon --lines 10
```

---

## 🚀 Your Website is Now Live!

**Congratulations!** Your Sue & Mon website is now:
- 🌐 **Live** at your domain or IP
- 🔄 **Auto-updating** from GitHub every 30 minutes
- 🛡️ **Secure** with Caddy web server
- 📊 **Monitored** with PM2 process manager
- 💳 **Payment-ready** with Paystack integration
- 🗄️ **Database-driven** with Supabase

**Next Steps:**
1. Add your products through the admin dashboard
2. Customize the website content
3. Test the payment system
4. Monitor the auto-deployment logs

Your website will automatically stay updated with any changes you push to GitHub! 🎉 