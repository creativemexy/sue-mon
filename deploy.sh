#!/bin/bash

# Auto-deployment script for Sue & Mon website
# This script checks for GitHub updates and deploys automatically

# Configuration
PROJECT_DIR="/opt/sue-mon"
LOG_FILE="/opt/sue-mon/deploy.log"
BRANCH="main"
REPO_URL="https://github.com/yourusername/sue-mon.git"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Log function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Error handling
set -e

# Check if project directory exists
if [ ! -d "$PROJECT_DIR" ]; then
    log "${RED}Project directory not found. Cloning repository...${NC}"
    mkdir -p /opt
    cd /opt
    git clone "$REPO_URL" sue-mon
    cd sue-mon
    npm install
    npm run build
    log "${GREEN}Initial setup completed${NC}"
    exit 0
fi

# Navigate to project directory
cd "$PROJECT_DIR"

# Check if git repository exists
if [ ! -d ".git" ]; then
    log "${RED}Git repository not found. Re-cloning...${NC}"
    cd /opt
    rm -rf sue-mon
    git clone "$REPO_URL" sue-mon
    cd sue-mon
    npm install
    npm run build
    log "${GREEN}Repository re-cloned successfully${NC}"
    exit 0
fi

# Fetch latest changes
log "${YELLOW}Checking for updates...${NC}"
git fetch origin

# Check if there are any changes
LOCAL_COMMIT=$(git rev-parse HEAD)
REMOTE_COMMIT=$(git rev-parse origin/$BRANCH)

if [ "$LOCAL_COMMIT" = "$REMOTE_COMMIT" ]; then
    log "${GREEN}No updates found${NC}"
    exit 0
fi

# Updates found - start deployment
log "${YELLOW}Updates found! Starting deployment...${NC}"

# Backup current version
log "Creating backup..."
cp -r "$PROJECT_DIR" "$PROJECT_DIR.backup.$(date +%Y%m%d_%H%M%S)"

# Pull latest changes
log "Pulling latest changes..."
git pull origin $BRANCH

# Install dependencies
log "Installing dependencies..."
npm install

# Build the application
log "Building application..."
npm run build

# Restart the application
log "Restarting application..."
if command -v pm2 &> /dev/null; then
    pm2 restart sue-mon || pm2 start npm --name "sue-mon" -- start
else
    log "${YELLOW}PM2 not found. Please install PM2 for process management${NC}"
fi

# Clean up old backups (keep last 5)
log "Cleaning up old backups..."
cd /opt
ls -t sue-mon.backup.* | tail -n +6 | xargs -r rm -rf

log "${GREEN}Deployment completed successfully!${NC}"
log "New commit: $(git rev-parse --short HEAD)"
log "Deployment time: $(date)"
