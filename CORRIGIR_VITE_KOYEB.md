# 🔧 Como Corrigir Erro Vite no Koyeb

## ❌ Erro Original:
```
Vite manifest not found at: /workspace/public/build/manifest.json
```

## ✅ Solução

### 1. Arquivo `build.sh` (JÁ ATUALIZADO ✅)

O arquivo `build.sh` já está correto com:
```bash
#!/bin/bash
composer install --no-interaction --prefer-dist --optimize-autoloader
npm install
npm run build
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### 2. Configurar Build Command no Koyeb

No painel do Koyeb:

1. Vá em **Services** → Selecione seu app
2. Clique em **Settings**
3. Em **Build**, configure:

**Build Command (Opção 1 - Usando build.sh):**
```bash
bash build.sh
```

**OU Build Command (Opção 2 - Direto):**
```bash
composer install --no-interaction --prefer-dist --optimize-autoloader && npm install && npm run build && php artisan config:clear && php artisan view:clear && php artisan route:clear
```

### 3. Release Command (Opcional)

No painel do Koyeb, em **Settings → Deploy**:

**Release Command:**
```bash
php artisan migrate --force && php artisan storage:link
```

## 📦 O que Cada Comando Faz:

### Build:
- `composer install` - Instala dependências PHP
- `npm install` - Instala dependências NPM
- `npm run build` - **Compila os assets (resolve o erro!)**
- `php artisan config:clear` - Limpa cache

### Release (após deploy):
- `php artisan migrate --force` - Roda migrations
- `php artisan storage:link` - Cria link do storage

## ✅ Checklist no Koyeb:

1. **Vá em Services → Settings**
2. **Build Command**: Configure conforme acima
3. **Release Command** (opcional): `php artisan migrate --force && php artisan storage:link`
4. **Fazer novo deploy**

## 🚀 Após Configurar:

1. Faça push para Git (se conectar via Git)
2. OU faça novo upload do código
3. O Koyeb irá executar o build automaticamente
4. Os arquivos `public/build/manifest.json` serão criados

## 🔍 Verificar se Funcionou:

Após o deploy, acesse:
```
http://seu-app.koyeb.app/build/manifest.json
```

Deve retornar um JSON com os assets compilados!

## 📝 Nota Importante

O erro acontece porque o Laravel precisa dos arquivos compilados do Vite. O `npm run build` gera esses arquivos na pasta `public/build/`.

Após configurar o **Build Command** no Koyeb, o erro será resolvido! ✅

