#!/bin/bash

# Name: install.sh
# Description: Install the results site.

mv /tmp/results /var/www/results

cd /var/www/results && phing build

mkdir -p /var/www/results/sites/default/files/tmp
mkdir -p /var/www/results/sites/default/private

chown -R www-data:www-data /var/www/results

# This adds a line to ensure we are loading configuration from
# the file shipped with the parent image.
echo "if (file_exists('/etc/drupalci/settings.local.php')) {
  include '/etc/drupalci/settings.local.php';
}
" >> /var/www/results/app/sites/default/settings.php
