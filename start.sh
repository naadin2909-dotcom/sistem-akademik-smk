#!/bin/bash
php artisan config:clear
PORT_INT=$(php -r "echo (int)getenv('PORT');")
php -S 0.0.0.0:$PORT_INT -t public/ public/router.php
