# 📦 Comandos para Deploy no Servidor

## 1️⃣ Pré-requisitos no Servidor

```bash
# Instalar PHP e extensões
sudo apt update
sudo apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd

# Instalar Composer globalmente
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar NPM (Node.js)
sudo apt install nodejs npm
```

## 2️⃣ Upload dos Arquivos

```bash
# Copiar todos os arquivos do projeto para o servidor
# (Use FTP, SCP, ou Git)
scp -r projeto-doar-laravel-mvc/ usuario@servidor:/var/www/
```

## 3️⃣ Configurações no Servidor

```bash
# 1. Entrar na pasta do projeto
cd /var/www/projeto-doar-laravel-mvc

# 2. Instalar dependências do Composer
composer install --no-dev --optimize-autoloader

# 3. Instalar dependências do NPM
npm install

# 4. Compilar assets (CSS/JS)
npm run build

# 5. Copiar arquivo de configuração
cp .env.example .env

# 6. Editar arquivo .env (configurar banco, URL, etc.)
nano .env
```

### Configurações importantes no .env:

```env
APP_NAME="Projeto Doar"
APP_ENV=production
APP_KEY=          # Será gerado no próximo passo
APP_DEBUG=false
APP_URL=https://seudominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projeto_doar
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

## 4️⃣ Gerar Chave da Aplicação e Configurações

```bash
# 7. Gerar chave da aplicação
php artisan key:generate

# 8. Criar link simbólico do storage
php artisan storage:link

# 9. Criar cache de configurações
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5️⃣ Migração do Banco de Dados

```bash
# 10. Executar migrations
php artisan migrate --force

# 11. (Opcional) Popular banco com dados de exemplo
php artisan db:seed --force
```

## 6️⃣ Permissões de Arquivos

```bash
# 12. Dar permissões corretas
sudo chown -R www-data:www-data /var/www/projeto-doar-laravel-mvc
sudo chmod -R 755 /var/www/projeto-doar-laravel-mvc
sudo chmod -R 775 /var/www/projeto-doar-laravel-mvc/storage
sudo chmod -R 775 /var/www/projeto-doar-laravel-mvc/bootstrap/cache
```

## 7️⃣ Configuração do Nginx ou Apache

### Para Nginx (recomendado):

```bash
sudo nano /etc/nginx/sites-available/projeto-doar
```

**Conteúdo do arquivo:**
```nginx
server {
    listen 80;
    server_name seudominio.com www.seudominio.com;
    root /var/www/projeto-doar-laravel-mvc/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Ativar site
sudo ln -s /etc/nginx/sites-available/projeto-doar /etc/nginx/sites-enabled/

# Testar configuração
sudo nginx -t

# Reiniciar Nginx
sudo systemctl restart nginx
```

### Para Apache:

```bash
sudo nano /etc/apache2/sites-available/projeto-doar.conf
```

**Conteúdo:**
```apache
<VirtualHost *:80>
    ServerName seudominio.com
    DocumentRoot /var/www/projeto-doar-laravel-mvc/public

    <Directory /var/www/projeto-doar-laravel-mvc/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/projeto-doar-error.log
    CustomLog ${APACHE_LOG_DIR}/projeto-doar-access.log combined
</VirtualHost>
```

```bash
# Ativar módulos necessários
sudo a2enmod rewrite
sudo a2ensite projeto-doar

# Reiniciar Apache
sudo systemctl restart apache2
```

## 8️⃣ Criar Usuário Administrador

```bash
# Criar seeder ou usar tinker
php artisan tinker

# Dentro do tinker:
App\Models\User::create([
    'name' => 'Administrador',
    'email' => 'admin@projetodoar.com',
    'password' => bcrypt('senha_forte'),
    'role' => 'admin'
]);
exit
```

## ✅ Checklist Completo

```bash
# Executar todos os comandos na ordem:
cd /var/www/projeto-doar-laravel-mvc

# Dependências
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Configurações
cp .env.example .env
nano .env  # Configure banco e URL
php artisan key:generate
php artisan storage:link

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Banco de dados
php artisan migrate --force
php artisan db:seed --force  # Opcional

# Permissões
sudo chown -R www-data:www-data /var/www/projeto-doar-laravel-mvc
sudo chmod -R 755 /var/www/projeto-doar-laravel-mvc
sudo chmod -R 775 /var/www/projeto-doar-laravel-mvc/storage
sudo chmod -R 775 /var/www/projeto-doar-laravel-mvc/bootstrap/cache

# Reiniciar serviços
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx  # ou apache2
```

## 🔄 Comandos para Atualizar (Futuro)

```bash
cd /var/www/projeto-doar-laravel-mvc

# Atualizar código
git pull  # se usar Git

# Atualizar dependências
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recompilar cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
php artisan migrate --force

# Permissões
sudo chmod -R 775 storage bootstrap/cache
```

## 🚨 Troubleshooting

### Erro de permissões:
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Erro "No application encryption key":
```bash
php artisan key:generate
php artisan config:cache
```

### Storage não encontrado:
```bash
php artisan storage:link
sudo chmod -R 775 storage
```

### Cache de rotas antigo:
```bash
php artisan route:clear
php artisan route:cache
```

## 📝 Notas Importantes

1. **Senha do banco**: Use uma senha forte
2. **APP_DEBUG**: Deve estar `false` em produção
3. **APP_URL**: Deve ser a URL completa do servidor
4. **SSL**: Considere usar Let's Encrypt para HTTPS
5. **Backup**: Configure backups automáticos do banco de dados

