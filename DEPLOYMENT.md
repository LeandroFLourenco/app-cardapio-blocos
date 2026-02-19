# 🚀 Guia de Deployment - App Cardápio

## Requisitos do Sistema

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+
- Git

---

## Instalação Local

### 1. Clonar o repositório
```bash
git clone https://github.com/seu-usuario/app-cardapio-blocos.git
cd app-cardapio-blocos
```

### 2. Instalar dependências PHP
```bash
composer install
```

### 3. Instalar dependências Node
```bash
npm install
```

### 4. Configurar arquivo .env
```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env`:
```
APP_NAME="Cardápio"
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cardapio
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Criar banco de dados
```bash
mysql -u root -p -e "CREATE DATABASE cardapio;"
```

### 6. Executar migrations
```bash
php artisan migrate
```

### 7. Popular banco de dados (Seeders)
```bash
php artisan db:seed
```

### 8. Compilar assets (Vite)
```bash
npm run dev
```

### 9. Iniciar servidor Laravel
```bash
php artisan serve
```

Acesso: http://localhost:8000

---

## Deployment em Produção

### Servidor: Ubuntu 22.04 + Nginx + MySQL

### 1. SSH no servidor
```bash
ssh usuario@seu-dominio.com
```

### 2. Clonar repo
```bash
cd /var/www
git clone https://github.com/seu-usuario/app-cardapio-blocos.git cardapio
cd cardapio
```

### 3. Instalar dependências
```bash
composer install --optimize-autoloader --no-dev
npm install --production
```

### 4. Configurar .env para produção
```bash
cp .env.example .env
php artisan key:generate

# Editar com dados de produção:
# - APP_DEBUG=false
# - APP_URL=https://seu-dominio.com
# - Credenciais do banco
```

### 5. Permissões de pasta
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 6. Build de assets
```bash
npm run build
```

### 7. Executar migrations
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 8. Cache de produção
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9. Configurar Nginx

Arquivo: `/etc/nginx/sites-available/cardapio`

```nginx
server {
    listen 80;
    server_name seu-dominio.com;
    root /var/www/cardapio/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(?:jpg|jpeg|gif|png|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Ativar site:
```bash
sudo ln -s /etc/nginx/sites-available/cardapio /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 10. SSL com Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d seu-dominio.com
```

### 11. Supervisor (Laravel Queue)

Arquivo: `/etc/supervisor/conf.d/cardapio.conf`

```ini
[program:cardapio-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/cardapio/artisan queue:work
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/cardapio/storage/logs/queue.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
```

### 12. Cron Job para Scheduler

```bash
crontab -e

# Adicionar:
* * * * * cd /var/www/cardapio && php artisan schedule:run >> /dev/null 2>&1
```

---

## Monitoramento

### Logs
```bash
tail -f storage/logs/laravel.log
```

### Backup Automático
```bash
# Adicionar ao cron:
0 2 * * * /usr/local/bin/mysql-backup.sh
```

### Health Check
```bash
curl https://seu-dominio.com/health
```

---

## Troubleshooting

### Erro: 500 Internal Server Error
1. Verificar logs: `tail storage/logs/laravel.log`
2. Verificar permissões de storage e bootstrap
3. Executar: `php artisan config:clear`

### Erro: Base table or view not found
1. Verificar migração: `php artisan migrate:status`
2. Se necessário: `php artisan migrate:refresh --seed`

### Erro: CORS ou Headers
1. Atualizar nginx.conf com headers apropriados
2. Adicionar em app/Http/Middleware/TrustProxies.php

### Banco de dados lento
1. Ativar query logging em .env
2. Adicionar índices nas migrations
3. Usar query caching com Redis

---

## Atualizar em Produção

```bash
cd /var/www/cardapio

# Backup
git stash
mysqldump cardapio > backup_$(date +%s).sql

# Update
git pull origin main
composer install --optimize-autoloader --no-dev
npm install --production && npm run build

# Migrations
php artisan migrate

# Cache
php artisan config:cache
php artisan route:cache

# Restart
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

## Performance Tips

1. **Cache HTTP Headers**
   - Configurar Expires em assets estáticos
   - Adicionar ETag headers

2. **Database**
   - Ativar slow query log
   - Indexar colunas frequentemente consultadas
   - Usar query builder ao invés de SQL raw

3. **Aplicação**
   - Ativar query caching com Redis
   - Usar pagination em listas grandes
   - Lazy load imagens do cardápio

4. **Frontend**
   - Minificar CSS/JS
   - Comprimir imagens com TinyPNG/ImageOptim
   - Usar CDN para assets estáticos

5. **Servidor**
   - Ativar gzip no Nginx
   - Usar HTTP/2
   - Configurar worker_processes adequados

---

## Segurança

- ✅ CSRF Protection (automático com @csrf)
- ✅ XSS Prevention (Blade auto-escapes)
- ✅ SQL Injection Prevention (usar queries builder)
- ✅ Rate Limiting (pode ser adicionado)
- ✅ HTTPS/SSL obrigatório
- ✅ Validação de entrada

Adicionar em produção:
```php
// app/Http/Middleware/SetSecurityHeaders.php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
```

---

## Referências

- [Laravel Documentation](https://laravel.com/docs)
- [Nginx Documentation](https://nginx.org)
- [MySQL Performance](https://dev.mysql.com/doc/refman/8.0/en)
- [Let's Encrypt](https://letsencrypt.org)

---

**Última atualização**: 19 de fevereiro de 2026
