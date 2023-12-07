#!/bin/bash

# Change to your Laravel project directory
cd /home/muslvcna/public_html/application
echo hello

# Run Laravel's schedule:run command
php artisan schedule:run
