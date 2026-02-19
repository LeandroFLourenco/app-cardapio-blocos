# 🍔 App Cardápio Blocos

Uma aplicação web moderna para gerenciar e exibir cardápios de forma responsiva e intuitiva.

[![Laravel](https://img.shields.io/badge/Laravel-11-ff2e21?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777bb4?style=flat-square&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38b2ac?style=flat-square&logo=tailwindcss)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](#license)

## 🚀 Features

- ✅ **Cardápio Responsivo** - Design mobile-first com Tailwind CSS
- ✅ **Carrinho de Compras** - LocalStorage para persistência de dados
- ✅ **Gerenciamento de Produtos** - CRUD completo via ORM Eloquent
- ✅ **Sistema de Pedidos** - Armazenamento em banco de dados
- ✅ **Validação de Dados** - Proteção contra entradas inválidas
- ✅ **Categorias de Blocos** - Organização de produtos por categoria
- ✅ **Otimização de Imagens** - Suporte a diferentes resoluções
- ✅ **Dashboard Intuitivo** - Interface amigável para usuários

## 📋 Requisitos

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+
- npm ou yarn

## 🛠️ Instalação Rápida

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/app-cardapio-blocos.git
cd app-cardapio-blocos
```

### 2. Instale as dependências
```bash
composer install
npm install
```

### 3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure seu banco de dados
Edite o arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cardapio
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Configure o banco e popule dados
```bash
php artisan migrate
php artisan db:seed
```

### 6. Compile os assets
```bash
npm run dev
```

### 7. Inicie o servidor
```bash
php artisan serve
```

Acesse: http://localhost:8000

## 📁 Estrutura de Diretórios

```
app/
├── Models/
│   ├── Product.php      # Modelo de Produtos
│   ├── Order.php        # Modelo de Pedidos
│   ├── User.php         # Modelo de Usuários
│   └── Bloco.php        # Modelo de Blocos/Categorias
├── Http/
│   └── Controllers/
│       ├── CardapioController.php
│       └── HomeController.php
└── Providers/

database/
├── migrations/          # Estrutura do banco
├── factories/           # Factory para testes
└── seeders/             # Dados de exemplo

resources/
├── views/
│   ├── layouts/app.blade.php
│   ├── home.blade.php
│   └── cardapio.blade.php
├── css/
│   └── cardapio.css
└── js/
    └── cardapio.js

routes/
├── web.php              # Rotas web
└── api.php              # Rotas API

tests/
├── Feature/             # Testes de integração
└── Unit/                # Testes unitários
```

## 🎯 Rotas Disponíveis

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/` | Página inicial |
| GET | `/cardapio` | Listar produtos do cardápio |
| POST | `/pedidos` | Criar novo pedido |

## 🗄️ Modelos de Dados

### Product
```php
- id (PK)
- nome (string, required)
- descricao (text)
- imagem (string)
- preco (decimal)
- quantidade (integer)
- ativo (boolean)
- bloco_id (FK)
- timestamps
```

### Order
```php
- id (PK)
- user_id (FK, nullable)
- itens (json)
- total (decimal)
- status (string) // pendente, confirmado, entregue
- observacoes (text)
- timestamps
```

### Bloco
```php
- id (PK)
- nome (string)
- descricao (text)
- timestamps
```

## 🧪 Testes

### Executar todos os testes
```bash
php artisan test
```

### Executar testes específicos
```bash
php artisan test --filter=CardapioTest
php artisan test --filter=ProductTest
```

### Testes implementados
- ✅ Cardápio retorna página com sucesso
- ✅ Produtos inativos não são mostrados
- ✅ Validação de pedidos
- ✅ Cálculo correto de totais
- ✅ Limites de caracteres em observações

## 🔒 Segurança

- ✅ CSRF Protection (automático)
- ✅ XSS Prevention (Blade auto-escapes)
- ✅ SQL Injection Protection (Query Builder)
- ✅ Mass Assignment Protection
- ✅ Input Validation
- ✅ Rate Limiting (recomendado em produção)

## 🚀 Deploy

Para instruções completas de deployment em produção, veja [DEPLOYMENT.md](DEPLOYMENT.md)

### Quick Deploy (Heroku)
```bash
heroku create seu-app-cardapio
heroku addons:create cleardb:ignite
git push heroku main
heroku run php artisan migrate --seed
```

## 📚 Documentação Adicional

- [Melhorias Implementadas](MELHORIAS.md) - Detalhes técnicos de todas as mudanças
- [Deployment Guide](DEPLOYMENT.md) - Produção em servidor Linux
- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)

## 🛠️ Desenvolvimento

### Compilar assets em desenvolvimento
```bash
npm run dev
```

### Compilar para produção
```bash
npm run build
```

### Usar Tinker (CLI)
```bash
php artisan tinker
>>> Product::count()
>>> Order::all()
```

### Limpar cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 📊 Performance

- Lazy loading de imagens
- Caching de routes e config em produção
- DB query optimization com indexing
- LocalStorage para carrinho (sem requisições ao servidor)
- Minificação de CSS/JS com Vite

## 🤝 Contribuindo

1. Faça um Fork do projeto
2. Crie uma branch com sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Changelog

### v1.0.0 (2026-02-19)
- ✨ Lançamento inicial
- ✨ Sistema completo de cardápio
- ✨ Carrinho com LocalStorage
- ✨ Design responsivo com Tailwind
- ✨ Testes unitários e de integração

## 📄 License

Este projeto está sob a licença MIT. Veja [LICENSE](LICENSE) para detalhes.

## 👨‍💻 Autor

Desenvolvido com ❤️ em Laravel

## 📞 Suporte

Para issues e dúvidas, abra uma [issue no GitHub](https://github.com/seu-usuario/app-cardapio-blocos/issues)

---

<p align="center">
  Made with ❤️ by <strong>Your Name</strong>
  <br/>
  <em>Last updated: February 19, 2026</em>
</p>
