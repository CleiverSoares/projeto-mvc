# 🚀 Guia de Deploy no Koyeb

## 📋 Problema Identificado

O erro ocorreu porque o **Procfile** estava configurado para Heroku, mas você está usando **Koyeb**.

## ✅ Solução Implementada

Foi criado um **Procfile** correto para Koyeb:

```
web: vendor/bin/heroku-php-apache2 public/
```

## 📦 Arquivos Criados para Koyeb

### 1. **Procfile** (JÁ CORRIGIDO)
```
web: vendor/bin/heroku-php-apache2 public/
```

### 2. **build.sh** (Script de Build)
```bash
#!/bin/bash
composer install --no-interaction --prefer-dist --optimize-autoloader
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### 3. **.htaccess** (Redirecionamento)
Arquivo já incluído no Laravel para Apache

## 🔧 Passos para Deploy no Koyeb

### 1. Criar arquivo `.koyeb.yaml` (se necessário)

Crie um arquivo na raiz do projeto:

```yaml
type: web
build: composer install --no-interaction --prefer-dist --optimize-autoloader && php artisan config:clear && php artisan view:clear && php artisan route:clear
run: vendor/bin/heroku-php-apache2 public/
```

### 2. Variáveis de Ambiente no Koyeb

Configure essas variáveis no painel do Koyeb:

```env
# Aplicação
APP_NAME="Projeto Doar"
APP_ENV=production
APP_KEY=base64:SuaChaveAqui
APP_DEBUG=false
APP_URL=https://seu-app.koyeb.app

# Banco de Dados (use banco na nuvem como PlanetScale, Railway, etc.)
DB_CONNECTION=mysql
DB_HOST=seu-host.com
DB_PORT=3306
DB_DATABASE=projeto_doar
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 3. Comandos Iniciais (Release Phase)

No painel do Koyeb, configure o **Release Command**:

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🎯 Checklist de Deploy

### Antes de Fazer Push:
- [ ] Arquivo `Procfile` correto
- [ ] Arquivo `build.sh` criado
- [ ] Variáveis de ambiente configuradas no Koyeb
- [ ] Banco de dados externo configurado
- [ ] `APP_KEY` definida

### No Primeiro Deploy:
- [ ] Upload do projeto (GitHub ou upload direto)
- [ ] Aguardar build completar
- [ ] Verificar logs em caso de erro
- [ ] Criar usuário admin via tinker

## 🔍 Comandos Importantes

### Para verificar logs no Koyeb:
```bash
# No painel do Koyeb, vá em "Logs"
# Ou use CLI do Koyeb:
koyeb logs <deployment-id>
```

### Para acessar o tinker no Koyeb (se disponível):
```bash
koyeb ssh <deployment-id>
php artisan tinker
```

### Criar usuário admin:
```bash
# Via Koyeb CLI ou painel web
php artisan tinker

# Dentro do tinker:
App\Models\User::create([
    'name' => 'Administrador',
    'email' => 'admin@projetodoar.com',
    'password' => bcrypt('sua_senha_forte'),
    'role' => 'admin'
]);
exit
```

## 🚨 Solução de Problemas

### Erro: "Command not found"
- Verifique se o `Procfile` está na raiz do projeto
- Verifique se o caminho está correto: `vendor/bin/heroku-php-apache2`

### Erro: "Storage link failed"
Adicione no **Release Command**:
```bash
php artisan storage:link
```

### Erro: "Database connection refused"
- Verifique variáveis `DB_*` no Koyeb
- Certifique-se que o banco permite conexões externas
- Use banco na nuvem (PlanetScale, Railway, etc.)

### Erro: "APP_KEY not found"
No **Release Command**, adicione:
```bash
php artisan key:generate --force
```

## 📝 Configuração Completa do Release Command

No painel do Koyeb, configure o **Release Command** assim:

```bash
php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## 🔗 Links Úteis

- [Koyeb Documentation](https://www.koyeb.com/docs)
- [Laravel on Koyeb](https://www.koyeb.com/docs/deploy/deploy-laravel)
- [PHP Buildpacks](https://github.com/heroku/heroku-buildpack-php)

## ✅ Comandos Prontos para Copiar

### 1. Procfile
```
web: vendor/bin/heroku-php-apache2 public/
```

### 2. Release Command (no painel Koyeb)
```bash
php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### 3. Variáveis de Ambiente Mínimas
```
APP_NAME="Projeto Doar"
APP_ENV=production
APP_KEY=(gerar com key:generate)
APP_DEBUG=false
APP_URL=https://seu-app.koyeb.app
DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

Pronto! Agora o Koyeb vai conseguir fazer o deploy corretamente! 🎉

