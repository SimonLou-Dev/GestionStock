#!/bin/bash

printf "Configure listen mode of php-fpm socket\n\n"
echo "listen.mode = 666" >> /var/run/php/php8.1-fpm.sock

printf "\n\nStarting PHP 8.1 daemon...\n\n"
service php8.1-fpm start

printf "Starting Nginx...\n\n"
nginx -g "daemon off;"


