#!/bin/bash

echo "Migrating database and seeding..."

php artisan migrate:fresh --seed

echo "Setup process completed. Your application is ready to use!"
