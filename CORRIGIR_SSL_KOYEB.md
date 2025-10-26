# 🔒 Como Corrigir Aviso SSL no Koyeb

## ⚠️ Problema Identificado

O aviso "As informações que está prestes a enviar não são seguras" aparece porque o **HTTPS não está habilitado**.

## ✅ Solução no Koyeb

### Opção 1: Usar Domínio do Koyeb com SSL (Mais Rápido)

1. No painel do Koyeb, vá em **Services**
2. Selecione seu serviço
3. Em **Domains**, verifique se está usando: `https://seu-app.koyeb.app`
4. O Koyeb já fornece SSL gratuito automaticamente!

### Opção 2: Configurar Domínio Personalizado com SSL

1. No painel do Koyeb, vá em **Services → Domains**
2. Adicione seu domínio personalizado
3. Configure os registros DNS:
   - **Tipo A**: aponta para o IP do Koyeb
   - **Tipo CNAME**: aponta para seu-app.koyeb.app
4. O Koyeb irá provisionar o SSL automaticamente via Let's Encrypt

## 🔧 Configurar Laravel para Forçar HTTPS

### 1. No arquivo `.env` (no Koyeb):

```env
APP_URL=https://seu-app.koyeb.app
```

### 2. Adicionar Middleware para forçar HTTPS

Crie o arquivo `app/Http/Middleware/ForceHttps.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    public function handle($request, Closure $next)
    {
        if (config('app.env') === 'production' && !$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
```

### 3. Registrar no `app/Http/Kernel.php`:

```php
protected $middleware = [
    // ... outros middlewares
    \App\Http\Middleware\ForceHttps::class,
];
```

**OU** no Laravel 11, crie o arquivo `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\ForceHttps::class);
})
```

## 🚀 Solução Rápida (Temporária)

Se você não pode configurar HTTPS agora, no Koyeb:

1. **Temporariamente**, os usuários podem clicar em "Enviar mesmo assim"
2. O formulário vai funcionar, mas a conexão não será segura
3. **Recomendado**: Configure HTTPS o quanto antes

## ✅ Checklist para SSL

- [ ] URL começa com `https://`
- [ ] Variável `APP_URL` com HTTPS no `.env`
- [ ] Domínio personalizado configurado (se usar)
- [ ] Certificado SSL ativo no Koyeb
- [ ] Middleware ForceHttps configurado (opcional)

## 📝 Nota Importante

O Koyeb fornece **SSL grátis automaticamente** para todos os apps na plataforma!

Você só precisa garantir que:
1. Use a URL `https://seu-app.koyeb.app`
2. Configure o `APP_URL` corretamente

Verifique se está acessando via `https://` e não `http://`! 🔒

