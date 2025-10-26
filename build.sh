#!/bin/bash
echo "📦 Instalando dependências do PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "📦 Instalando dependências do NPM..."
npm install

echo "🔨 Compilando assets (CSS/JS)..."
npm run build

echo "🧹 Limpando cache..."
php artisan config:clear
php artisan view:clear
php artisan route:clear

