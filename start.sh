#!/bin/bash
php artisan config:clear
PORT_INT=$(php -r "echo (int)getenv('PORT');")
php artisan serve --host=0.0.0.0 --port=$PORT_INT
