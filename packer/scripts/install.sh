#!/bin/bash

# Name: install.sh
# Description: Install the results site.

mv /tmp/results /var/www/results

cd /var/www/results && phing make

mkdir -p /var/www/results/sites/default/files/tmp
mkdir -p /var/www/results/sites/default/private

chown -R www-data:www-data /var/www/results

# This adds a line to ensure we are loading configuration from
# the file shipped with the parent image.
if [ -f /etc/drupalci/settings.local.php ]; then
    echo "require_once '/etc/drupalci/settings.local.php';" >> /var/www/results/app/sites/default/settings.php
fi
