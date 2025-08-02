#!/bin/bash

# Auto-update script for Sue & Mon PHP website
# This script is designed to be run by cron every 30 minutes

# Configuration
PROJECT_DIR="/var/www/sue-mon"
LOG_FILE="/var/www/sue-mon/auto_update.log"
BRANCH="main"

# Colors for output (removed for cron compatibility)
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Error handling
set -e

# Check if project directory exists
if [ ! -d "$PROJECT_DIR" ]; then
    log "ERROR: Project directory not found: $PROJECT_DIR"
    exit 1
fi

# Navigate to project directory
cd "$PROJECT_DIR"

# Check if git repository exists
if [ ! -d ".git" ]; then
    log "ERROR: Git repository not found in $PROJECT_DIR"
    exit 1
fi

# Fetch latest changes
log "Checking for updates..."
git fetch origin

# Check if there are any changes
LOCAL_COMMIT=$(git rev-parse HEAD)
REMOTE_COMMIT=$(git rev-parse origin/$BRANCH)

if [ "$LOCAL_COMMIT" = "$REMOTE_COMMIT" ]; then
    log "No updates found"
    exit 0
fi

# Updates found - start deployment
log "Updates found! Starting deployment..."

# Backup current version
log "Creating backup..."
cp -r "$PROJECT_DIR" "$PROJECT_DIR.backup.$(date +%Y%m%d_%H%M%S)"

# Pull latest changes
log "Pulling latest changes..."
git pull origin $BRANCH

# Set proper permissions for PHP files
log "Setting file permissions..."
find "$PROJECT_DIR" -type f -name "*.php" -exec chmod 644 {} \;
find "$PROJECT_DIR" -type d -exec chmod 755 {} \;

# Restart web server if needed
log "Restarting web server..."
if command -v systemctl &> /dev/null; then
    if systemctl is-active --quiet apache2; then
        systemctl reload apache2
        log "Apache2 reloaded"
    elif systemctl is-active --quiet nginx; then
        systemctl reload nginx
        log "Nginx reloaded"
    fi
fi

# Clean up old backups (keep last 5)
log "Cleaning up old backups..."
cd /var/www
ls -t sue-mon.backup.* | tail -n +6 | xargs -r rm -rf

log "Deployment completed successfully!"
log "New commit: $(git rev-parse --short HEAD)"
log "Deployment time: $(date)" 