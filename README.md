<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
</p>

# App Cardápio Blocos

Sistema web para gerenciamento de cardápios por blocos, desenvolvido com PHP e Laravel, com foco em organização, simplicidade e boas práticas de desenvolvimento.

---

## Sobre o Projeto

O App Cardápio Blocos é uma aplicação web que permite cadastrar, organizar e gerenciar cardápios divididos por blocos ou categorias.

A proposta do sistema é oferecer uma estrutura simples, porém escalável, utilizando a arquitetura MVC do Laravel. O projeto pode evoluir para um sistema mais robusto, com autenticação, controle de usuários e geração de relatórios.

---

## Tecnologias Utilizadas

- PHP 8+
- Laravel 11+
- MySQL
- Blade (Template Engine)
- Composer
- Git

---

## Estrutura do Projeto

```
app-cardapio-blocos/
│
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
└── README.md
```

O projeto segue a estrutura padrão do Laravel, mantendo separação clara entre regras de negócio, rotas, controladores e visualizações.

---

## Como Executar o Projeto

### 1. Clonar o repositório

```
git clone https://github.com/seu-usuario/app-cardapio-blocos.git
cd app-cardapio-blocos
```

### 2. Instalar as dependências

```
composer install
```

### 3. Configurar o ambiente

Copie o arquivo de exemplo:

```
cp .env.example .env
```

Gere a chave da aplicação:

```
php artisan key:generate
```

Configure as credenciais do banco de dados no arquivo `.env`:

```
DB_DATABASE=nome_do_banco
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Executar as migrations

```
php artisan migrate
```

### 5. Iniciar o servidor local

```
php artisan serve
```

A aplicação estará disponível em:

```
http://127.0.0.1:8000
```

---

## Banco de Dados

A estrutura do banco é controlada por migrations do Laravel, permitindo versionamento e organização da estrutura das tabelas.

---

## Funcionalidades

- Cadastro de cardápios
- Organização por blocos ou categorias
- Edição e atualização de registros
- Exclusão de registros
- Visualização estruturada dos dados

---

## Melhorias Futuras

- Implementação de autenticação de usuários
- Controle de permissões
- Exportação de cardápios em PDF
- Interface responsiva
- Filtros por data e categoria

---

## Autor

Leandro Fco.

---

## Licença

Projeto desenvolvido para fins de estudo e evolução profissional.

