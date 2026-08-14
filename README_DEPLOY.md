# 🚀 Guia de Deploy - E-kits no Render com Supabase

## 📋 Variáveis de Ambiente para o Render

Copie e cole estas variáveis no painel do Render (Settings → Environment Variables):

### **Obrigatórias:**

```bash
APP_NAME="E-kits"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:SUA_CHAVE_GERADA_AQUI==
APP_URL=https://seu-site-no-render.onrender.com

DB_CONNECTION=pgsql
DB_HOST=db.xxxxxxxx.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.seu-projeto
DB_PASSWORD=sua-senha-supabase

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=local
```

### **Opcionais (para email e outros serviços):**

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ekits.com
MAIL_FROM_NAME="E-kits"
```

---

## 🔑 Como Gerar APP_KEY

Execute este comando PHP para gerar uma chave única:

```php
<?php echo 'base64:' . base64_encode(random_bytes(32)); ?>
```

Ou use este site: https://generate-secret.vercel.app/32

---

## 🗄️ Configurar Supabase

1. Acesse https://supabase.com
2. Crie um novo projeto
3. Vá em **Settings → Database**
4. Copie as informações:
   - **Host**: `db.xxxxxxxx.supabase.co`
   - **Database**: `postgres`
   - **User**: `postgres.seu-projeto`
   - **Password**: (a senha que você definiu)
   - **Port**: `5432`

5. Vá em **SQL Editor** e execute o arquivo `database.sql` da pasta `/workspace/Files/install/`

---

## 🚀 Deploy no Render

### Passo 1: Preparar Repositório

Certifique-se de que seu código está no GitHub/GitLab.

### Passo 2: Criar Web Service no Render

1. Acesse https://render.com
2. Clique em **New +** → **Web Service**
3. Conecte seu repositório
4. Configure:
   - **Name**: `ekits` (ou outro nome)
   - **Region**: Escolha a mais próxima dos seus usuários
   - **Branch**: `main` ou `master`
   - **Root Directory**: Deixe em branco
   - **Runtime**: `Docker`
   - **Build Command**: Deixe em branco (usará Dockerfile)
   - **Start Command**: Deixe em branco (usará CMD do Dockerfile)
   - **Instance Type**: Free ou pago conforme necessidade

### Passo 3: Adicionar Variáveis de Ambiente

No painel do serviço, vá em **Environment** e adicione todas as variáveis listadas acima.

### Passo 4: Deploy

1. Clique em **Create Web Service**
2. Aguarde o build (pode levar 5-10 minutos)
3. Após deploy, acesse a URL fornecida

---

## 🔧 Pós-Deploy

### Acessar Painel Admin

URL: `https://seu-site.onrender.com/admin`

**Login padrão:**
- Email: `admin@site.com`
- Senha: Verifique no banco de dados ou resete via SQL

### Resetar Senha do Admin (se necessário)

No SQL Editor do Supabase:

```sql
UPDATE admins 
SET password = '$2y$12$vc.c.pNxefhOjFzLFNMEW.16i/h1vQCigtZeTLDY12QlIlS0KTWbm' 
WHERE email = 'admin@site.com';
```

Senha temporária: `123456`

---

## ⚠️ Problemas Comuns

### Erro de Migração
Se as migrations falharem, execute manualmente via SSH ou terminal do Render:
```bash
php artisan migrate --force
```

### Erro de Permissão
Certifique-se de que as pastas `storage/` e `bootstrap/cache/` têm permissões corretas (já configurado no Dockerfile).

### Timeout no Build
O build pode demorar no plano free. Se falhar, tente novamente.

### Banco de Dados não Conecta
Verifique:
- Host, usuário e senha estão corretos
- O banco `postgres` existe no Supabase
- As tabelas foram criadas (importe o `database.sql`)

---

## 📁 Estrutura do Projeto

```
/workspace
├── Dockerfile              # Configuração Docker para Render
├── Files/
│   ├── index.php          # Ponto de entrada principal
│   ├── .htaccess          # Configuração Apache
│   ├── core/              # Laravel 11
│   │   ├── app/
│   │   ├── config/
│   │   ├── database/
│   │   └── ...
│   └── install/
│       └── database.sql   # Script SQL completo
└── README_DEPLOY.md       # Este arquivo
```

---

## 💡 Dicas

1. **Backup**: Faça backup regular do banco no Supabase
2. **Monitoramento**: Use logs do Render para debug
3. **Performance**: Considere upgrade para plano pago se tiver muito tráfego
4. **SSL**: Render fornece HTTPS automaticamente
5. **Domínio Customizado**: Configure em Settings → Custom Domains

---

## 🆘 Suporte

Se encontrar erros, verifique:
1. Logs no Render Dashboard
2. Configuração das variáveis de ambiente
3. Conexão com Supabase
4. Se o `database.sql` foi importado corretamente

Boa sorte com seu deploy! 🎉
