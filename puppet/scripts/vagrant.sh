#!/bin/bash

# Script: vagrant.sh
# Author: Nick Schuch

DIR='/var/www/results/puppet'

cd $DIR && sh scripts/provision.sh
