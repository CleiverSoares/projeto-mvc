# 🔒 Como Corrigir Mixed Content (HTTP vs HTTPS)

## ❌ Problema:
```
Mixed Content: The page at 'https://...' was loaded over HTTPS, 
but requested an insecure stylesheet 'http://...'
```

Os assets (CSS/JS) estão sendo carregados via HTTP ao invés de HTTPS!

## ✅ Solução Rápida:

### No Painel do Koyeb:

1. Vá em **Services → Settings → Environment Variables**
2. Adicione ou edite:

**Variável:** `ASSET_URL`  
**Valor:** `https://drab-lauree-code4cancer-096db371.koyeb.app`

**OU** deixe vazio para usar auto-detecção.

### Variável Importante:

**Variável:** `APP_URL`  
**Valor:** `https://drab-lauree-code4cancer-096db371.koyeb.app`

Isso força o Laravel a gerar URLs HTTPS para todos os assets!

## 🔧 Configuração Completa de Variáveis de Ambiente:

No Koyeb, configure estas variáveis:

```env
APP_NAME="Projeto Doar"
APP_ENV=production
APP_KEY=base64:SuaChaveAqui
APP_DEBUG=false
APP_URL=https://drab-lauree-code4cancer-096db371.koyeb.app
ASSET_URL=https://drab-lauree-code4cancer-096db371.koyeb.app

DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

## 🚀 Após Configurar:

1. Reinicie o serviço no Koyeb (Settings → Restart)
2. Acesse novamente o site
3. Os assets vão carregar via HTTPS! ✅

## 📝 Por que isso acontece?

O Laravel gera URLs relativas ou não-seguras por padrão quando:
- `APP_URL` está com `http://`
- `ASSET_URL` não está configurada
- `APP_ENV` não está em `production`

## ✅ Solução Alternativa (Se não funcionar):

Se ainda não funcionar, você pode forçar HTTPS no arquivo `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\URL;

public function boot()
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
}
```

## 🔍 Verificar se Funcionou:

Abra o Developer Tools (F12) → Console
- Não deve aparecer erros "Mixed Content"
- Os arquivos CSS/JS devem carregar via HTTPS

Após configurar `APP_URL` e `ASSET_URL` no Koyeb, o erro vai sumir! 🎉

