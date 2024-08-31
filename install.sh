#!/bin/bash

echo "Generating application key..."

cd backend

echo "Installing composer dependencies..."
composer install

FILE=.env
if [ ! -f "$FILE" ]; then
    echo 'Creating .env file...'
    cp .env.example .env
fi

echo "Generating application key..."
php artisan key:generate

echo "Backend setup completed."

cd ..
cd frontend

echo "Installing npm dependencies..."
npm install

echo "Frontend setup completed."

cd ..
cd backend

echo "Migrating database and seeding..."
php artisan migrate:fresh --seed

echo "Setup process completed. Your application is ready to use!"
