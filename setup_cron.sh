#!/bin/bash

# Setup script for automatic updates via cron
# This script sets up a cron job to check for updates every 30 minutes

# Configuration
PROJECT_DIR="/var/www/sue-mon"
CRON_USER="www-data"  # Change this to your web server user

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo "${YELLOW}Setting up automatic updates for Sue & Mon PHP website...${NC}"

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    echo "${RED}This script must be run as root to set up cron jobs${NC}"
    exit 1
fi

# Make the auto_update script executable
if [ -f "auto_update.sh" ]; then
    chmod +x auto_update.sh
    echo "${GREEN}Made auto_update.sh executable${NC}"
else
    echo "${RED}auto_update.sh not found in current directory${NC}"
    exit 1
fi

# Create the cron job entry
CRON_JOB="*/30 * * * * /var/www/sue-mon/auto_update.sh"

# Check if cron job already exists
if crontab -u "$CRON_USER" -l 2>/dev/null | grep -q "auto_update.sh"; then
    echo "${YELLOW}Cron job already exists for user $CRON_USER${NC}"
else
    # Add the cron job
    (crontab -u "$CRON_USER" -l 2>/dev/null; echo "$CRON_JOB") | crontab -u "$CRON_USER" -
    echo "${GREEN}Added cron job for user $CRON_USER${NC}"
fi

# Create log directory
mkdir -p "$PROJECT_DIR"
touch "$PROJECT_DIR/auto_update.log"
chown "$CRON_USER:$CRON_USER" "$PROJECT_DIR/auto_update.log"

echo "${GREEN}Setup completed!${NC}"
echo "${YELLOW}The website will now check for updates every 30 minutes${NC}"
echo "${YELLOW}Logs will be written to: $PROJECT_DIR/auto_update.log${NC}"
echo ""
echo "${YELLOW}To view the cron job:${NC}"
echo "crontab -u $CRON_USER -l"
echo ""
echo "${YELLOW}To remove the cron job:${NC}"
echo "crontab -u $CRON_USER -r" 